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
use App\Admin\Extensions\Tools\PdfButton;
class InstitutesController extends Controller
{

    public function index(Content $content)
    {

        return $content
        ->header('Institutes')
        ->description('Manage Institute...')
        ->body($this->grid()->render());

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
        ->header('Institutes')
        ->description('Create Institute...')
        ->body($this->form('/admin/institutes'));
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
           'name' => 'required|string|max:255',
           'phone' => 'required|string|max:18',
           'email' => 'required|string|email|max:255|unique:institutes',
           'password'=>'required|string|min:6|confirmed',
           'username'=>'required|string|max:25|unique:institutes',
           'logo' => 'nullable|image|max:1000|dimensions:min_width=150,min_height=150|mimes:jpeg,png,gif'
       ]);
        $data=$request->all();
        if(empty($data['client_male'])){
            $data['client_male']=0;
        }
        if(empty($data['client_female'])){
            $data['client_female']=0;
        }
        if(empty($data['staff_male'])){
            $data['staff_male']=0;
        }
        if(empty($data['staff_female'])){
            $data['staff_female']=0;
        }
        if(empty($data['boardmember_male'])){
            $data['boardmember_male']=0;
        }
        if(empty($data['boardmember_female'])){
            $data['boardmember_female']=0;
        }
        if(!empty($data['password'])){
            $data['password']=bcrypt($data['password']);
        }
        if($institute=Institute::create($data)){
            /**upload and save image***/
            $uploadedFile = $request->file('logo');
            if($uploadedFile && $uploadedFile->isValid()){
                $filename = time().$uploadedFile->getClientOriginalName();
                $file = Storage::disk('user_uploads')->putFileAs('',$uploadedFile,$filename);
                $data['logo'] = $file;
                Institute::findOrFail($institute->id)->update($data);
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:18',
            'email' => 'required|string|email|max:255',
            'password'=>'nullable||string|min:6|confirmed',
            'username'=>'string|max:25',
            'logo' => 'nullable|image|max:1000|dimensions:min_width=150,min_height=150|mimes:jpeg,png,gif'
        ]);
        $data=$request->all();
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        /**upload and save image***/
        $uploadedFile = $request->file('logo');
        if($uploadedFile && $uploadedFile->isValid()){
            $filename = time().$uploadedFile->getClientOriginalName();
            $file = Storage::disk('user_uploads')->putFileAs('',$uploadedFile,$filename);
            $data['logo'] = $file;
        }
        /**upload and save image end here***/
        if(Institute::findOrFail($id)->update($data)){
            admin_success('Success','Institute has been successfully updated!');
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
    public function show($id, Content $content,Request $request)
    {    $script = <<<SCRIPT

        $('ul.pagination a.page-link').bind('click', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var page=url.split('/');
            var param=page[page.length-1];
            $.pjax({url: '/admin/reports/grid/'+param, container: '#tab_reportcontainer'});
            return false;
            });
            $(document).on('ready pjax:end', function(event) {
             $('ul.pagination a.page-link').bind('click', function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var page=url.split('/');
                var param=page[page.length-1];
                $.pjax({url: '/admin/reports/grid/'+param, container: '#tab_reportcontainer'});
                return false;
                });
                return false;
                }); 

