<?php
/*
 * @Author: DanceLynx
 * @Description: 创建帖子分类表
 * @Date: 2020-06-22 08:08:02
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30)->index()->comment('名称');
            $table->string('description')->default('')->comment('描述');
            $table->unsignedInteger('post_count')->default(0)->comment('帖子数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
