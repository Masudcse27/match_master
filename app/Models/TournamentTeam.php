<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'tournaments_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
