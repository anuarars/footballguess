<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    protected $fillable = ['user_id', 'schedule_id', 'utcDate', 'matchday', 'homeTeamId', 'awayTeamId', 'FThomeTeam', 'FTawayTeam', 'points'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
}
