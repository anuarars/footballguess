<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        // $i = date('i')+1;
        // $currentTime = date('h:i:s');
        // $finishTime = date('h:'.$i.':s');

        // set_time_limit(0); // make it run forever
        // while($currentTime < $finishTime) {
        //     Test::create([
        //         'text' => 'test'
        //     ]);
        //     sleep(5);
        // }

        // return "teset";
    }
}
