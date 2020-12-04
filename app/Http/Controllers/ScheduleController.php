<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Score;
use App\Models\Season;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request){
        $dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');

        if($request->has('month') || $request->has('year')){
            $dateFrom = Carbon::create($request->year, $request->month)->startOfMonth()->format('Y-m-d');
            $dateTo = Carbon::create($request->year, $request->month)->lastOfMonth()->format('Y-m-d');
        }

        $client = new Client();
        $uri = 'https://api.football-data.org/v2/competitions/PL/matches?dateFrom='.$dateFrom.'&dateTo='.$dateTo.'';
        $header = array('headers' => array('X-Auth-Token' => '19623fc0754945d886816817c8768086'));
        $response = $client->get($uri, $header);
        $data = json_decode($response->getBody());
        $matches = $data->matches;

        foreach($matches as $match){
            Season::updateOrCreate([
                'id' => $match->season->id
            ],
            [
                'id' => $match->season->id,
                'startDate' => $match->season->startDate,
                'endDate' => $match->season->endDate
            ]);

            Schedule::updateOrCreate([
                'id' => $match->id
            ],
            [
                'id' => $match->id,
                'season_id' => $match->season->id,
                'matchday' => $match->matchday,
                'utcDate' => substr($match->utcDate, 0, -1),
                'status' => $match->status,
                'lastUpdated' => substr($match->lastUpdated, 0, -1),
                'homeTeamId' => $match->homeTeam->id,
                'awayTeamId' => $match->awayTeam->id,
                'homeTeamName' => $match->homeTeam->name,
                'awayTeamName' => $match->awayTeam->name,
            ]);
      
            Score::updateOrCreate([
                'schedule_id' => $match->id
            ],
            [
                'schedule_id' => $match->id,
                'HThomeTeam' => $match->score->halfTime->homeTeam,
                'HTawayTeam' => $match->score->halfTime->awayTeam,
                'FThomeTeam' => $match->score->fullTime->homeTeam,
                'FTawayTeam' => $match->score->fullTime->awayTeam,
                'EThomeTeam' => $match->score->extraTime->homeTeam,
                'ETawayTeam' => $match->score->extraTime->awayTeam,
                'PThomeTeam' => $match->score->penalties->homeTeam,
                'PTawayTeam' => $match->score->penalties->awayTeam,
            ]);
        }
        
        $schedules = Schedule::whereBetween('utcDate',[$dateFrom, $dateTo])->groupBy('utcDate')->get();

        // $schedules = Schedule::orderBy('matchday')->get()->groupBy(function($item) {
        //     return $item->matchday;
        // });
        dd($schedules);
        return view('schedule.index',compact('schedules'));
    }
}