SCRIPT;
                Admin::script($script); 

        /*if($request->header('x-pjax')){
            return $this->reportgrid($id)->render();
        }*/
        $tab = new Tab();

        $tab->add('Account Details', $this->personaldetail($id)->render());
        $tab->add('Institute Details', $this->institutedetail($id)->render());
        $tab->add('Reports', $this->reportgrid($id)->render(),'','reportcontainer');
        $content
        ->header(trans('Institutes'))
        ->description(trans('admin.detail'))
        ->body($tab);
        $content->breadcrumb(
            ['text' => 'Institute', 'url' => '/institutes'],
            ['text' => Institute::find($id)->name]
        );
        return $content;
    }
    public function paginatereport($id){
        return $this->reportgrid($id)->render();
    }    
    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $content
        ->header(trans('Institutes'))
        ->description(trans('admin.edit'))
        ->body($this->form()->edit($id));
        $content->breadcrumb(
            ['text' => 'Institute', 'url' => '/institutes'],
            ['text' => Institute::find($id)->name]
        );
        return $content;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   $reportexits=Report::where('institute_id','=',$id)->count();
        if($reportexits){
            return response()->JSON(['status' => false, 'message' => 'Selected institute having report records, so you cant delete this institute.']);
        }
        if(Institute::destroy($id)){
            $res = ['status' => true, 'message' => 'Institute has been removed.'];
        }else{
            $res = ['status' => false, 'message' => 'Something went wrong!'];
        }
        return response()->JSON($res);
    }    

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function personaldetail($id)
    {

        $show = new Show(Institute::findOrFail($id));
        $show->panel()
        ->style('danger')
        ->title('Account Details')
        /*->tools(function ($tools) {
            $tools->prepend(new PdfButton());
        })*/;
        $show->name(trans('Name'));
        
        $show->username(trans('username'));
        $show->email(trans('Email'));
        $show->phone(trans('Phone'));
        // ADDRESS INFORMATION
        $show->address(trans('Street Address'));
        $show->region(trans('Region'));
        $show->district(trans('District'));
        $show->ward(trans('Ward'));
        $show->zipcode(trans('Zip Code'));
        $show->status(trans('Status'))->using(['0' => 'Inactive', '1' => 'Active']);
        $show->created_at(trans('admin.created_at'))->as(function($date){
            return CommonMethod::formatDateWithTime($date);
        });
        $show->updated_at(trans('Last Updated'))->as(function($date){
            return CommonMethod::formatDate($date);
        });

        return $show;
    }
    protected function institutedetail($id)
    {
        $institute=Institute::findOrFail($id);
        $show = new Show($institute);
        $show->panel()
        ->title($institute->name)
        ->tools(function ($tools) {
            $tools->prepend(new PdfButton());
        });
        
        $show->logo()->image();
        $show->client_male(trans('Client Male'));
        $show->client_female(trans('Client Female'));
        $show->staff_male(trans('Staff Male'));
        $show->staff_female(trans('Staff Female'));
        $show->boardmember_male(trans('Board Member Male'));
        $show->boardmember_female(trans('Board Member Female'));
        
        return $show;
    }

    protected function grid()
    {

        $grid = new Grid(new Institute());
        $grid->disableExport();
        $grid->id('ID')->sortable();
        $grid->name(trans('Institute Name'));
        $grid->client_male(trans('Client(M)'));
        $grid->client_female(trans('Client(F)'));
        $grid->staff_male(trans('Staff(M)'));
        $grid->staff_female(trans('Staff(F)'));
        $grid->boardmember_male(trans('Board Member(M)'));
        $grid->boardmember_female(trans('Board Member(F)'));
        
        $grid->updated_at(trans('Updated'))->sortable()->display(function($date){
            return CommonMethod::formatDateWithTime($date);
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            // $actions->resource = 'client/delete';
            // if ($actions->getKey() == 1) {
            //     $actions->disableDelete();
            // }
        });
        $grid->filter(function($filter){
            // Remove the default id filter
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
            // Add a column filter
                $filter->like('name', 'Name');
                $filter->like('phone', 'Phone');
                $filter->like('email', 'Email');
                $filter->equal('status')->select(['0' => 'InActive','1'=>'Active']);
            });
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at')->datetime();
            });
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }

    public function form($action = null)
    {
        
        $form = new Form(new Institute());
        
        if($action) $form->setAction($action);
        
        $form->row(function ($row) use ( $form) {
            $row->width(6)->text('name', 'Name')->rules('required')->placeholder('Name');
            $row->width(6)->text('username', 'User Name')->rules('required')->prepend('<i class="fa fa-user"></i>')->placeholder('User Name');
            $row->width(6)->text('email', 'Email')->rules('required')->prepend('<i class="fa fa-at"></i>')->placeholder('Email');
            $row->width(6)->text('phone', 'Phone')->rules('required')->prepend('<i class="fa fa-phone"></i>')->placeholder('Phone');
            
            $row->width(6)->password('password', trans('admin.password'))->rules('required|confirmed')->placeholder('Password');
            $row->width(6)->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->placeholder('Confirm Password');

        },$form);

        // ADDRESS INFORMATION
        $form->row(function ($row) use ( $form) {
            $row->width(12)->html(
                "<div class='box-header with-border'><h3 class='box-title text-upper box-header'>ADDRESS INFORMATION</h3></div>"
            );
            $row->width(6)->text('address', 'Street Address')->placeholder('Street Address');
            $row->width(6)->text('region', 'Region')->placeholder('Region');
            $row->width(6)->text('district', 'District')->placeholder('District');
            $row->width(6)->text('ward', 'Ward')->placeholder('Ward');
            $row->width(6)->text('zipcode', 'Zipcode')->attribute(['maxlength'=>8])->placeholder('Zip Code');

        },$form);
        
        // Staff INFORMATION
        $form->row(function ($row) use($form) {
            $row->width(12)->html(
                "<div class='box-header with-border'><h3 class='box-title text-upper box-header'>STAFF INFORMATION</h3></div>"
            );
        });
        
        $form->row(function ($row) use($form) {
            $row->width(1)->html();
            $row->width(2)->html('<strong>Client Information</strong>');
            $row->width(2)->text("client_male",'')->prepend('<i class="fa fa-male"></i>')->placeholder('Male');            
            $row->width(2)->text('client_female', '')->prepend('<i class="fa fa-female"></i>')->placeholder('Female');
        });
        $form->row(function ($row) use($form) {
            $row->width(1)->html();
            $row->width(2)->html('<strong>Staff Information</strong>');
            $row->width(2)->text("staff_male",'')->prepend('<i class="fa fa-male"></i>')->placeholder('Male');            
            $row->width(2)->text('staff_female', '')->prepend('<i class="fa fa-female"></i>')->placeholder('Female');
        });
        $form->row(function ($row) use($form) {
            $row->width(1)->html();
            $row->width(2)->html('<strong>Board Members</strong>');
            $row->width(2)->text("boardmember_male",'')->prepend('<i class="fa fa-male"></i>')->placeholder('Male');            
            $row->width(2)->text('boardmember_female', '')->prepend('<i class="fa fa-female"></i>')->placeholder('Female');
        });

        $form->row(function ($row) use($form) {
            $row->width(12)->html(
                "<div class='box-header with-border'><h3 class='box-title text-upper box-header'>STATUS</h3></div>"
            );
        });
        
        $form->row(function ($row) use($form) {
            $row->width(1)->html();
            $row->width(2)->html('<strong>Status</strong>');
            $row->width(2)->select('status', '')->options(array(1=>"Active",0 => 'Inactive'));

        },$form);
        $form->row(function ($row) use($form) {
            $row->width(1)->html();
            $row->width(2)->html('<strong>Logo</strong>');
            $row->width(4)->image('logo', '');//->crop(300, 300, [300, 300])->removable()->uniqueName();

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
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });
        return $form;
    }


    public function autocomplete(Request $request)
    {
     $q= $request->get('q');
     if(!empty($q)){
        return Institute::where('name', 'like', "%$q%")->orWhere('phone', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }else{
        return Institute::all()->paginate(null, ['id', 'name as text']);
    }
}


protected function reportgrid($id)
{

    $grid = new Grid(new Report());
    $grid->tools(function ($tools) {
        $tools->disableRefreshButton();
        //$tools->prepend(new PdfButton());
    });
    $grid->model()->where('institute_id','=',$id)->orderBy('id', 'DESC');
    $grid->paginate(20);
    //$grid->disableExport();
    //$grid->disableActions();
    //$grid->disableRefreshButton();
    $grid->disableFilter();
    //$grid->disableRowSelector();
    //$grid->disableCreateButton();
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
            return $this->report_year;;
        }
    });
    //$grid->report_year(trans('Year'));
    $grid->total_capital(trans('Total Capital'));
    $grid->total_assest(trans('Total Assest'));
    $grid->total_liability(trans('Total Liability'));
    $grid->loan_advance(trans('Loan Advance'));
    $grid->customer_deposits(trans('Customer Deposits'));
    $grid->profit_before_tax(trans('Profit Exc Tax'));
    $grid->return_average_assets(trans('Return Ave Assets'));
    $grid->return_equity(trans('Return Equity'));

    /*$grid->created_at(trans('Created'))->display(function($date){
        return CommonMethod::formatDate($date);
    });*/
    return $grid;
}

