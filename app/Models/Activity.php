<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Speedy;

class Activity extends Model
{
    protected $table = 'bch_activity';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'start_time' ,
        'end_time',
        'address',
        'city_code',
        'price',
        'detail',
        'activity_ids' ,
        'user_ids' ,
        'pic' ,
        'sp_jg' ,
        'form_field' ,
        'sign_up_end_time' ,
        'detail_rich_text' ,
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
            $model->ids = uniqid() . str_random( 19 );
            //插入审批表
            Speedy::getModelInstance( 'sp' )->create( [
                'from_id'   => $model->ids ,
                'from_kind' => '2' ,
                'sp_title'     => $model->name ,
            ] );
        } );
    }

}
