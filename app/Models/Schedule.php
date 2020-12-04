<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'id', 'matchday', 'utcDate', 'status', 'lastUpdated', 'homeTeamId', 'awayTeamId', 'homeTeamName', 'awayTeamName'
    ];

    public function score(){
        return $this->hasOne(Score::class);
    }
}
