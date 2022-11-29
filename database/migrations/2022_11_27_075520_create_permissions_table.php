<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('pid')->default(0)->comment('父id');
            $table->string('title')->default('')->comment('名称');
            $table->string('icon')->default('fa fa-gears')->comment('菜单图标');
            $table->string('href')->default('')->comment('链接');
            $table->string('target', 20)->default('_self')->comment('链接打开方式');
            $table->string('level', 10)->default(0)->comment('菜单排序');
            $table->boolean('status')->default(true)->comment('状态');
            $table->string('action')->nullable()->comment('请求方法');
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
        Schema::dropIfExists('permissions');
    }
}
