<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('title')->nullable()->comment('标题');
            $table->string('forms')->nullable()->comment('表单');
            $table->string('poster')->nullable()->comment('缩略图路径');
            $table->text('content')->nullable()->comment('table集成数据');
            $table->smallInteger('sort', false, true)->nullable()->comment('排序');
            $table->boolean('repeatable')->default(false)->comment('0不能重复/1开启重复');
            $table->string('repetition_name')->nullable()->comment('重复项判断值');
            $table->boolean('active')->default(true)->comment('0关闭/1显示');
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
        Schema::dropIfExists('activities');
    }
}
