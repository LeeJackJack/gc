<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoshanDoctorLike extends Model
{
    protected $table = 'bch_foshan_doctor_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'phone' ,
        'company',
        'valid',
        'likeId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [//
    ];

    public function belongsToDoctor()
    {
        return $this->belongsTo('App\Models\FoshanDoctor','likeId','id')->where('valid','=','1');
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function( $model )
        {
            //
        } );
    }
}
