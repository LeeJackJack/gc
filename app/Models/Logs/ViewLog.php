<?php

    namespace App\Models\Logs;

    use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $table = 'bch_view_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_ids' ,
        'type' ,
        'target_ids' ,
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
