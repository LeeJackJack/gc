<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'bch_company';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'property' ,
        'scale',
        'type',
        'com_intro',
        'is_ipo',
        'email',
        'valid' ,
        'qr_code' ,
        'special_subject_id' ,
        'recommend' ,
        'qr_code_subject' ,
        'contact',
        'phone',
        'cellPhone',
        'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public function hasManyJobs()
    {
        return $this->hasMany('App\Models\Job','com_ids','ids')->where('valid','1');
    }

    public function hasManySubjectJobs()
    {
        return $this->hasMany('App\Models\Job','com_ids','ids')->where('valid','1')->where('special_subject_id','1');
    }

    public function hasManyPillDoctorJobs()
    {
        return $this->hasMany('App\Models\Job','com_ids','ids')->where('valid','1')->where('special_subject_id','3');
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
            $model->ids = uniqid() . str_random( 10 );
        } );
    }

}
