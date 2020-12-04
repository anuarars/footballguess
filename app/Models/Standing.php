<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = ['id','position', 'name', 'playedGames', 'won', 'draw', 'lost', 'points', 'goalsFor', 'goalsAgainst', 'goalDifference'];
}
