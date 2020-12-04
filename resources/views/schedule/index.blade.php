@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Table Style 01</h2>	
        </div>
        <table class="table-default">
            <tr class="t-header">
                <td colspan="5" class="score-date">Sat 5th Apr</td>
            </tr>

            @foreach ($schedules as $schedule)
                <tr>
                    <td>FT</td>
                    <td>{{$schedule->homeTeamName}}</td>
                    <td><span>{{$schedule->score->FThomeTeam}}-{{$schedule->score->FTawayTeam}}</span></td>
                    <td>{{$schedule->awayTeamName}}</td>
                    <td title="Online TV" title="Online TV"><a href="#"><i class="fa fa-desktop"></i></a></td>
                </tr>
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