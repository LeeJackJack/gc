<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_update_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'author' ,64)->comment( '作者' );
            $table->text( 'content' )->comment( '内容' );
            $table->char( 'valid',1 )->default('1');
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
        Schema::dropIfExists('gc_update_logs');
    }
}
