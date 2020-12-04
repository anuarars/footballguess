@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($teams as $team)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-center font-weight-bold">{{$team->name}}</h6>
                        </div>
                        <div class="card-body">
                            <img src="{{$team->crestUrl}}" alt="{{$team->shortName}}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .card-body img{
        width: 100%;
        height: 200px;
    }
</style>