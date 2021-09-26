<?php

    namespace App\Models\Logs;


use Illuminate\Database\Eloquent\Model;

class SelectIndustryLog extends Model
{
    protected $table = 'bch_select_industry_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'industry_code' ,
        'user_ids' ,
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
