<?php

namespace App\Admin\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '话题管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic());

        $grid->column('id', __('Id'));
        $grid->column('title', '标题')->display(function($title, $column) {
            return $column->link($this->link());
        });
        $grid->column('user.name', '作者');
        $grid->column('category.name', '分类');
        $grid->column('view_count', '浏览量');
        $grid->column('created_at', '创建时间');

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
        $show = new Show(Topic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', '标题');
        $show->field('user', '作者')->as(function($user) {
            return $user->name;
        });
        $show->field('category', '分类')->as(function($category) {
            return $category->name;
        });
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');
        $show->field('view_count', '浏览量');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Topic());

        $form->text('title', '标题');
        $form->select('user_id', '作者')->options(function() {
            return User::all()->pluck('name', 'id');
        });
        $form->select('category_id', '分类')->options(function() {
            return Category::all()->pluck('name', 'id');
        });
        $form->simditor('content', '话题内容');

        return $form;
    }

    public function apiUploadImage(Request $request, ImageUploadHandler $imgHandler)
    {
        $validator = Validator::make(
            $request->all(),
            ['upload_file' => ['required', 'image']],
            [],
            ['upload_file' => '上传文件']
        );

        $response = [
            'success'   => true,
            'msg'       => '',
            'file_path' => '',
        ];
        if($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorStr = implode('，', $errors);
            $response['success'] = false;
            $response['msg'] = $errorStr;
            return $response;
        }

        $response['file_path'] = $imgHandler->save($request->upload_file, 'topics', 'admin', 800, true);
        return $response;
    }
}
