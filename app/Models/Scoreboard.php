<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    use HasFactory;
    protected $fillable = [
        'match_id',
        'team_id',
        'ball_number',
        'run',
        'run_type',
    ];

    public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }

    /**
     * Get the team associated with the scoreboard entry.
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
