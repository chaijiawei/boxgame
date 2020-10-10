<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCategoryIdForeignToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('set null');
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        DB::table('topics')->whereNull('category_id')->delete();
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
}
