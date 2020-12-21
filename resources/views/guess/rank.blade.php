@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Таблица игроков</h2>	
        </div>
        <table class="table-default" id="rank">
            <tr class="t-header">
                <td>Пользователь</td>
                @foreach ($matchdays as $matchday)
                    <td>{{$matchday}}</td>
                @endforeach
                {{-- @for ($i = 1; $i <= 19; $i++)
                    <td>{{$i}}</td>
                @endfor --}}
                <td>Всего</td>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    @for ($i = 1; $i <= count($matchdays); $i++)
                        <td>
                            {{$user->guess->where('matchday', $i)->sum('points')}}
                        </td>
                    @endfor
                    <td></td>
                </tr>	
            @endforeach																		
        </table> <!-- Table Scores -->
    </div>
@endsection