<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_tour', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',125)->comment('线路名称');
            $table->integer('hour')->comment('所需时间，单位分钟');
            $table->integer('spots')->comment('景点数');
            $table->integer('distance')->comment('路线距离，单位米');
            $table->string('route',125)->comment('经过路线，数组');
            $table->char('valid',1);
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
        Schema::dropIfExists('gc_tour');
    }
}
