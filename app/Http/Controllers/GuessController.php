<?php

namespace App\Http\Controllers;

use App\Models\Guess;
use App\Models\Season;
use App\Models\Schedule;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuessController extends Controller
{
    public function index(){
        $matchday = DB::table('schedules')
            ->select('matchday')
            ->where('utcDate','>',now())
            ->first()
            ->matchday;
        return redirect()->route('guess.show', $matchday);
    }

    public function show($matchday){
        $client = new Client();
        $uri = 'https://api.football-data.org/v2/competitions/PL/matches?matchday='.$matchday.'';
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

        $schedules = Schedule::where('matchday', $matchday)->orderBy('utcDate')->get();
        return view('guess.create', compact('schedules'));
    }

    public function store(Request $request){
        $homeTeam = $request->FThomeTeam;
        $awayTeam = $request->FTawayTeam;

        foreach($homeTeam as $scheduleId => $matchday){
            foreach($matchday as $matchday => $homeTeamId){
                foreach($homeTeamId as $homeTeamId => $score){
                    foreach($score as $score){
                        Guess::updateOrCreate([
                            'user_id' => Auth::id(),
                            'schedule_id' => $scheduleId,
                        ],[
                            'user_id' => Auth::id(),
                            'schedule_id' => $scheduleId,
                            'matchday' => $matchday,
                            'homeTeamId' => $homeTeamId,
                            'FThomeTeam' => $score
                        ]);
                    }
                }
            }
        }
        foreach($awayTeam as $scheduleId => $matchday){
            foreach($matchday as $matchday => $awayTeamId){
                foreach($awayTeamId as $awayTeamId => $score){
                    foreach($score as $score){
                        Guess::where([['schedule_id', $scheduleId],['user_id', Auth::id()]])->update([
                            'awayTeamId' => $awayTeamId,
                            'FTawayTeam' => $score
                        ]);
                    }
                }
            }
        }
        return redirect()->back();
    }

    public function tableByMatchday($matchday){
        $users = User::all();
        return view('table.index', compact('users'));
    }
}