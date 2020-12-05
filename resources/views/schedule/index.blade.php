@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Расписание</h2>	
        </div>
        <table class="table-default">
            @foreach ($schedules as $day => $schedule)
            <tr class="t-header">
                <td colspan="5" class="score-date">{{$day}}</td>
            </tr>
                @foreach ($schedule as $match)
                    <tr>
                        <td>FT</td>
                    <td></td>
                        <td>{{$match->homeTeamName}}</td>
                        <td><span>{{$match->score->FThomeTeam}}-{{$match->score->FTawayTeam}}</span></td>
                        <td>{{$match->awayTeamName}}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
        <form action="{{route('schedule.index')}}" method="GET">
            <select name="year">
                <option value="2019">2018/2019</option>
                <option value="2020">2019/2020</option>
                <option value="2021">2020/2021</option>
            </select>
            <select name="month">
                @for ($i = 1; $i <=12; $i++)
                    <option value="{{date('m', mktime(0, 0, 0, $i, 1))}}"
                        @if (date('m', mktime(0, 0, 0, $i, 1)) == old('month'))
                            selected="selected"
                        @endif
                    >{{date('F', mktime(0, 0, 0, $i, 1))}}</option>
                @endfor
            </select>
            <button type="submit">ok</button>
        </form>
    </div>
@endsection