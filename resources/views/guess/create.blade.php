@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Тотализатор</h2>	
        </div>
        <form action="{{route('guess.store', $matchday)}}" method="POST">
            @csrf
            <table class="table-default" id="guess">
                <tr class="t-header">
                    <td colspan="5" class="score-date text-center">Тур {{$matchday}}</td>
                </tr>
                @foreach ($schedules as $match)
                    <tr class="match">
                        <td class="match__hometeam text-center">{{$match->homeTeamName}}</td>
                        <td class="match__score text-center">
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
                                        <input type="text" name="FThomeTeam[{{$match->id}}][{{$match->matchday}}][{{$match->homeTeamId}}][]" value="{{$guess->FThomeTeam}}"> <span class="delimiter">:</span> 
                                        <input type="text" name="FTawayTeam[{{$match->id}}][{{$match->matchday}}][{{$match->awayTeamId}}][]" value="{{$guess->FTawayTeam}}">
                                    @endforeach
                                @else
                                        <input type="text" name="FThomeTeam[{{$match->id}}][{{$match->matchday}}][{{$match->homeTeamId}}][]"> <span class="delimiter">:</span>
                                        <input type="text" name="FTawayTeam[{{$match->id}}][{{$match->matchday}}][{{$match->awayTeamId}}][]">
                                @endif
                            @endif
                        </td>
                        <td class="match__awayteam text-center">{{$match->awayTeamName}}</td>
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
                                        {{\Carbon\Carbon::parse($match->utcDate)->format('d.m H:i')}}
                                    </span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center m-3">
                <button type="submit" class="button white">
                    @if (count(Auth::user()->guess->where('schedule_id', $match->id))>0)
                        Обновить прогноз
                    @else
                        Сделать прогноз
                    @endif
                </button>
            </div>
        </form>
        <div class="title-default">
            <h2>Таблица игроков</h2>	
        </div>
        <table class="table-default" id="points">
            <tr class="t-header">
                <td>Пользователь</td>
                <td class="match_dropdown">
                    <select id="select-match">
                        @foreach ($schedules as $match)
                            <option value="">
                                {{$match->homeTeamName}} - {{$match->awayTeamName}}
                            </option>
                        @endforeach
                    </select>
                </td>
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
                <tr id="{{$user->id}}">
                    <td>{{$user->name}}</td>
                    <td class="match_dropdown_result">
                        <li>1</li>
                        <li>2</li>
                    </td>
                    @foreach ($user->guess->where('matchday', $matchday) as $guess)
                        <td class="text-center">
                            {{-- @if (Auth::id()==$user->id) --}}
                                <li>{{$guess->FThomeTeam}} : {{$guess->FTawayTeam}}</li>
                                <li class="point">{{$guess->points ?? '0'}}</li>
                            {{-- @elseif (now() > $guess->utcDate)
                                <li>{{$guess->FThomeTeam}} : {{$guess->FTawayTeam}}</li>
                                <li class="point">{{$guess->points ?? '0'}}</li>
                            @else
                                <li> : </li>
                                <li> - </li>
                            @endif --}}
                        </td>
                    @endforeach
                    
                    <td>{{$user->guess->where('matchday', $matchday)->sum('points')}}</td>
                </tr>	
            @endforeach																		
        </table> <!-- Table Scores -->
    </div>
@endsection