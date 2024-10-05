<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nid',
        'phone_number',
        'email',
        'password',
        'role',
        'is_admin_approved',
        'verification_code',
        'is_email_verified'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function teamSquads()
    {
        return $this->hasOne(TeamSquads::class, 'player_id');
    }

    public function playerInfo()
    {
        return $this->hasOne(PlayerInfo::class, 'player_id');
    }

    public function matchBattingHistories()
    {
        return $this->hasMany(MatchBattingHistory::class, 'player_id');
    }

    public function matchBowlingHistories()
    {
        return $this->hasMany(MatchBowlingHistory::class, 'player_id');
    }
}
