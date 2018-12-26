<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\Institute;
class AccountController extends Controller
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
		//get Recent 20 reports
		$reports=Report::where('institute_id','=',$profile->id)->orderBy('id', 'DESC')->limit(20)->get();
		$pageData = ['title' => 'Dashboard','profile' => $profile,'reports'=>$reports];
		return view('Account.dashboard',$pageData);
	}


	public function view(){
		$profile = Auth::user();
		if(Storage::disk('user_uploads')->exists($profile->logo)){
			$profilePic = '/uploads/user/' . $profile->logo ;
		}else{
			$profilePic = '/img/avatar5.png';
		}
		$profile['profile_picture'] = $profilePic;
		$pageData = ['title' => 'Profile', 'description'=>'', 'profile' => $profile];
		return view('Account.profile',$pageData);
	}

	protected function updateProfile(Request $request){

		$valid = request()->validate([
			'name' => 'required',
			'phone' => 'nullable|numeric|digits_between:7,15',
			'email' => 'required|string|email|max:255',
			'profile_picture' => 'nullable|image|max:1000|dimensions:min_width=150,min_height=150|mimes:jpeg,png,gif'
		]);
		$data=$request->all();
		$uploadedFile = $request->file('profile_picture');
		if($uploadedFile && $uploadedFile->isValid()){
			$filename = time().$uploadedFile->getClientOriginalName();
			$file = Storage::disk('user_uploads')->putFileAs('',$uploadedFile,$filename);
			$data['logo'] = $file;
		}
		//print_r($data);echo Auth::user()->id;die;
		if(Institute::findOrFail(Auth::user()->id)->update($data)){
			$returnKey = 'success';
			$returnMsg = 'Profile has been updated';
		}else{
			$returnKey = 'error';
			$returnMsg = 'Profile not updated';            
		}
		
		return redirect()->back()->with($returnKey, $returnMsg);
	}



	protected function updatePassword(Request $request){
		$valid = request()->validate([
			'password' => 'required|string|min:6|confirmed',
		]);
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