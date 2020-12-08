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
                    <tr>
                        <td>FT</td>
                    <td></td>
                        <td>{{$match->homeTeamName}}</td>
                        <td>
                            <span>
                                @if ($match->status == "FINISHED")
                                    {{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}}
                                @elseif ($match->status == "IN_PLAY")
                                {{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}} <span>live</span>
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
                        <td>{{$match->awayTeamName}}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                <button type="submit" class="button white">Сделать прогноз</button>
            </div>
        </form>
        <div class="title-default">
            <h2>Таблица игроков</h2>	
        </div>
        <table class="table-default">
            <tr class="t-header">
                <td rowspan="3">Пользователь</td>
                    @foreach ($schedules as $match)
                        <td>{{$match->homeTeamName}}</td>
                    @endforeach
            </tr>
            <tr>
                @foreach ($schedules as $match)
                <td>{{$match->awayTeamName}}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($schedules as $match)
                <td>{{$match->score->FThomeTeam}} : {{$match->score->FTawayTeam}}</td>
                @endforeach
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    @foreach ($user->guess->where('matchday', 11) as $item)
                        <td>{{$item->FThomeTeam}} : {{$item->FTawayTeam}}({{$item->points}})</td>
                    @endforeach
                </tr>	
            @endforeach																		
        </table> <!-- Table Scores -->
    </div>
@endsection