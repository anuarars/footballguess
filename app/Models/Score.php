<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'schedule_id', 'HThomeTeam', 'HTawayTeam', 'FThomeTeam', 'FTawayTeam', 'EThomeTeam', 'ETawayTeam', 'PThomeTeam','PTawayTeam'
    ];

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
}