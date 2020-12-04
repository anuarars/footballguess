<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(){
        $client = new Client();

        $uri = 'http://api.football-data.org/v2/competitions/PL/teams';
        $header = array('headers' => array('X-Auth-Token' => '19623fc0754945d886816817c8768086'));
        $response = $client->get($uri, $header);
        $data = json_decode($response->getBody());

        foreach($data->teams as $team){
            Team::updateOrCreate([
                'name' => $team->name
            ],
            [
                'name' => $team->name,
                'shortName' => $team->shortName,
                'venue' => $team->venue,
                'crestUrl' => $team->crestUrl,
            ]);
        }

        $teams = Team::all();

        return view('team.index', compact('teams'));
    }
}
