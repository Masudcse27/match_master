<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ground extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "cost_per_day",
        "ground_location",
        "description",
        "is_approved",
        "is_exist",
        "authority_id",
    ];
}
