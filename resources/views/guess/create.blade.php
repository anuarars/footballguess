@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>{{$schedules->currentPage()}}</h1>
            <div class="col-md-12">
                @foreach ($schedules as $schedule)
                    <li>{{$schedule->homeTeamName}}-- {{$schedule->awayTeamName}}</li>
                @endforeach
            </div>
            <div class="col-md-12">{{$schedules->links()}}</div>
        </div>
    </div>
@endsection