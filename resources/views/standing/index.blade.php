@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Турнирная таблица</h2>	
        </div>
        <table class="table-default" id="standing">
            <tr class="t-header">
                <td>#</td>
                <td>Команда</td>
                <td>И</td>
                <td>В</td>
                <td>Н</td>
                <td>П</td>
                <td>ЗМ</td>
                <td>ПМ</td>
                <td>РМ</td>
                <td>О</td>
            </tr>
            @foreach ($teams as $team)
                <tr>
                    <td>{{$team->position}}</td>
                    <td>{{$team->name}}</td>
                    <td>{{$team->playedGames}}</td>
                    <td>{{$team->won}}</td>
                    <td>{{$team->draw}}</td>
                    <td>{{$team->lost}}</td>
                    <td>{{$team->goalsFor}}</td>
                    <td>{{$team->goalsAgainst}}</td>
                    <td>{{$team->goalDifference}}</td>
                    <td>{{$team->points}}</td>
                </tr>
            @endforeach																				
        </table> <!-- Table Scores -->
    </div>  
@endsection