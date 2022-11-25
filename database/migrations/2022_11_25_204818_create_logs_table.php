<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('operator')->default('系统')->comment('操作人');
            $table->string('type')->default('一般的')->comment('事件类型');
            $table->text('description')->nullable()->comment('描述');
            $table->timestamps();

            $table->index('operator');  // @brevis-ng: Add index to operator

            $table->dropColumn('updated_at');  // @brevis-ng: Drop one of timestamps column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
