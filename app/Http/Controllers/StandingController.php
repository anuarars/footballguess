<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Standing;
use GuzzleHttp;

class StandingController extends Controller
{
    public function index(){
        //$data = Http::get('https://api.football-data.org/v2/competitions/PL/matches?matchday=11')->body();

        // $client = new Client();
        // $response = $client->get('https://jsonplaceholder.typicode.com/posts');
        // $data = json_decode($response->getBody());

        $client = new Client();

        $uri = 'http://api.football-data.org/v2/competitions/PL/standings?standingType=TOTAL';
        $header = array('headers' => array('X-Auth-Token' => '19623fc0754945d886816817c8768086'));
        $response = $client->get($uri, $header);
        $data = json_decode($response->getBody());
        // $data = json_decode($response->getBody(), true);
        foreach($data->standings as $standings){
            foreach($standings->table as $table){
                Standing::updateOrCreate([
                    'id' => $table->team->id,
                    'name' => $table->team->name
                ],
                [
                    'id' => $table->team->id,
                    'position' => $table->position,
                    'name' => $table->team->name,
                    'playedGames' => $table->playedGames,
                    'won' => $table->won,
                    'draw' => $table->draw,
                    'lost' => $table->lost,
                    'points' => $table->points,
                    'goalsFor' => $table->goalsFor,
                    'goalsAgainst' => $table->goalsAgainst,
                    'goalDifference' => $table->goalDifference,
                ]);
            }
        }
        $teams = Standing::orderBy('points', 'desc')->get();
        return view('standing.index', compact('teams'));
    }
}
