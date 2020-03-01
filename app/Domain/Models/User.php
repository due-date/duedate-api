<?php

namespace App\Domain\Models;

use App\Notifications\MailResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property mixed id
 */
class User extends ModelAbstract implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    JWTSubject,
    MustVerifyEmail
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmailTrait;

    protected $hidden = ['remember_token',];

    protected $dates = ['birth' => 'Y-m-d'];

    protected $table = 'users';

    protected $casts = ['email_verified_at' => 'datetime'];

    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'gender',
        'birth',
        'photo',
        'password',
        'active',
        'email',
        'email_verified_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
}