/***export PDF ***/
function export($id){
    $institute=Institute::findOrFail($id);
    if(Storage::disk('user_uploads')->exists($institute->logo)){
        $logo = '/uploads/user/' . $institute->logo ;
    }else{
        $logo = '';
    }
    $pocessedHtml=view('admin.institutes.export_pdf',['institute'=>$institute,'logo'=>$logo])->render();
    include(base_path('vendor/xtcpdf.php'));
    $tcpdf = new \XTCPDF();
    $textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

    $tcpdf->SetAuthor("COBAT");
    //$tcpdf->SetAutoPageBreak( false );
    $tcpdf->SetAutoPageBreak(true, 40);

    $tcpdf->setHeaderFont(array($textfont,'',30));
    $tcpdf->xheadercolor = array(255,255,255);
    $tcpdf->xheadertext = '';
    $tcpdf->xfootertext = 'COBAT IMS';
    $tcpdf->AddPage();
    $tcpdf->SetTextColor(0, 0, 0);
    $tcpdf->SetFont($textfont,'A',15);
    $tcpdf->WriteHTML($pocessedHtml);
    $filePath =$institute->username.'.pdf';
    $tcpdf->Output($filePath, 'D');
    //return response()->download($tcpdf->Output($filePath, 'I'), $filePath, ['Content-Type' => 'application/pdf']);
    die;
}

/**institute report create**/
public function createreport($id,Content $content)
    { 
        //return view('Clients.create');
        return $content
        ->header('Create Report')
        ->description('Create...')
        ->body(view('admin.institutes.reportadd',['url'=>'/admin/institutes/'.$id.'/createreportsave','id'=>$id]))
        ->breadcrumb(
            ['text' => 'Institute', 'url' => '/institutes'],
            ['text' => Institute::find($id)->name,'url'=>'/institutes/'.$id],
            ['text' => 'Create Report']
        );
        
    }
