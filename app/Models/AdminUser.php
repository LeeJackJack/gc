<?php

    namespace App\Models;

    use Hanson\Speedy\Traits\PermissionTrait;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class AdminUser extends Authenticatable
    {
        use Notifiable , PermissionTrait;

        protected $table = 'pt_user';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name' ,
            'email' ,
            'password' ,
            'role_id',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password' ,
            'remember_token' ,
        ];
    }
