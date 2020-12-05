@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title-default">
            <h2>Таблица игроков</h2>	
        </div>
        <table class="table-default">
            <tr class="t-header">
                <td>Пользователь</td>
                @for ($i = 1; $i <= 39; $i++)
                    <td>{{$i}}</td>
                @endfor
            </tr>
            @foreach ($users as $user)
                <tr>

                </tr>
            @endforeach																				
        </table> <!-- Table Scores -->
    </div>  
@endsection