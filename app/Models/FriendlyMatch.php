<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendlyMatch extends Model
{
    use HasFactory;
    protected $fillable =[
        "team_1",
        "team_2",
        "match_date",
        "start_time"
    ];
    public function teamOne()
    {
        return $this->belongsTo(Team::class, 'team_1');
    }
}
