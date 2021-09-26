<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_third_session', function (Blueprint $table) {
            $table->string( 'ids' );
            $table->primary( 'ids' );
            $table->string( 'openid' )->nullable()->comment( '用户openid' );
            $table->string( 'unionid' )->nullable()->comment( 'unionid' );
            $table->string( 'session_key' )->nullable()->comment( 'session_key' );
            $table->char( 'valid' , 1 )->default( '1' );
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
        Schema::dropIfExists('gc_third_session');
    }
}
