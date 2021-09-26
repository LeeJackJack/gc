<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class PersonalInfo extends Model
    {
        protected $table = 'bch_personal_info';
        protected $primaryKey = 'ids';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name' ,
            'icon' ,
            'company' ,
            'phone' ,
            'email' ,
            'learning' ,
            'user_ids' ,
            'valid' ,
            'intro',
            'skill',
            'real_name' ,
            'resume_url',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [//
        ];

        public function belongsToUser()
        {
            return $this->belongsTo( 'App\Models\Users' , 'user_ids' , 'ids' );
        }

        public function hasManyEducation()
        {
            return $this->hasMany( 'App\Models\Education' , 'personal_ids' , 'user_ids' )->where( 'valid' , '=' ,
                '1' )->select( [
                'id' ,
                'start_time' ,
                'end_time' ,
                'school' ,
                'degree' ,
                'major' ,
            ] );
        }

        public function hasManyWorking()
        {
            return $this->hasMany( 'App\Models\Working' , 'personal_ids' , 'user_ids' )->where( 'valid' , '=' ,
                '1' )->select( [
                'id' ,
                'start_time' ,
                'end_time' ,
                'company' ,
                'job' ,
                'content' ,
            ] );
        }

        public function hasManyHonor()
        {
            return $this->hasMany( 'App\Models\Honor' , 'personal_ids' , 'user_ids' )->where( 'valid' , '=' ,
                '1' )->select( [
                'time' ,
                'title' ,
                'id' ,
            ] );
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
