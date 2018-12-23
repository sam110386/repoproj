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
class HomeController extends Controller
{
    public function index(Content $content)
    {       
           
        return $content
            ->header('Dashboard')
            ->description('')
            ->row(function (Row $row) {
                $row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Clients', '', 'aqua', '/admin/institutes', Institute::sum('client_male')+Institute::sum('client_female')));
                });

                $row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Staffs', '', 'green', '/admin/institutes', Institute::sum('staff_male')+Institute::sum('staff_female')));
                });

                $row->column(2, function (Column $column) {
                    $column->append(new InfoBox('Board Memebers', '', 'red', '/admin/institutes', Institute::sum('boardmember_male')+Institute::sum('boardmember_female')));
                });
                $row->column(3, function (Column $column) {
                    //$column->append(new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024'));
                });
            })
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append("<h3>New Institutes</h3>");
                });
            })
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append($this->recentgrid());
                });
            });
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
        $grid->name(trans('Institute Name'));
        $grid->client_male(trans('Client(M)'));
        $grid->client_female(trans('Client(F)'));
        $grid->staff_male(trans('Staff(M)'));
        $grid->staff_female(trans('Staff(F)'));
        $grid->boardmember_male(trans('Board Member(M)'));
        $grid->boardmember_female(trans('Board Member(F)'));
        
        $grid->created_at(trans('Created'))->display(function($date){
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
