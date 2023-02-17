<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppList;
use App\Tools\Helper;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;


/**
 * 应用视图
 * Class AppViewController.
 */
class AppViewController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppList(), function (Grid $grid) {
            $grid->disableActions();
            $grid->disableCreateButton();

            $grid->listen(Grid\Events\Fetched::class, function ($grid, Collection $rows) {
                $rows->transform(function ($row) {
                    if ($row['icon']) {
                        $row['icon'] = Helper::getImageURL($row['icon']);
                    }
                    return $row;
                });
            });

            if (request()->get('_view_') !== 'list') {
                // 设置自定义视图
                $grid->with([])->view('grid.appView');
            }

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->panel();
                $filter->like('name')->width(2);
            });
        });
    }
}
