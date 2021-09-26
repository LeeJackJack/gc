<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Speedy;

    class Users extends Model
    {
        protected $table = 'bch_users';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        //禁用自带时间戳更新功能
        public $timestamps = false;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'openid' ,
            'name' ,
            'icon' ,
            'count' ,
            'valid' ,
            'alias' ,
            'intro' ,
            'sex' ,
            'language' ,
            'country' ,
            'province' ,
            'city' ,
            'unionid' ,
            'verify_code' ,
            'phone' ,
            'wx_id' ,
            'salt' ,
            'password' ,
            'balance' ,
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'salt' ,
            'password' ,
        ];

        public static function boot()
        {
            parent::boot();

            static::creating( function( $model )
            {
                $model->ids = uniqid() . str_random( 19 );

//                /**
//                 * 增加用户信息表，在微信用户创建同时生成用户信息表
//                 *
//                 * @author Lee 2019/04/11
//                 */
//                Speedy::getModelInstance('personal_info')->create([
//                    'user_ids' => $model->ids,
//                    'name' => $model->name,
//                    'icon' => $model->icon,
//                ]);
            } );
        }
    }
