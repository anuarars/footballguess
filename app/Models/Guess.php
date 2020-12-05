<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    protected $fillable = ['user_id', 'schedule_id', 'matchday', 'homeTeamId', 'awayTeamId', 'FThomeTeam', 'FTawayTeam', 'points'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
