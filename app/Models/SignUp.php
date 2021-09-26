<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignUp extends Model
{
    protected $table = 'bch_sign_up';
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
        'company' ,
        'job' ,
        'valid' ,
        'user_ids',
        'activity_ids' ,
        'is_handle' ,
        'email' ,
        'field' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public function belongsToActivity()
    {
        return $this->belongsTo('App\Models\Activity','activity_ids','ids');
    }

    public function belongsToUser()
    {
        return $this->belongsTo('App\Models\Users','user_ids','ids');
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
