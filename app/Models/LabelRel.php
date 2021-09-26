<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class LabelRel extends Model
    {
        protected $table = 'bch_label_rel';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'from_ids' ,
            'label_code' ,
            'type',
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
