<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppList;
use App\Tools\Helper;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AppListController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppList(), function (Grid $grid) {
            $grid->showColumnSelector();
            $grid->hideColumns(['id', 'create_ip', 'create_by', 'update_by', 'updated_at']);
            $grid->disableViewButton();
            $grid->enableDialogCreate();

            $grid->column('id')->sortable();
            $grid->column('name')->copyable()->label();
            $grid->column('url')->limit(20);
            $grid->column('icon')->image();
            $grid->column('desc')->limit(20);
            $grid->column('create_ip');
            $grid->column('create_by');
            $grid->column('update_by');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('name')->width(2);
                $filter->whereBetween('created_at', function ($query) {
                    $start = $this->input['start'] ? $this->input['start'] . ' 00:00:00' : null;
                    if (isset($this->input['end'])) {
                        $end = $this->input['end'] . ' 23:59:59';
                    } else {
                        $end = date('Y-m-d H:i:s');
                    }
                    $query->whereBetween('created_at', [$start, $end]);
                })->date()->width(4);
            });
        });
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
        return Show::make($id, new AppList(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('url');
            $show->field('icon');
            $show->field('desc');
            $show->field('create_ip');
            $show->field('create_by');
            $show->field('update_by');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppList(), function (Form $form) {
            $form->text('name')->required();
            $form->text('url')->required();
            $form->image('icon');
            $form->text('desc');
            $form->hidden('create_ip');
            $form->hidden('create_by');
            $form->hidden('update_by');

            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->input('create_ip', Helper::getClientIpEx());
                    $form->input('create_by', Admin::user()['id']);
                }
                $form->input('update_by', Admin::user()['id']);
            });
        });
    }
}
