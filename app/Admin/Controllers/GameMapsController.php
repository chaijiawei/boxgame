<?php

namespace App\Admin\Controllers;

use App\Models\GameMap;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GameMapsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '地图数据';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GameMap());

        $grid->column('id', '地图ID')->sortable();
        $grid->column('level', '关卡')->editable()->sortable()->filter();
        $grid->column('map_data_json', '地图信息')
            ->display(function() {
            return json_encode($this->map_data, JSON_UNESCAPED_UNICODE);
        })
        ->width(400);
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉编辑
            $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
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
        $show = new Show(GameMap::findOrFail($id));

        $show->field('id', '地图ID');
        $show->field('level', '关卡');
        $show->field('map_data', '地图信息');
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
        $form = new Form(new GameMap());

        $form->number('level', __('Level'));
        $form->text('map_data', __('Map data'));

        return $form;
    }
}
