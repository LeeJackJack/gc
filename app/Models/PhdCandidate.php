<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhdCandidate extends Model
{
    protected $table = 'bch_phd_candidates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_code' ,
        'name' ,
        'gender' ,
        'fore_institution' ,
        'now_institution' ,
        'department' ,
        'major' ,
        'enter_time' ,
        'educational_system' ,
        'phone' ,
        'email',
        'department_contact',
        'department_contact_position',
        'department_contact_phone',
        'department_contact_email',
        'remark',
        'information_from',
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

//        static::creating( function( $model )
//        {
//
//        } );
    }
}
