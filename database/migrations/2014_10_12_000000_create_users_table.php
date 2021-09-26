<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gc_users', function (Blueprint $table) {
            $table->string( 'ids' );
            $table->string( 'openid' )->nullable()->comment('微信号对应的openid');
            $table->string( 'name' )->nullable()->comment('名称');
            $table->string( 'icon' )->nullable()->comment('微信头像路径');
            $table->timestamp( 'create_time' , 0 )->nullable()->comment('创建时间');
            $table->timestamp( 'update_time' , 0 )->nullable()->comment('更新时间');
            $table->integer( 'count' )->default( 0 )->comment('登录次数');
            $table->char( 'valid' )->default( '1' );
            $table->string( 'alias' )->nullable()->comment('备注名称，比如用户的真实姓名');
            $table->integer( 'sex' )->nullable()->comment('性别，1：男，0：女');
            $table->string( 'language' )->nullable(); //用户微信的语言，如，中文，英文
            $table->string( 'country' )->nullable();
            $table->string( 'province' )->nullable();
            $table->string( 'city' )->nullable();
            $table->string( 'unionid' )->nullable()->comment('微信用户unionid');
            $table->string( 'verify_code' )->nullable()->comment('验证码');
            $table->string( 'phone' )->nullable()->comment('用户手机');
            $table->string( 'wx_id' )->nullable()->comment('微信号');
            $table->string( 'salt' )->nullable()->comment('盐值');
            $table->string( 'password' )->nullable()->comment('密码');
            $table->decimal( 'balance' )->nullable()->comment('账户余额');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gc_users');
    }
}