public function createreportsave($id,Request $request)
    {   
        $valid = request()->validate([
            'report_category' => 'required',
            'submission_period' => 'required',
            'total_capital' => 'required|nullable|numeric|max:9000000000000',
            'total_assest' => 'required|nullable|numeric|max:9000000000000',
            'total_liability' => 'required|nullable|numeric|max:9000000000000',
            'loan_advance' => 'required|nullable|numeric|max:9000000000000',
            'customer_deposits' => 'required|nullable|numeric|max:9000000000000',
            'profit_before_tax' => 'required|nullable|numeric|max:9000000000000',
            'return_average_assets' => 'required|nullable|numeric|max:9000000000000',
            'return_equity' => 'required|nullable|numeric|max:9000000000000',         
            //'files' => 'mimes:jpeg,png,gif,pdf,doc,docx'
        ]); 
        $data=$request->all();
        $submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
        $submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;        
        $report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;
        
        //check if already submitted
        $existObj=Report::where('institute_id','=',$id)->where('report_category','=',$data['report_category']);
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
            echo "<pre>";print_r($existObj->get());die;
            admin_error('Error','Report already submitted for selected period');
            return back()->with('Error','Report already submitted for selected period');    
        }
        $report = new Report;
        $report->institute_id =$id;
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
            if($request->has('files')){
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
            /**upload and save image end here***/
            admin_success('Success','Report has been successfully added!');
            return redirect('/admin/institutes/'.$id);
        }else{
            admin_error('Error','Something went wrong! Please Try Again.');
            return back();
        }
    }

/**edit report for selected institute***/
public function editreport($id,$reportid,Content $content)
    { 
        //return view('Clients.create');
        $report=Report::findOrFail($reportid);
        return $content
        ->header('Edit Report')
        ->description('Edit...')
        ->body(view('admin.institutes.reportedit',['report'=>$report,'url'=>'/admin/institutes/'.$id.'/'.$reportid.'/editreportsave','id'=>$id]))
        ->breadcrumb(
            ['text' => 'Institute', 'url' => '/institutes'],
            ['text' => Institute::find($id)->name,'url'=>'/institutes/'.$id],
            ['text' => 'Edit Report']
        );
        
    }
 /**edit report save**/
 public function editreportsave($id,$reportid,Request $request){

        $institute = request()->validate([
            'report_category' => 'required',
            'submission_period' => 'required',
            'total_capital' => 'required|nullable|numeric|max:9000000000000',
            'total_assest' => 'required|nullable|numeric|max:9000000000000',
            'total_liability' => 'required|nullable|numeric|max:9000000000000',
            'loan_advance' => 'required|nullable|numeric|max:9000000000000',
            'customer_deposits' => 'required|nullable|numeric|max:9000000000000',
            'profit_before_tax' => 'required|nullable|numeric|max:9000000000000',
            'return_average_assets' => 'required|nullable|numeric|max:9000000000000',
            'return_equity' => 'required|nullable|numeric|max:9000000000000',
        ]);
        $data=$request->all();
        $submission_period = ($data['report_category']=="Monthly")?$data['submission_period']:NULL;
        $submission_quater = ($data['report_category']=="Quaterly")?$data['submission_period']:NULL;        
        $report_year = ($data['report_category']=="Audited")?$data['submission_period']:NULL;
        
        $report =  Report::find($data['id']);
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
            if($request->has('files')){
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
            //notifyt to Admin
            //$this->notifytoadmin($profile, $data);

            admin_success('Success','Report has been successfully updated!');
            return redirect('/admin/institutes/'.$id);
        }else{
            admin_error('Error','Something went wrong! Please Try Again.');
            return back();
        }
    }  
    /***delete report ****/
    public function deletereport($id,$reportid)
    {   
        if(Report::destroy($reportid)){
            ReportsFiles::where('report_id', $reportid)->delete();
            $res = ['status' => true, 'message' => 'Report has been removed.'];
        }else{
            $res = ['status' => false, 'message' => 'Something went wrong!'];
        }
        return response()->JSON($res);
    }  

    public function viewreport($id,$reportid ,Content $content)
    {    
        return $content
        ->header('Report Details')
        ->description('Edit...')
        ->body($this->reportdetail($reportid)->render())
        ->breadcrumb(
            ['text' => 'Institute', 'url' => '/institutes'],
            ['text' => Institute::find($id)->name,'url'=>'/institutes/'.$id],
            ['text' => 'Report']
        );
        
        
    }
    protected function reportdetail($id)
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
}
