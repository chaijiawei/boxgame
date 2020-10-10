<?php

namespace App\Admin\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', '用户名');
        $grid->column('avatar', '头像')->image('', 60);
        $grid->column('email', '邮箱地址');
        $grid->column('email_verified_at', '邮箱认证时间');
        $grid->column('created_at', '注册时间');
        $grid->column('github_id', 'github注册')->display(function($value) {
            return $value ? '是' : '否';
        });

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', '用户名');
        $show->field('avatar', '头像')->image();
        $show->field('email', '邮箱地址');
        $show->field('email_verified_at', '邮箱认证时间');
        $show->field('created_at', '注册时间');
        $show->field('updated_at', '更新时间');
        $show->field('github_id', __('Github id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', '用户名');
        $form->email('email', '邮箱地址');
        $form->datetime('email_verified_at', '邮箱认证时间')->default(date('Y-m-d H:i:s'));
        $form->password('password', '密码')->rules(function(Form $form) {
            $rules = ['min:8'];
            if($form->model()->id) {
                $rules[] = 'nullable';
            }

            return $rules;
        });
        $form->image('avatar', '头像')->uniqueName();

        $form->submitted(function(Form $form) {
            if(! request()->password) {
                $form->ignore('password');
            }
        });

        $form->saving(function(Form $form) {
            if($password = $form->password) {
                $form->password = bcrypt($password);
            }
        });

        return $form;
    }
}
