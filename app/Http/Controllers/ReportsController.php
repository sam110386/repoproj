<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\ReportsFiles;
use Mail;
use App\Helpers\CommonMethod;
use Illuminate\Support\Facades\Response;
class ReportsController extends Controller
{
	private $profile;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
		$this->profile = Auth::user();
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		
		$profile = Auth::user();
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		$pageData = ['title' => 'Reports','profile' => $profile];
		

		$reportsQuery = Report::where('institute_id','=', $profile->id)->orderBy('id', 'DESC');
		if($request->filled('report_category')){
			$reportsQuery->where('report_category','=', $request->input('report_category'));
		}
		
		if($request->filled('start')){
			$m_start = date_create($request->input('start'));//->modify('first day of this month');
		} else {
			$m_start = '';//date_create()->modify('first day of this month');
		}
		if($request->filled('end')){
			$m_end = date_create($request->input('end'));//->modify('last day of this month');
		} else {
			$m_end ='';//date_create()->modify('last day of this month');
		}
		$reportsQuery->where(function ($query) use ($m_start, $m_end){
			$query->where(function ($query) use ($m_start, $m_end){
				if(!empty($m_start))
				$query->where('created_at', '>=', $m_start);
				if(!empty($m_end))
				$query->where('created_at', '<=', $m_end);
			});
		});
		$reports = $reportsQuery->paginate(50);
		return view(
			'Report.index',
			[
				'title' => 'Reports',
				'profile' => $profile,
				'reports' => $reports,
				'request' => $request
            ]
		);
	}
	/**view action **/
    public function view($id)
	{
		
		$profile = Auth::user();
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		$pageData = ['title' => 'Reports','profile' => $profile];
		$report = Report::where('id','=',$id)->where('institute_id','=',$profile->id)->first();
		$reportfiles=ReportsFiles::where('report_id','=',$id)->get();
		return view(
			'Report.view',
			[
				'title' => 'Reports',
				'profile' => $profile,
				'report' => $report,
				'reportfiles'=>$reportfiles
            ]
		);
	}

	/**add action**/
	public function add(){
		$profile = Auth::user();
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		$pageData = ['title' => 'Add Report','profile' => $profile];
		return view('Report.add',$pageData);
	}

	public function save(Request $request){
		
		$profile = Auth::user();
		$data=$request->all();	
		$valid = request()->validate([
			'report_category' => 'required',
			'submission_period' => 'required',
			'total_capital' => 'required|nullable|numeric',
			'total_assest' => 'required|nullable|numeric',
			'total_liability' => 'required|nullable|numeric',
			'loan_advance' => 'required|nullable|numeric',
			'customer_deposits' => 'required|nullable|numeric',
			'profit_before_tax' => 'required|nullable|numeric',
			'return_average_assets' => 'required|nullable|numeric',
			'return_equity' => 'required|nullable|numeric',			
			//'files' => 'mimes:jpeg,png,gif,pdf,doc,docx'
		]);	
		$submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
		$submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;		
		$report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;
		
		//check if already submitted
		$existObj=Report::where('institute_id','=',$profile->id)->where('report_category','=',$data['report_category']);
		if($data['report_category']=="Monthly"){
			$existObj->where('submission_period','=',$data['submission_period']);
		}
		if($data['report_category']=="Quaterly"){
			$existObj->where('submission_quater','=',$data['submission_period']);
		}
		if($data['report_category']=="Audited"){
			$existObj->where('report_year','=',$data['submission_period']);
		}
		if($existObj->exists()){
			//echo "<pre>";print_r($$existObj->get());die;
			return back()->with('error','Report already submitted for selected period');	
		}
		$report = new Report;
		$report->institute_id =$profile->id;
		$report->report_category = $data['report_category'];
		$report->submission_period = $submission_period ;
		$report->submission_quater = $submission_quater ;
		$report->report_year = !empty($report_year)?$report_year:date('Y');
		$report->total_capital = $data['total_capital'];
		$report->total_assest  = $data['total_assest'];
		$report->total_liability = $data['total_liability'];
		$report->loan_advance = $data['loan_advance'];
		$report->customer_deposits = $data['customer_deposits'];
		$report->profit_before_tax = $data['profit_before_tax'];
		$report->return_average_assets = $data['return_average_assets'];
		$report->return_equity = $data['return_equity'];	

		if($report->save()){								

			foreach ($request->files as $key => $attFiles) {
				foreach ($attFiles as $fileData) {				
					if($fileData && $fileData->isValid()){
						$filename = time().'-'.$fileData->getClientOriginalName();
						$file = Storage::disk('user_docuploads')->putFileAs('',$fileData,$filename);

						$reportFiles = new ReportsFiles;
						$reportFiles->report_id =  $report->id;				 
						$reportFiles->filename = $file;
						$reportFiles->save(); 		
					}					
				}
			}
			//notifyt to Admin
			//$this->notifytoadmin($profile, $data);

		}
		
		return redirect('account/report')->with('success','Report submitted successfully');			
	}
	
	protected function notifytoadmin($profile, $data){
		$submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
		$submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;		
		$report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;

		switch ($submission_period):
			case 1:
			$subm_period = "January";
			break;
			case 2:
			$subm_period =  "February";
			break;
			case 3:
			$subm_period = "March";
			break;				
			case 4:
			$subm_period = "April";
			break;
			case 5:
			$subm_period = "May";
			break;
			case 6:
			$subm_period = "June";
			break;
			case 7:
			$subm_period = "July";
			break;
			case 8:
			$subm_period = "August";
			break;
			case 9:
			$subm_period = "September";
			break;
			case 10:
			$subm_period = "October";
			break;
			case 11:
			$subm_period = "November";
			break;
			case 12:
			$subm_period = "December";
			break;
			default:
			$subm_period = "";
		endswitch;	

		switch ($submission_quater):
			case 1:
			$subm_quater = "Q1";
			break;
			case 2:
			$subm_quater = "Q2";
			break;
			case 3:
			$subm_quater = "Q3";
			break;
			case 4:
			$subm_quater = "Q4";
			break;	
			default:
			$subm_quater = "";
		endswitch;	
		
		if($subm_period){
			$emailSubmReport  = $subm_period;				
		}else if($subm_quater){
			$emailSubmReport  = $subm_quater;
		}elseif($report_year){
			$emailSubmReport  = $report_year;				
		}
		$userEmail  = $profile->email;
		$userName  = $profile->name;
		
		Mail::send('emails.report-success-email',
			array(
				'name' => $userName,
				'email' => $userEmail,
				'report_category' => $data['report_category'],
				'submission_period' => $emailSubmReport,
				'total_capital' => $data['total_capital'],
				'total_assest' => $data['total_assest'],
				'total_liability' => $data['total_liability'],
				'loan_advance' => $data['loan_advance'],
				'customer_deposits' => $data['customer_deposits'],
				'profit_before_tax' => $data['profit_before_tax'],
				'return_average_assets' => $data['return_average_assets'],
				'return_equity' => $data['return_equity']
			), function($message) use($profile)
			{
				$message->from($profile->email);
				$message->to(config('admin.admin_email'), config('admin.name'))->subject('New Report Submitted');
			});
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
	    return [
	        'profile_picture.max' => 'Maximum 1MB Allowed',
	    ];
	}


	/***report export***/
	public function export(Request $request)
	{	$profile = Auth::user();
	    $headers = array(
	        "Content-type" => "text/csv",
	        "Content-Disposition" => "attachment; filename=file.csv",
	        "Pragma" => "no-cache",
	        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	        "Expires" => "0"
	    );

	    $reportsQuery = Report::where('institute_id','=', $profile->id)->orderBy('id', 'DESC');
		if($request->filled('report_category')){
			$reportsQuery->where('report_category','=', $request->input('report_category'));
		}
		
		if($request->filled('start')){
			$m_start = date_create($request->input('start'));
		} else {
			$m_start = '';
		}
		if($request->filled('end')){
			$m_end = date_create($request->input('end'));
		} else {
			$m_end ='';
		}
		$reportsQuery->where(function ($query) use ($m_start, $m_end){
			$query->where(function ($query) use ($m_start, $m_end){
				if(!empty($m_start))
				$query->where('created_at', '>=', $m_start);
				if(!empty($m_end))
				$query->where('created_at', '<=', $m_end);
			});
		});
		$reports = $reportsQuery->get();
		//echo "<pre>";print_r($reports);die;
	    $columns = array('Report#', 'Report Category', 'Period', 'Total Capital', 'Total Assest', 'Total Liability', 'Loan Advance', 'Customer Deposits', 'Profit Exc Tax', 'Return Ave Assets','Return Equity','Timestamp');

	    $callback = function() use ($reports, $columns)
	    {
	        $file = fopen('php://output', 'w');
	        fputcsv($file, $columns);

	        foreach($reports as $report) {
	        	$period=$report->report_year;
	        	if($report->report_category=='Monthly'){
	        		$period=CommonMethod::getMonthName($report->submission_period);
	        	}
	        	if($report->report_category=='Quaterly'){
	        		$period=CommonMethod::getQuarterName($report->submission_quater);
	        	}
	            fputcsv($file, array($report->id,$report->report_category, $period, $report->total_capital, $report->total_assest, $report->total_liability, $report->loan_advance, $report->customer_deposits, $report->profit_before_tax, $report->return_average_assets, $report->return_equity,$report->created_at));
	        }
	        fclose($file);
	    };
	    return Response::stream($callback, 200, $headers);
	}
}
