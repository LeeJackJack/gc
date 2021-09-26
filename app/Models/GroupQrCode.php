<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupQrCode extends Model
{
    protected $table = 'bch_group_qr_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_qr_code' ,
        'writer_qr_code' ,
        'valid',
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
