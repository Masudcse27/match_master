<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        "t_name",
        "t_description",
        "t_title",
        "t_manager"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
