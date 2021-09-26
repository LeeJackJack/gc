<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Banner extends Model
    {
        protected $table = 'bch_banner';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'pic' ,
            'order_id' ,
            'detail_ids',
            'type',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [//
        ];

        public function belongsToJob()
        {
            return $this->belongsTo('App\Models\Job','job_ids','ids');
        }

        public static function boot()
        {
            parent::boot();

            static::creating( function( $model )
            {
                $model->ids = uniqid() . str_random( 19 );
            } );
        }

    }
