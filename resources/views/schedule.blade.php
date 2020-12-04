@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                {{-- {{$matches}} --}}
                @foreach ($matches as $match)
                    {{$match->id}}
                @endforeach
            </div>
        </div>
    </div>
@endsection