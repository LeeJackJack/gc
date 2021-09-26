<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    protected $table = 'bch_requirement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name' ,
        'detail',
        'industry' ,
        'location' ,
        'property' ,
        'employee_number' ,
        'manager_number' ,
        'higher_class_number' ,
        'middle_class_number' ,
        'junior_class_number' ,
        'type' ,
        'classification' ,
        'patent' ,
        'appraise' ,
        'introduce' ,
        'cooperate' ,
        'entrust' ,
        'other' ,
        'transfer',
        'stockshare',
        'institutions',
        'budget' ,
        'more' ,
        'contact' ,
        'phone' ,
        'email' ,
        'com_intro' ,
        'email' ,
        'requirement_number' ,
        'problem_number' ,
        'valid' ,
        'qr_code' ,
        'recommend'
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
