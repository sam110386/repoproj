<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\InfoBox;
use App\Models\Institute;
use App\Helpers\CommonMethod;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index(Content $content)
    {       
           
        return $content
            ->header('Dashboard')
            ->description('')
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append($this->getsummery());
                });
                /*$row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Clients', '', 'aqua', '/admin/institutes', number_format(Institute::sum('client_male')+Institute::sum('client_female'),0,'',',')));
                });

                $row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Staffs', '', 'green', '/admin/institutes', number_format(Institute::sum('staff_male')+Institute::sum('staff_female'),0,'',',')));
                });

                $row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Board Memebers', '', 'red', '/admin/institutes', number_format(Institute::sum('boardmember_male')+Institute::sum('boardmember_female'),0,'',',')));
                });
                $row->column(5, function (Column $column) {
                    $column->append($this->getTopPerformer());
                });*/
            })
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append("<h3>Active Institutions</h3>");
                });
            })
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append($this->recentgrid());
                });
            });
    }

    protected function getsummery(){
        $clients=number_format(Institute::sum('client_male')+Institute::sum('client_female'),0,'',',');
        $staff=number_format(Institute::sum('staff_male')+Institute::sum('staff_female'),0,'',',');
        $boardmember=number_format(Institute::sum('boardmember_male')+Institute::sum('boardmember_female'),0,'',',');
        $institutes=Institute::select( 'id','name',DB::raw( '(client_female+staff_female+boardmember_female) as totalfemail' ),DB::raw( '(client_male+client_female+staff_male+staff_female+boardmember_male+boardmember_female) as total' ), DB::raw( '(client_female+staff_female+boardmember_female)/(client_male+client_female+staff_male+staff_female+boardmember_male+boardmember_female) as ratio' ) )->orderBy('ratio',"DESC")->limit(4)->get();
        return view('admin.dashboard.summary',['institutes'=>$institutes,'clients'=>$clients,'staff'=>$staff,'boardmember'=>$boardmember]);
    }

    protected function getTopPerformer(){
        $institutes=Institute::select( 'id','name',DB::raw( '(client_female+staff_female+boardmember_female) as totalfemail' ),DB::raw( '(client_male+client_female+staff_male+staff_female+boardmember_male+boardmember_female) as total' ), DB::raw( '(client_female+staff_female+boardmember_female)/(client_male+client_female+staff_male+staff_female+boardmember_male+boardmember_female) as ratio' ) )->orderBy('ratio',"DESC")->limit(4)->get();
        return view('admin.dashboard.topperformer',['institutes'=>$institutes]);
    }

     protected function recentgrid()
    {

        $grid = new Grid(new Institute());
        $grid->model()->orderBy('id', 'DESC')->limit(20);
        $grid->disableExport();
        $grid->disableActions();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disablePagination();
        $grid->id('ID');
        $grid->name(trans('Institute Name'))->display(function ($name) {
            return "<a href='/admin/institutes/".$this->id."'>".$name."</a>";
        });
        $grid->client_male(trans('Client(M)'));
        $grid->client_female(trans('Client(F)'));
        $grid->staff_male(trans('Staff(M)'));
        $grid->staff_female(trans('Staff(F)'));
        $grid->boardmember_male(trans('Board Member(M)'));
        $grid->boardmember_female(trans('Board Member(F)'));
        
        $grid->updated_at(trans('Updated'))->display(function($date){
            return CommonMethod::formatDateWithTime($date);
        });

        /*$grid->actions(function (Grid\Displayers\Actions $actions) {
            // $actions->resource = 'client/delete';
            // if ($actions->getKey() == 1) {
            //     $actions->disableDelete();
            // }
        });
        
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });
        });*/

        return $grid;
    }
}
