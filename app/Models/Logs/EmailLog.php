<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'bch_email_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to' ,
        'operator' ,
        'result' ,
        'error_msg' ,
        'type' ,
        'relevant_ids' ,
        'real_send' ,
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
