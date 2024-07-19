<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\messenger\app\Models\Message;
use Modules\messenger\app\Models\Traits\HasMessenger;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasMessenger;

    const ACTIVE_STATUS = [
        'inactive' => 1,
        'active' => 2,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function sendedMessages() : HasMany
    {
        return $this->hasMany(
            related: Message::class,
            foreignKey: 'from_id',
            localKey: 'id',
        );
    }

    public function recievedMessages() : HasMany
    {
        return $this->hasMany(
            related: Message::class,
            foreignKey: 'to_id',
            localKey: 'id',
        );
    }
}
