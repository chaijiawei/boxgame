<?php

namespace App\Admin\Controllers;

use App\Models\Link;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LinksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '资源推荐管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Link());

        $grid->column('id', __('Id'));
        $grid->column('title', '标题');
        $grid->column('url', '链接地址')->link();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Link::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', '标题');
        $show->field('url', '链接地址');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Link());

        $form->text('title', '标题');
        $form->url('url', '链接地址');

        return $form;
    }
}
