<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nestica</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FDFBF0;
            color: #4A3B32;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .top-bar {
            background-color: #7E991E;
            color: #FBFDF0;
            text-align: center;
            padding: 5px;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .header-main {
            background-color: #FDFBF0;
            padding: 20px 50px;
            margin-top: 28px;
        }

        .logo {
            font-size: 36px;
            font-weight: 800;
            color: #4A3B32;
        }

        .banner {
            background-color: #A5A58D;
            background-image: url("{{ asset('images/banner.PNG') }}");
            background-size: cover;
            background-position: center;
            height: 150px;
            display: flex;
            align-items: center;
            padding-left: 90px;
            padding-top: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .banner h1 {
            font-size: 36px;
            font-weight: 700;
            color: #e3e3e3ff;
            position: relative;
            z-index: 1;
            text-shadow: 
                -1px -1px 0 #493A2E,
                1px -1px 0 #493A2E,
                -1px 1px 0 #493A2E,
                1px 1px 0 #493A2E,
                2px 2px 4px rgba(0,0,0,0.7);
        }

        /* 🔥 BACK BUTTON (LEFT) */
        .back-container {
            width: 100%;
            text-align: left;
            margin: 20px 0 10px 0;
            padding-left: 50px;
        }

        .back-btn {
            display: inline-block;
            padding: 0;
            background: transparent;
            color: #483A2E;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        /* Content Styles */
        .container {
            max-width: 1200px;
            margin: 20px auto 60px auto;
            padding: 0 50px;
            display: flex;
            gap: 100px;
            flex: 1;
        }

        .login-section {
            flex: 1;
        }

        .register-section {
            flex: 1;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        p.subtitle {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #4A3B32;
            background-color: #FDFBF0;
            border-radius: 0;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #2c241f;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4A3B32;
            color: #FDFBF0;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn:hover {
            background-color: #3a2e27;
        }

        /* Footer */
        footer {
            background-color: #4A3B32;
            color: #FDFBF0;
            padding: 40px 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: auto;
        }

        .footer-left h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-left p {
            font-size: 14px;
            line-height: 1.5;
        }

        .footer-right {
            text-align: right;
            font-size: 14px;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        BRINGS WARMTH AND CHARACTER INTO EVERY CORNER OF YOUR HOME
    </div>

    <div class="header-main">
        <div class="logo">Nestica</div>
    </div>

    <div class="banner">
        <h1>Login</h1>
    </div>

    <!-- 🔥 BACK BUTTON (LEFT) -->
    <div class="back-container">
        <a href="{{ url('/') }}" class="back-btn">← Back</a>
    </div>

    <div class="container">
        <!-- Left Column: Login -->
        <div class="login-section">
            <h2>Existing User</h2>
            <p class="subtitle">Please enter your email and password below</p>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <!-- Right Column: Register -->
        <div class="register-section">
            <h2>New User</h2>
            <p class="subtitle">Wanna sell something? Join us!</p>
            
            <a href="{{ url('/register') }}" class="btn">Register</a>
        </div>
    </div>

    <footer>
        <div class="footer-left">
            <h3>Nestica</h3>
            <p>(+62) 123 144 567<br>info@nestica.com</p>
        </div>
        <div class="footer-right">
            <p>&copy; 2025 Nestica<br>Made with love by kelompok 4</p>
        </div>
    </footer>

</body>
</html>