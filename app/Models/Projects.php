<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'bch_projects';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'industry' ,
        'maturity' ,
        'cooperation' ,
        'title' ,
        'view_count' ,
        'user_ids' ,
        'description' ,
        'requirement' ,
        'valid' ,
        'like_count' ,
        'recommend',
        'qr_code',
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
        return $this->belongsTo('App\Models\PersonalInfo','user_ids','user_ids');
    }

    public function belongsToUserList()
    {
        return $this->belongsTo('App\Models\PersonalInfo','user_ids','user_ids')->select(['name', 'icon']);
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
