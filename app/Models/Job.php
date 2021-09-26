<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Speedy;

    class Job extends Model
    {
        protected $table = 'bch_job';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'title' ,
            'com_ids' ,
            'salary' ,
            'hire_count' ,
            'reward' ,
            'city_code' ,
            'type' ,
            'detail' ,
            'pic' ,
            'qr_code' ,
            'sp_jg' ,
            'valid' ,
            'order_id' ,
            'address' ,
            'education' ,
            'experience' ,
            'industry' ,
            'detail_rich_text' ,
            'special_subject_id' ,
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [//
        ];

        public function belongsToCompany()
        {
            return $this->belongsTo( 'App\Models\Company' , 'com_ids' , 'ids' );
        }

        public function belongsToIndustry()
        {
            return $this->belongsTo( 'App\Models\Label' , 'industry' , 'code' );
        }

        public function belongsToCity()
        {
            return $this->belongsTo( 'App\Models\Label' , 'city_code' , 'code' );
        }

        public static function boot()
        {
            parent::boot();

            static::creating( function( $model )
            {
                $model->ids = uniqid() . str_random( 10 );
                //插入审批表
                Speedy::getModelInstance( 'sp' )->create( [
                    'from_id'   => $model->ids ,
                    'from_kind' => '1' ,
                    'sp_title'  => $model->title ,
                ] );
            } );
        }
    }
