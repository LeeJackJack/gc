<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

class UpdateLog extends Model
{
    protected $table = 'bch_update_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author' ,
        'content' ,
        'valid' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
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
