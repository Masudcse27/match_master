<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        "player_id",
        "player_type",
        "address",
        "total_match",
        "total_run",
        "total_wicket",
    ];
}
