@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        
        <button type="submit" class="btn">Register</button>
        
        <div class="text-center">
            <p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>
        </div>
    </form>
@endsection
