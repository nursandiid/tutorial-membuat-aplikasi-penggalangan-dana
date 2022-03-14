<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    public function bank_user()
    {
        return $this->belongsToMany(Bank::class, 'bank_user', 'user_id')
            ->withPivot('account', 'name', 'is_main')
            ->withTimestamps();
    }

    public function mainAccount()
    {
        return $this->bank_user()
            ->where('is_main', 1)
            ->first();
    }

    public function scopeDonatur($query)
    {
        return $query->whereHas('role', function ($query) {
            $query->where('name', 'donatur');
        });
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'user_id', 'id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id', 'id');
    }
}
