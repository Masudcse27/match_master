<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "manager_id",
        "number_of_team",
        "description",
        "registration_last_date",
        "start_date",
        "end_date",
    ];

    public function teams()
    {
        return $this->hasMany(TournamentTeam::class, 'tournaments_id');
    }
}
