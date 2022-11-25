<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('username')->unique();
            $table->string('name')->comment('账号名称');
            $table->string('password');
            $table->boolean('status')->default(true)->comment('账户状态 1:启用，0:停用');
            $table->integer('login_count')->default(0)->comment('登录次数');
            $table->timestamp('last_login')->nullable()->comment('最后登录时间');
            $table->ipAddress('last_login_ip')->nullable()->comment('最后登录ip');
            $table->unsignedBigInteger('group_id')->nullable()->comment('权限组');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
