<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverseaActivitySignUp extends Model
{
    protected $table = 'bch_oversea_activity_sign_up';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization' ,
        'name' ,
        'gender' ,
        'birthday' ,
        'region',
        'country',
        'province',
        'settleCountry',
        'settleCity',
        'idCard',
        'idCardNum',
        'school',
        'major',
        'edu',
        'corporation',
        'job',
        'phone',
        'foreignPhone',
        'email',
        'wechat',
        'project',
        'valid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
            //
        } );
    }
}
