<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\ReportsFiles;

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
		

		$reportsQuery = Report::where('institute_id', $profile->id);
		/*if($request->filled('query')){
			$eventsQuery->where(function($query) use ($request){
				$query->where('name', 'like', '%'.$request->input('query').'%');
				$query->orWhere('description', 'like', '%'.$request->input('query').'%');
			});
		}
		if($request->filled('category')){
			$eventsQuery->whereHas('categories', function($query) use ($request){
				$query->where('event_categories.id', $request->input('category'));
			});
		}
		if($request->filled('month')){
			$m_start = date_create($request->input('month'))->modify('first day of this month');
			$m_end = date_create($request->input('month'))->modify('last day of this month');
		} else {
			$m_start = date_create()->modify('first day of this month');
			$m_end = date_create()->modify('last day of this month');
		}
		$eventsQuery->where(function ($query) use ($m_start, $m_end){
			$query->where(function ($query) use ($m_start, $m_end){
				$query->where('start_date', '>=', $m_start);
				$query->where('start_date', '<=', $m_end);
			});
			$query->orWhere(function ($query) use ($m_start, $m_end){
				$query->where('end_date', '>=', $m_start);
				$query->where('end_date', '<=', $m_end);
			});
		});*/
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
		$fileName = null;
		$valid = request()->validate([
			'report_category' => 'required',
			'submission_period' => 'required',
			'total_capital' => 'required|nullable|numeric|digits_between:1,5',
			'total_assest' => 'required|nullable|numeric|digits_between:1,5',
			'total_liability' => 'required|nullable|numeric|digits_between:1,5',
			'loan_advance' => 'required|nullable|numeric|digits_between:1,5',
			'customer_deposits' => 'required|nullable|numeric|digits_between:1,5',
			'profit_before_tax' => 'required|nullable|numeric|digits_between:1,5',
			'return_average_assets' => 'required|nullable|numeric|digits_between:1,5',
			'return_equity' => 'required|nullable|numeric',			
			//'files' => 'mimes:jpeg,png,gif,pdf,doc,docx'
		]);	
			
		$report = new Report;
		$report->institute_id =$profile->id;
		$report->report_category = $data['report_category'];
		$report->submission_period = $data['submission_period'];
		$report->total_capital = $data['total_capital'];
		$report->total_assest = $data['total_assest'];
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
		}

		
		return redirect('report')->with('success','Report submitted successfully');			
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
}
