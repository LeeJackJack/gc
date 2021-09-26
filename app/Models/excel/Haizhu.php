<?php

namespace App\Models\excel;

use Illuminate\Database\Eloquent\Model;

class Haizhu extends Model
{
    protected $table = 'haizhu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'line1','line2','line3','line4','line5','line6', 'line7', 'line8','line9','line10','line11','line12','line13','line14','line15','line16'
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
