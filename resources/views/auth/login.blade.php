@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    
    @if (session('success'))
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #155724;">
            {{ session('success') }}
        </div>
    @endif
    
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
            <p style="margin-bottom: 15px;">Belum punya akun? <a href="{{ url('/register') }}" style="color: #667eea; font-weight: 600;">Daftar sebagai Penjual</a></p>
            <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                <a href="{{ url('/products') }}" style="color: #95a5a6; text-decoration: none; display: inline-flex; align-items: center; transition: color 0.3s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="margin-right: 5px;">
                        <path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </p>
        </div>
    </form>
    
    <style>
        .text-center a:hover {
            color: #667eea !important;
        }
    </style>
@endsection
