<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Brewstock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
        }

        .login-form-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-pattern-section {
            flex: 1;
            background-image: url('{{ asset('assets/loginimage.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: none;
        }

        @media (min-width: 768px) {
            .login-pattern-section {
                display: block;
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 50px;
        }

        .logo-image {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        .logo h1 {
            color: #5a7248;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-size: 13px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            background-color: #f8f8f8;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8b9d6f;
            box-shadow: 0 0 0 3px rgba(139, 157, 111, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 14px 15px;
            background-color: #5a7248;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .login-btn:hover {
            background-color: #4a5d3a;
        }

        .login-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .remember-me label {
            margin-bottom: 0;
            cursor: pointer;
            font-size: 13px;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 15px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .loading.show {
            display: flex;
        }

        .spinner-container {
            position: relative;
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
        }

        .spinner {
            border: 4px solid rgba(107, 134, 89, 0.2);
            border-radius: 50%;
            border-top: 4px solid #5a7248;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            position: absolute;
        }

        .spinner-inner {
            border: 4px solid rgba(107, 134, 89, 0.3);
            border-radius: 50%;
            border-top: 4px solid #7a8f68;
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite reverse;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 14px;
            color: #5a7248;
            font-weight: 500;
        }

        .loading-user {
            font-size: 16px;
            color: #4a5d3a;
            font-weight: 700;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form-section">
            <div class="logo">
                <img src="{{ url('/logo.png') }}" alt="brewstock" class="logo-image">
                <p style="color: #666; font-size: 16px; margin-top: -10px;">Admin Portal</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error</strong> Las credenciales no son correctas.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email">Usuario</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                        placeholder="Ingresa tu correo" autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required 
                        placeholder="Ingresa tu contraseña">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <label for="remember">Recuérdame</label>
                </div>

                <button type="submit" class="login-btn" id="submitBtn">Iniciar Sesión</button>
                <div class="loading" id="loadingScreen">
                    <div class="spinner-container">
                        <div class="spinner"></div>
                        <div class="spinner-inner"></div>
                    </div>
                    <div class="loading-text">Iniciando Sesión</div>
                    <div class="loading-user" id="loadingUserName">ADMIN</div>
                </div>
            </form>
        </div>

        <div class="login-pattern-section"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = document.getElementById('email');
            const userName = emailInput.value.split('@')[0] || 'ADMIN';
            document.getElementById('loadingUserName').textContent = userName.toUpperCase();
            
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('loadingScreen').classList.add('show');
            
            setTimeout(() => {
                this.submit();
            }, 1500);
        });
    </script>
</body>
</html>
