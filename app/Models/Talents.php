<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talents extends Model
{
    protected $table = 'bch_talents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'major' ,
        'phone',
        'school',
        'user_ids',
        'job_ids' ,
        'if_contact',
        'if_resume',
        'if_contact_com',
        'resume_url',
        'valid',
        'email',
        'nowMajor',
        'gender',
        'company',
        'position',
        'education',
        'tel',
        'email',
        'workStation',
        'getInStation',
        'getOutStation',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public function hasManyContacts()
    {
        return $this->hasMany('App\Models\ContactInfo','talent_ids','id')->where('valid','1');
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
            //
        } );
    }
}
