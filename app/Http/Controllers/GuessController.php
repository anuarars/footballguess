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
use Illuminate\Database\Eloquent\Builder;

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
        

        $users = User::whereHas('guess', function (Builder $query) use ($matchday) {
            $query->where('matchday', $matchday);
        })->get();
        $schedules = Schedule::where('matchday', $matchday)->with('score')->orderBy('utcDate')->get();
        $guesses = Guess::where('matchday', $matchday)->get();

        
        foreach($guesses as $guess){
            $schedule = Schedule::where('id', $guess->schedule_id)->first();

            if(isset($guess->FThomeTeam) && isset($guess->FTawayTeam) && isset($schedule->score->FThomeTeam) && isset($schedule->score->FTawayTeam)
            ){
                if($schedule->score->FThomeTeam === $guess->FThomeTeam && $schedule->score->FTawayTeam === $guess->FTawayTeam){
                    $guess->update([
                        'points'=>3
                    ]);
                }elseif($schedule->score->FThomeTeam - $schedule->score->FTawayTeam == $guess->FThomeTeam - $guess->FTawayTeam){
                    $guess->update([
                        'points'=>2
                    ]);
                }elseif($schedule->score->FThomeTeam > $schedule->score->FTawayTeam && $guess->FThomeTeam > $guess->FTawayTeam){
                    $guess->update([
                        'points'=>1
                    ]);
                }elseif($schedule->score->FThomeTeam < $schedule->score->FTawayTeam && $guess->FThomeTeam < $guess->FTawayTeam){
                    $guess->update([
                        'points'=>1
                    ]);
                }else{
                    $guess->update([
                        'points'=>0
                    ]);
                }
            }
        }
        
        return view('guess.create', compact('schedules', 'users', 'matchday'));
    }

    public function store(Request $request){
        $homeTeam = $request->FThomeTeam;
        $awayTeam = $request->FTawayTeam;

        $schedules = Schedule::where('matchday', $request->matchday)->get();
        foreach($schedules as $schedule){
            Guess::updateOrCreate([
                'schedule_id' => $schedule->id,
                'user_id' => Auth::id()
            ],[
                'user_id' => Auth::id(),
                'utcDate' => $schedule->utcDate,
                'schedule_id' => $schedule->id,
                'matchday' => $request->matchday,
                'homeTeamId' => $schedule->homeTeamId,
                'awayTeamId' => $schedule->awayTeamId
            ]);
        }

        //REFACTOR expected----->
        foreach($homeTeam as $scheduleId => $matchday){
            foreach($matchday as $matchday => $homeTeamId){
                foreach($homeTeamId as $homeTeamId => $score){
                    foreach($score as $score){
                        Guess::where([['schedule_id', $scheduleId],['user_id', Auth::id()]])->update([
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
                            'FTawayTeam' => $score
                        ]);
                    }
                }
            }
        }
        //<-----REFACTOR expected

        return redirect()->back();
    }

    public function rank(){
        $matchdays = DB::table('schedules')
            ->select('matchday')
            ->where('utcDate','<',now())
            ->orderBy('matchday')
            ->distinct()
            ->pluck('matchday');

        $users = User::with('guess')->get();

        return view('guess.rank', compact('users', 'matchdays'));
    }

}