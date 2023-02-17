<?php

namespace App\Admin\Actions;

use Dcat\Admin\Grid\Displayers\Actions;

class TextActions extends Actions
{
    /**
     * @return string
     */
    protected function getViewLabel()
    {
        $label = trans('admin.show');
        return '<button type="submit" class="btn btn-success btn-xs">' . $label . '</button> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getEditLabel()
    {
        $label = trans('admin.edit');
        return '<button type="submit" class="btn btn-primary btn-xs">' . $label . '</button> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getQuickEditLabel()
    {
        $label = trans('admin.edit');
        $label2 = trans('admin.quick_edit');

//        return '<span class="text-blue-darker" title="' . $label2 . '">' . $label . '</span> &nbsp;';
        return '<button type="submit" class="btn btn-primary btn-xs">' . $label . '</button> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getDeleteLabel()
    {
        $label = trans('admin.delete');
        return '<button type="submit" class="btn btn-danger btn-xs">' . $label . '</button> &nbsp;';
    }
}
