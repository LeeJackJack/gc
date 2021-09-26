<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdSession extends Model
{
    protected $table = 'gc_third_session';
    protected $primaryKey = 'ids';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openid' , 'unionid' , 'session_key' , 'valid' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function belongsToUser()
    {
        return $this->belongsTo('App/Models/Users','openid','openid')->where('valid','=','1');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(
            function ( $model )
            {
                $model->ids = uniqid() . str_random( 19 );
            }
        );
    }
}
