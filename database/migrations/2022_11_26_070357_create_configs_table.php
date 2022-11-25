<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('operator')->nullable()->comment('操作人');
            $table->string('meta_key')->comment('配置键');
            $table->text('meta_value')->nullable()->comment('配置值');
            $table->string('meta_desc')->nullable()->comment('描述');
            $table->timestamps();

            $table->index('meta_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
