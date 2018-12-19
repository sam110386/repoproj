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
		// $this->middleware('auth');
		$this->profile = Auth::user();
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$profile = Auth::user();
		
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		$pageData = ['title' => 'Dashboard','profile' => $profile];
		return view('Account.dashboard',$pageData);
	}

    
	public function add(){
		$profile = Auth::user();
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		
		$pageData = ['title' => 'Profile', 'description'=>'', 'profile' => $profile];
		return view('Report.add',$pageData);
	}

	public function saveData(Request $request){
		$profile = Auth::user();
		//echo "<pre>";
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
			'return_equity' => 'required|nullable|numeric|digits_between:1,5',			
			//'files' => 'required|nullable|image|max:1000|dimensions:min_width=150,min_height=150|mimes:jpeg,png,gif'
		]);		

	
			
		$report = new Report;
		$report->report_category = $data['report_category'];
		$report->submission_period = $data['submission_period'];
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
				$file = Storage::disk('user_uploads')->putFileAs('',$fileData,$filename);			
			}	
				
				$reportFiles = new ReportsFiles;
				
				 
				$reportFiles->report_id =  $report->id;				 
				$reportFiles->filename = $file;
				$reportFiles->save(); 
				
			}
			}		 
		}

		
		return back()->with('success','Image Upload successfully');			
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
