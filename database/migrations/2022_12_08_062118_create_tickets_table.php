<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('username')->comment('用户名');
            $table->unsignedBigInteger('activity_id')->nullable()->comment('活动名称');
            $table->json('data')->comment('申请数据字典');
            $table->integer('bonus', false, true)->default(0)->comment('赠送金额');
            $table->ipAddress('ip_address')->comment('抽奖ip');
            $table->string('feedback')->nullable()->comment('管理员回复');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->comment('未派送/已派送/已拒绝');
            $table->unsignedBigInteger('handler_id')->nullable()->comment('操作人');
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities')->nullOnDelete();
            $table->foreign('handler_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
