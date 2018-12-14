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
use App\Helpers\CommonMethod;
use Encore\Admin\Admin;

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
			'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password'=>'required',
            'username'=>'required'
        ]);
        if(Institute::create($request->all())){
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'username'=>'required'
        ]);
        if(Institute::findOrFail($id)->update($request->all())){
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
         $content
            ->header(trans('Institutes'))
            ->description(trans('admin.detail'))
            ->body($this->detail($id));
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
    protected function detail($id)
    {
        
        $show = new Show(Institute::findOrFail($id));

        $show->id('ID');
        $show->name(trans('Name'));
        $show->phone(trans('Phone'));
        $show->user_type(trans('Client Type'))->using([1=>"Individual",2=>"Company"]);
        $show->gender(trans('Gender'))->using(['M' => 'Male', 'F' => 'Female']);
        $show->language(trans('Language'))->using(['en' => 'English']);

        // ADDRESS INFORMATION
        $show->address(trans('Street Address'));
        $show->region(trans('Region'));
        $show->district(trans('District'));
        $show->ward(trans('Ward'));
        $show->zipcode(trans('Zipcode'));

        // REGISTRATION INFORMATION
        $show->registration_number(trans('Registration Number'));
        $show->registration_date(trans('Registration Date'))->as(function($date){
            return CommonMethod::formatDateWithTime($date);
        });

        // TAX INFORMATION
        $show->return_due_date(trans('Returns Due (Expiration)'))->as(function($date){
            return CommonMethod::formatDate($date);
        });

        $show->motor_vehicle_due_date(trans('Motor Vehicle Due (Expiration)'))->as(function($date){
            return CommonMethod::formatDate($date);
        });
        $show->driving_licence_due_date(trans('Driving Licence Due (Expiration)'))->as(function($date){
            return CommonMethod::formatDate($date);
        });              
        // $show->taxcategory(trans('Tax Category'))->using([['Returns'=>"Returns",'Motor Vehicle' => 'Motor Vehicle','Driving Licence' => 'Driving Licence']]);

        $show->exempt(trans('exempt'))->using([1=>"Yes",0 => 'No']);
        $show->tax_type(trans('Tax Type'))->using(['VAT'=>"VAT",'non-VAT' => 'non-VAT']);
        $show->filling_type(trans('Filling Type'))->using(['regular'=>"Regular",'lamp-sum' => 'Lamp sum']);
        $show->filling_period(trans('Filling Period'))->using(['annual'=>"Annual",'quarterly' => 'Quarterly']);
        $show->filling_currency(trans('Filling Currency'))->using(['TSH'=>"TSH",'USD' => 'USD']);
        
        
        $show->total_amount(trans('Total Amount'));
        $show->penalty_amount(trans('Penalty Amount'));
        
        $show->certificate_printed(trans('Certificate Printed'))->using(['0' => 'No', '1' => 'Yes']);
        

        $show->status(trans('Status'))->using(['0' => 'Inactive', '1' => 'Active']);
        $show->created_at(trans('admin.created_at'))->as(function($date){
            return CommonMethod::formatDateWithTime($date);
        });
        

        return $show;
    }

    protected function grid()
    {
        
        $grid = new Grid(new Institute());
        $grid->disableExport();
        $grid->id('ID')->sortable();
        $grid->name(trans('Name'));
        $grid->email(trans('email'));
        $grid->phone(trans('Phone'))->sortable();
        $grid->status(trans('Status'))->display(function($status){
            return ($status) ? 'Active' : 'Inative';
        });     
        $grid->created_at(trans('Created'))->sortable()->display(function($date){
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
                ->default(function ($form) {
                    return $form->model()->password;
                })->placeholder('Confirm Password');

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
            $row->width(4)->image('logo', '')->crop(300, 300, [300, 300])->removable()->uniqueName();

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
}
