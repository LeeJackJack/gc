<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeProject extends Model
{
    protected $table = 'bch_like_projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'company' ,
        'job' ,
        'valid' ,
        'user_ids',
        'project_ids',
        'is_handle',
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

    public function belongsToProject()
    {
        return $this->belongsTo('App\Models\Projects','project_ids','ids');
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
