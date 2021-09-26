<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    protected $table = 'bch_recommend';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'phone' ,
        'school' ,
        'major' ,
        'education' ,
        'user_ids' ,
        'job_ids' ,
        'status' ,
        'valid' ,
        'is_pay' ,
        'is_handle' ,
        'type' ,
        'email' ,
        'is_send_required_resume_email' ,
        'is_send_received_resume_email' ,
        'is_send_inform_company_email' ,
        'company_read',
        'skill',
        'experience',
        'honor',
        'eduBg',
        'intro',
        'resume_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public function belongsToUser()
    {
        return $this->belongsTo('App\Models\Users','user_ids','ids');
    }

    public function belongsToJob()
    {
        return $this->belongsTo('App\Models\Job','job_ids','ids');
    }

    public function hasManyEmailLogs()
    {
        return $this->hasMany('App\Models\Logs\EmailLog','relevant_ids','ids')->orderBy('created_at','DESC');
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
            $model->ids = uniqid() . str_random( 19 );
        } );
    }
}
