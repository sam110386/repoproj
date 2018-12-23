<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Widgets\Tab;
use App\Helpers\CommonMethod;
use Encore\Admin\Admin;
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
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Content $content)
	{	

		return $content
		->header('Reports')
		->description('Manage Reports...')
		->body($this->grid()->render());
		
	}

	protected function grid()
	{

		$grid = new Grid(new Report());
		$grid->model()->orderBy('id', 'DESC');
		$grid->disableExport();
		$grid->disableCreateButton();
		$grid->id('ID')->sortable();
		$grid->institute_id(trans('Institue'))->display(function($id){
			return Institute::find($id)->name;
		});;
		$grid->report_category(trans('Report Category'));
		$grid->column('Period')->display(function () {
			if($this->report_category=='Monthly'){
				return CommonMethod::getMonthName($this->submission_period);
			}
			if($this->report_category=='Quaterly'){
				return CommonMethod::getQuarterName($this->submission_quater);
			}
			if($this->report_category=='Audited'){
				return '';
			}
		});
		$grid->report_year(trans('Year'));
		$grid->total_capital(trans('Total Capital'));
		$grid->total_assest(trans('Total Assest'));
		$grid->total_liability(trans('Total Liability'));
		$grid->loan_advance(trans('Loan Advance'));
		$grid->customer_deposits(trans('Customer Deposits'));
		$grid->profit_before_tax(trans('Profit Exc Tax'));
		$grid->return_average_assets(trans('Return Ave Assets'));
		$grid->return_equity(trans('Return Equity'));

		$grid->created_at(trans('Created'))->display(function($date){
			return CommonMethod::formatDate($date);
		});

		$grid->actions(function (Grid\Displayers\Actions $actions) {
			$actions->disableDelete();

		});

		$grid->tools(function (Grid\Tools $tools) {
			$tools->batch(function (Grid\Tools\BatchActions $actions) {
				$actions->disableDelete();
                //$actions->disableEdit();
                //$actions->disableView();
			});
		});
		$grid->filter(function($filter){
            // Remove the default id filter
			$filter->disableIdFilter();
			$filter->column(1/2, function ($filter) {
				$filter->equal('report_category','Category')->select(['Monthly' => 'Monthly','Quaterly'=>'Quaterly','Audited'=>'Audited']);
				$filter->equal('institute_id','Institute')->select(Institute::pluck('name','id'));
           	});
			$filter->column(1/2, function ($filter) {
				$filter->between('created_at','Created')->datetime();
			});
		});
		return $grid;
	}


	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Content $content)
    { 
        //return view('Clients.create');
        return $content
        ->header('Create Report')
        ->description('Create...')
        ->body(view('admin.reports.add'));
        //->body($this->form('/admin/reports'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
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
		$submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
		$submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;		
		$report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;
		
		//check if already submitted
		$existObj=Report::where('institute_id','=',$data['institute_id'])->where('report_category','=',$data['report_category']);
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
            /**upload and save image end here***/
            admin_success('Success','Institute has been successfully added!');
            return redirect()->route('Institutes.index');
        }else{
            admin_error('Error','Something went wrong! Please Try Again.');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request){

        $institute = request()->validate([
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
        ]);
        $data=$request->all();
        $submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
		$submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;		
		$report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;
		
		$report = new Report;
		$report->id =$data['id'];
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

			/*foreach ($request->files as $key => $attFiles) {
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
			}*/
			//notifyt to Admin
			//$this->notifytoadmin($profile, $data);

			admin_success('Success','Report has been successfully updated!');
            return redirect()->route('Institutes.index');
        }else{
            admin_error('Error','Something went wrong! Please Try Again.');
            return back();
        }
    }
    


    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {    
        
        $content
        ->header(trans('Report'))
        ->description(trans('admin.detail'))
        ->body($this->detail($id)->render());
        $content->breadcrumb(
            ['text' => 'Reports', 'url' => '/reports'],
            ['text' => Report::find($id)->report_category]
        );
        return $content;
    }
    protected function detail($id)
    {
    	$script = <<<SCRIPT

        window.onload = function () {
		    jQuery('.trigger').click(function(){
		    	var filename=jQuery(this).attr('rel-file');
		    	jQuery("#myModal .modal-body").find('iframe').attr('src','/uploads/user/doc/'+filename);
		    	jQuery("#myModal").modal('show');
		    }); 
	    }
SCRIPT;
        Admin::script($script); 
        $show = new Show(Report::findOrFail($id));
        $show->panel()
        ->style('danger')
        ->title('Report Details')
        ->tools(function ($tools) {
	        $tools->disableDelete();
    	});
        $show->institute_id(trans('Institue'))->as(function($id){
			return Institute::find($id)->name;
		});
		$show->report_category(trans('Report Category'));
		$show->contents('Period')->as(function () {
			if($this->report_category=='Monthly'){
				return CommonMethod::getMonthName($this->submission_period);
			}
			if($this->report_category=='Quaterly'){
				return CommonMethod::getQuarterName($this->submission_quater);
			}
			if($this->report_category=='Audited'){
				return '';
			}
		});
		$show->report_year(trans('Year'));
		$show->total_capital(trans('Total Capital'));
		$show->total_assest(trans('Total Assest'));
		$show->total_liability(trans('Total Liability'));
		$show->loan_advance(trans('Loan Advance'));
		$show->customer_deposits(trans('Customer Deposits'));
		$show->profit_before_tax(trans('Profit Exc Tax'));
		$show->return_average_assets(trans('Return Ave Assets'));
		$show->return_equity(trans('Return Equity'));
        
        $show->created_at(trans('Created'))->as(function($date){
            return CommonMethod::formatDate($date);
        });

        $show->contents(trans('Financial Report'))->setEscape(false)->as(function($date){
            $return= '<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				      </div>
				      <div class="modal-body" style="min-height:600px;">
				       	<iframe src"" width="100%" height="100%" style="min-height:550px;"></iframe>
				      </div>
				      
				    </div>

				  </div>
				</div>';
			$reportfiles=ReportsFiles::where('report_id','=',$this->id)->get();
			$return .='<ul>';
			foreach($reportfiles as $reportfile):
				$return .='<li class="trigger" rel-file="'.$reportfile->filename.'">'.$reportfile->filename.'</li>';
			endforeach;
			$return .='</ul>';
			return $return;
        });

        return $show;
    } 
    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {	$report=Report::findOrFail($id);
        $content
        ->header(trans('Report'))
        ->description(trans('admin.edit'))
        ->body(view('admin.reports.edit',['report'=>$report]));
        $content->breadcrumb(
            ['text' => 'Reports', 'url' => '/reports'],
            ['text' => $report->report_category]
        );
        return $content;
    }

    
    
    

    public function form($action = null)
    {	
    	$script = <<<SCRIPT

        $("#report_category").change(function() {
		    var el = $(this) ;    
		    if(el.val() === "Monthly" ) {
				$('#submission_period').find('option:not(:first)').remove();
				$("#submission_period").append("<option value='1'>January</option>");
				$("#submission_period").append("<option value='2'>February</option>");
				$("#submission_period").append("<option value='3'>March</option>");
				$("#submission_period").append("<option value='4'>April</option>");			
				$("#submission_period").append("<option value='5'>May</option>");
				$("#submission_period").append("<option value='6'>June</option>");
				$("#submission_period").append("<option value='7'>July</option>");
				$("#submission_period").append("<option value='8'>Agust</option>");		
				$("#submission_period").append("<option value='9'>September</option>");
				$("#submission_period").append("<option value='10'>October</option>");
				$("#submission_period").append("<option value='11'>November</option>");
				$("#submission_period").append("<option value='12'>December</option>");	
		    }
		    else if(el.val() === "Quaterly" ) {		
				$('#submission_period').find('option:not(:first)').remove();
		        $("#submission_period").append("<option value='1'>Q1</option>");
		        $("#submission_period").append("<option value='2'>Q2</option>");
		        $("#submission_period").append("<option value='3'>Q3</option>");
		        $("#submission_period").append("<option value='4'>Q4</option>");
		    }
		    else if(el.val() === "Audited" ) {
		        $('#submission_period').find('option:not(:first)').remove();
		        var today = new Date();
		        var years=today.getFullYear();
		        for(var i=(years-20);i<=years;i++){
		            $("#submission_period").append("<option value='"+i+"'>"+i+"</option>");
		        }
		        
		    }
	  
	  });
SCRIPT;
        Admin::script($script); 

        $form = new Form(new Report());
        $form->tools(function ($tools) {
	        $tools->disableDelete();
    	});
        if($action) $form->setAction($action);
        $form->hidden('id');
        $form->row(function ($row) use ( $form) {
            $row->width(6)->select('report_category', 'Report Category')->options(array('Monthly'=>"Monthly",'Quaterly'=> 'Quaterly','Audited'=>'Audited'));
            $row->width(6)->select('submission_period', 'Submission Period')->options(array());
            $row->width(6)->text('total_capital', 'Total capital #')->placeholder('Total capital #');
            $row->width(6)->text('total_assest', 'Total Assets')->placeholder('Total Assets');
            $row->width(6)->text('total_liability', 'Total Liability')->placeholder('Total Liability');
            $row->width(6)->text('loan_advance', 'Loans & advances')->placeholder('Loans & advances');
            $row->width(6)->text('customer_deposits', 'Customer deposits')->placeholder('Customer deposits');
            $row->width(6)->text('profit_before_tax', 'Profit before tax')->placeholder('Profit before tax');
            $row->width(6)->text('return_average_assets', 'Return on average assets (in %)')->placeholder('Return on average assets');
            $row->width(6)->text('return_equity', 'Return on equity (%)')->placeholder('Return on equity');

        },$form);

        $form->row(function ($row) use($form) {
            //$row->width(1)->html();
            //$row->width(2)->html('<strong>Logo</strong>');
            //$row->width(6)->multipleFile('logo','Financial Report')->removable();

        },$form);
        $form->footer(function ($footer) {
            // disable `View` checkbox
            $footer->disableViewCheck();
            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();
            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();

        });
        $form->saving(function (Form $form) {
            
        });
        return $form;
    }




	/**function is used on Institue details page**/
	public function reportgrid($id){
		return $this->gridreport($id)->render();
	}
	protected function gridreport($id)
	{

		$grid = new Grid(new Report());
		$grid->model()->where('institute_id','=',$id)->orderBy('id', 'DESC');
		$grid->paginate(20);
		$grid->disableExport();
		$grid->disableFilter();
		$grid->disableCreateButton();
		$grid->disableActions();
		$grid->id('ID');
		$grid->report_category(trans('Report Category'));
		$grid->column('Period')->display(function () {
			if($this->report_category=='Monthly'){
				return CommonMethod::getMonthName($this->submission_period);
			}
			if($this->report_category=='Quaterly'){
				return CommonMethod::getQuarterName($this->submission_quater);
			}
			if($this->report_category=='Audited'){
				return '';
			}
		});
		$grid->report_year(trans('Year'));
		$grid->total_capital(trans('Total Capital'));
		$grid->total_assest(trans('Total Assest'));
		$grid->total_liability(trans('Total Liability'));
		$grid->loan_advance(trans('Loan Advance'));
		$grid->customer_deposits(trans('Customer Deposits'));
		$grid->profit_before_tax(trans('Profit Exc Tax'));
		$grid->return_average_assets(trans('Return Ave Assets'));
		$grid->return_equity(trans('Return Equity'));

		$grid->created_at(trans('Created'))->display(function($date){
			return CommonMethod::formatDate($date);
		});

		/*$grid->actions(function (Grid\Displayers\Actions $actions) {
			$actions->disableDelete();
            // $actions->resource = 'client/delete';
            // if ($actions->getKey() == 1) {
            //     $actions->disableDelete();
            // }
		});
		
		$grid->tools(function (Grid\Tools $tools) {
			$tools->batch(function (Grid\Tools\BatchActions $actions) {
				$actions->disableDelete();
			});
		});*/

		return $grid;
	}
}
