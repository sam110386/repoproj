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
		//report data
		$reprts=DB::table('reports')->where('report_category','=',"Monthly")->where('submission_period','=',date('m'))->where('report_year','=',date('Y'))->select('institute_id', DB::raw('SUM(total_capital) as total_capital'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		
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
	

	/***function to get Chart Data***/
	public function loadchartdata(Request $request){
		$data=[];
		$InstitutesObj=Institute::orderBy('id','ASC');
		if($request->filled('instiute_id')){
			$InstitutesObj->whereIn('id',$request->instiute_id);
		}
		$institutes=$InstitutesObj->pluck('name','id')->toArray();
		$return=array('institutes'=>$institutes);
		//if client selected
		if($request->entity_type=='clients'){
			$data=$InstitutesObj->select('id as institute_id',DB::raw('(client_male+client_female) as total'))->orderBy('id','ASC')->get();
		}
		//if staff selected
		if($request->entity_type=='staff'){
			$data=$InstitutesObj->select('id as institute_id',DB::raw('(staff_male+staff_female) as total'))->orderBy('id','ASC')->get();
		}
		//if board member selected
		if($request->entity_type=='board_members'){
			$data=$InstitutesObj->select('id as institute_id',DB::raw('(boardmember_male+boardmember_female) as total'))->orderBy('id','ASC')->get();
		}
		//if total capital is selected
		if($request->entity_type=='total_capital'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(total_capital) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='total_asset'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(total_assest) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='total_liability'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(total_liability) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='loan_advance'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(loan_advance) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='customer_deposits'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(customer_deposits) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		
		if($request->entity_type=='profit_before_tax'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(profit_before_tax) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='return_average_assets'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(return_average_assets) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		if($request->entity_type=='return_equity'){
			$reportCategory=$request->report_category;
			$reprtObj=DB::table('reports')->where('report_category','=',$reportCategory);
			if($request->report_category=='Monthly'){
				$reprtObj->where('submission_period','>=',$request->submission_period_from);
				$reprtObj->where('submission_period','<=',$request->submission_period_to);
			}elseif($request->report_category=='Quaterly'){
				$reprtObj->where('submission_quater','>=',$request->submission_period_from);
				$reprtObj->where('submission_quater','<=',$request->submission_period_to);
			}elseif($request->report_category=='Audited'){
				$reprtObj->where('report_year','>=',$request->submission_period_from);
				$reprtObj->where('report_year','<=',$request->submission_period_to);
			}
			$data=$reprtObj->select('institute_id', DB::raw('SUM(return_equity) as total'))->orderBy('institute_id','ASC')->groupBy('institute_id')->get();
		}
		$temp=[];
		//echo "<pre>";
		//print_r($institutes);
		//print_r($data->toArray());
		$keyed=collect($data)->keyBy('institute_id')->all();
		//print_r($keyed);
		foreach($institutes as $id=>$name){
			$temp[$name]=isset($keyed[$id])?$keyed[$id]->total:0;
		}
		$return['data']=$data;
		$return['graph']=$temp;
		//

		return response()->json($return);
	}
	


}
