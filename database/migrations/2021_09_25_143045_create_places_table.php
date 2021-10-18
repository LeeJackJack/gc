<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePlacesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('gc_place', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',125)->comment('景点名称');
                $table->string('ticket',125)->comment('门票');
                $table->string('pic',255)->comment('景点图片，oss地址');
                $table->string('icon',255)->comment('景点icon，oss地址');
                $table->string('illustrator',255)->comment('景点插画，oss地址');
                $table->string('icon_select',125)->comment('景点icon,选中状态，oss地址');
                $table->string('longitude',125)->comment('经度');
                $table->string('latitude',125)->comment('纬度');
                $table->string('business_hour',64)->comment('开放时间');
                $table->text('introduction')->comment('景点介绍');
                $table->string('address',125)->comment('景点地址');
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
            Schema::dropIfExists('gc_place');
        }
    }
