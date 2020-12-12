@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Тотализатор</h2>	
        </div>
        <form action="{{route('guess.store', $matchday)}}" method="POST">
            @csrf
            <table class="table-default">
                <tr class="t-header">
                    <td colspan="5" class="score-date">55</td>
                </tr>
                @foreach ($schedules as $match)
                    <tr class="match">
                        <td class="match__status">
                            @switch($match->status)
                                @case('FINISHED')
                                    <span class="text-success">Завершился</span>
                                    @break
                                @case('IN_PLAY')
                                    <span class="text-danger blink">
                                        @if (\Carbon\Carbon::parse($match->utcDate)->diffInMinutes(now())>60)
                                            {{\Carbon\Carbon::parse($match->utcDate)->diffInMinutes(now())-15}}
                                        @else
                                            {{\Carbon\Carbon::parse($match->utcDate)->diffInMinutes(now())}}
                                        @endif
                                        '
                                    </span>
                                    @break
                                @case('PAUSED')
                                    <span class="text-primary">Перерыв</span>
                                    @break
                                @case('SCHEDULED')
                                    <span class="text-warning">
                                        {{\Carbon\Carbon::parse($match->utcDate)->diffForHumans()}}
                                    </span>
                                    @break
                            @endswitch
                        </td>
                        <td class="match__teamname">{{$match->homeTeamName}}</td>
                        <td class="text-center match__score">
                            <span>
                                @if ($match->status == "FINISHED")
                                    <span class="text-success">
                                        {{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}}
                                    </span>
                                @elseif ($match->status == "IN_PLAY" || $match->status == "PAUSED" )
                                    <span class="text-danger blink">
                                        {{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}}
                                    </span>
                                @else
                                    @if (count(Auth::user()->guess->where('schedule_id', $match->id))>0)
                                        @foreach (Auth::user()->guess->where('schedule_id', $match->id) as $guess)
                                            <input type="text" name="FThomeTeam[{{$match->id}}][{{$match->matchday}}][{{$match->homeTeamId}}][]" value="{{$guess->FThomeTeam}}"> : 
                                            <input type="text" name="FTawayTeam[{{$match->id}}][{{$match->matchday}}][{{$match->awayTeamId}}][]" value="{{$guess->FTawayTeam}}">
                                        @endforeach
                                    @else
                                            <input type="text" name="FThomeTeam[{{$match->id}}][{{$match->matchday}}][{{$match->homeTeamId}}][]"> : 
                                            <input type="text" name="FTawayTeam[{{$match->id}}][{{$match->matchday}}][{{$match->awayTeamId}}][]">
                                    @endif
                                @endif
                            </span>
                        </td>
                        <td class="match__teamname">{{$match->awayTeamName}}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center m-3">
                <button type="submit" class="button white">Сделать прогноз</button>
            </div>
        </form>
        <div class="title-default">
            <h2>Таблица игроков</h2>	
        </div>
        <table class="table-default">
            <tr class="t-header">
                <td>Пользователь</td>
                    @foreach ($schedules as $match)
                        <td class="p-0">
                            <ul>
                                <li>{{$match->homeTeamName}}</li>
                                <li>{{$match->awayTeamName}}</li>
                                <li>{{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}}</li>
                            </ul> 
                        </td>
                    @endforeach
                <td>Всего</td>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    @foreach ($user->guess->where('matchday', $matchday) as $item)
                        <td class="text-center">
                            <li>{{$item->FThomeTeam}} : {{$item->FTawayTeam}}</li>
                            <li>{{$item->points}}</li>
                        </td>
                    @endforeach
                </tr>	
            @endforeach																		
        </table> <!-- Table Scores -->
    </div>
@endsection