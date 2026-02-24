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
            background: linear-gradient(135deg, #8b9d6f 0%, #a8b88f 100%);
            position: relative;
            overflow: hidden;
            display: none;
        }

        .login-pattern-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 35px,
                rgba(255, 255, 255, 0.1) 35px,
                rgba(255, 255, 255, 0.1) 70px
            );
            animation: slidePattern 20s linear infinite;
        }

        @keyframes slidePattern {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(70px, 70px);
            }
        }

        @media (min-width: 768px) {
            .login-pattern-section {
                display: block;
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-image {
            max-width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .logo h1 {
            color: #5a5a5a;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .logo p {
            color: #999;
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
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8b9d6f;
            box-shadow: 0 0 0 3px rgba(139, 157, 111, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 12px 15px;
            background-color: #6b8659;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #5a7248;
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
        }

        .spinner {
            border: 3px solid rgba(107, 134, 89, 0.1);
            border-radius: 50%;
            border-top: 3px solid #6b8659;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .form-group.loading .login-btn {
            display: none;
        }

        .form-group.loading .loading {
            display: block;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form-section">
            <div class="logo">
                <img src="{{ url('/logo.png') }}" alt="brewstock" class="logo-image">
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
                <div class="loading">
                    <div class="spinner"></div>
                    <p style="font-size: 12px; margin-top: 10px; color: #666;">Iniciando Sesión ADMIN</p>
                </div>
            </form>
        </div>

        <div class="login-pattern-section"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const formGroup = document.querySelector('.form-group:last-of-type');
            formGroup.classList.add('loading');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>
