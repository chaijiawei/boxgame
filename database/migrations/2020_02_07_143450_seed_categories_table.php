<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SeedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            [
                'name' => '技术',
                'description' => '刻意练习，每日精进',
            ],

            [
                'name' => '分享',
                'description' => '分享快乐，共同成长',
            ],

            [
                'name' => '问答',
                'description' => '答疑解惑，问答必备',
            ],

            [
                'name' => '其它',
                'description' => '好吧，我迷失了，so ^_^#',
            ],
        ];
        $now = now();
        foreach($data as $index => $row) {
            $data[$index]['created_at'] = $now;
            $data[$index]['updated_at'] = $now;
        }
        DB::table('categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
