@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="checkbox-group">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin-bottom: 0;">Remember Me</label>
        </div>
        
        <button type="submit" class="btn">Login</button>
        
        <div class="text-center">
            <p>Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a></p>
        </div>
    </form>
@endsection
