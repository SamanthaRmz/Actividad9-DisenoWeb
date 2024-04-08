<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrarse</h1>
        <form id="register-form" method="POST" action="{{ route('register') }}">
            @csrf
            <input id="name" type="text" name="name" placeholder="Nombre" required autocomplete="name" autofocus>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <input id="email" type="email" name="email" placeholder="Correo Electrónico" required autocomplete="email">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <input id="password" type="password" name="password" placeholder="Contraseña" required autocomplete="new-password">
            <span id="password-error" class="error-message" style="display: none;"></span> <!-- Espacio para el mensaje de error -->
            <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required autocomplete="new-password">
            <input type="submit" value="Registrarse">
        </form>
        <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var passwordConfirm = document.getElementById('password-confirm').value;

            if (password.length < 8) {
                document.getElementById('password-error').textContent = 'La contraseña debe tener al menos 8 caracteres.';
                document.getElementById('password-error').style.display = 'block';
                event.preventDefault(); // Evita que se envíe el formulario
            } else if (password !== passwordConfirm) {
                document.getElementById('password-error').textContent = 'Las contraseñas no coinciden.';
                document.getElementById('password-error').style.display = 'block';
                event.preventDefault(); // Evita que se envíe el formulario
            }
        });
    </script>
</body>
</html>
