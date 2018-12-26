<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;

use App\Helpers\CommonMethod;
use Encore\Admin\Admin;

use App\Models\Report;
use App\Models\ReportsFiles;
use Illuminate\Support\Facades\DB;
class StatisticsController extends Controller
{
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Content $content)
	{	
		$Institutes=Institute::orderBy('id','ASC')->pluck('name','id')->toArray();
		//print_r($Institutes);
		//print_r(sort($Institutes));

		$reprts=DB::table('reports')->where('report_category','=',"Monthly")->where('submission_period','=',date('m'))->where('report_year','=',date('Y'))->select('institute_id', DB::raw('SUM(total_capital) as total_capital'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		//print_r($reprts);die;
		return $content
		->header('Report Statistics')
		->description('Statistics...')
		->body(view('admin.statistics.index',['Institutes'=>$Institutes,'reprts'=>$reprts]));
		
	}

	public function instituteautocomplete(Request $request)
	{
	     $q= $request->get('q');
	     if(!empty($q) && !$q){
	        return Institute::where('name', 'like', "%$q%")->orWhere('phone', 'like', "%$q%")->paginate(null, ['id', 'name']);
	    }else{
	        return Institute::orderBy('name','ASC')->paginate(null, ['id', 'name']);
	    }
	}
	/*
	public function institute(Request $request)
    {
	     $q= $request->get('q');
	     if(!empty($q) && !$q){
	        return Institute::where('name', 'like', "%$q%")->orWhere('username', 'like', "%$q%")->select('id','name')->get();
	    }else{
	         return Institute::orderBy('name','ASC')->select('id','name')->get();//->pluck('id', 'name as text');
	    }
	}*/
	
}
