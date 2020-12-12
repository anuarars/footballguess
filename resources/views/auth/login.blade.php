@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="form">
            <div class="title-default">
                <h2>Войти</h2>	
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
    
                <div class="form-input flex-column">
                    <input id="email" type="email" placeholder="Email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="form-alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-input flex-column">
                    <input id="password" type="password" placeholder="Пароль" class="@error('password') is-invalid @enderror" name="password" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('password')
                        <div class="form-alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-input">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="checkbox">
                    <label for="remember">
                        Запомнить меня
                    </label>
                </div>
                <div class="form-input">
                    <button type="submit" class="button white">Войти</button>
                    @if (Route::has('password.request'))
                        <a class="btn" href="{{ route('password.request') }}">
                            Забыли пароль?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
