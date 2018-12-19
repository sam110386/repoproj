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
use Encore\Admin\Widgets\Tab;
use App\Helpers\CommonMethod;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\ReportFiles;
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
            'password'=>'required|string|min:6|confirmed',
            'username'=>'required|string|max:25',
            'logo' => 'nullable|image|max:1000|dimensions:min_width=150,min_height=150|mimes:jpeg,png,gif'
        ]);
        $data=$request->all();
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
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
    public function show($id, Content $content)
    {   
        $tab = new Tab();
        
        $tab->add('Account Details', $this->personaldetail($id)->render());
        $tab->add('Institute Details', $this->institutedetail($id)->render());
        $tab->add('Reports', $this->reportgrid($id)->render());
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
    {
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
            ->title('Account Details');
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
        
        $show = new Show(Institute::findOrFail($id));
        $show->panel()
            ->title('Institute Details');
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
        $script = <<<SCRIPT
                    
SCRIPT;

        Admin::script($script);

        

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
        $grid->model()->where('institute_id','=',$id);
        $grid->disableExport();
        $grid->disableFilter();
        $grid->id('ID');
        $grid->report_category(trans('report_category'));
        $grid->submission_period(trans('submission_period'));
          
        $grid->created_at(trans('Created'))->display(function($date){
            return CommonMethod::formatDateWithTime($date);
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            // $actions->resource = 'client/delete';
            // if ($actions->getKey() == 1) {
            //     $actions->disableDelete();
            // }
        });
        $grid->filter(function($filter){
            // Remove the default id filter
           $filter->disableIdFilter();
             /*$filter->column(1/2, function ($filter) {
            // Add a column filter
                $filter->like('name', 'Name');
                $filter->like('phone', 'Phone');
                $filter->like('email', 'Email');
                $filter->equal('status')->select(['0' => 'InActive','1'=>'Active']);
            });
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at')->datetime();
            });*/
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }
}
