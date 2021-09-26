<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $table = 'bch_search_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyword' ,
        'user_ids' ,
        'count_result' ,
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
