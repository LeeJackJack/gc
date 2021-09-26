<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Label extends Model
    {
        protected $table = 'bch_label';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'label' ,
            'pid' ,
            'valid' ,
            'remarks' ,
            'order_id' ,
            'code' ,
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
                $model->ids = uniqid() . str_random( 19 );
            } );
        }
    }
