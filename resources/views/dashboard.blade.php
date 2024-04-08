<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            position: relative; 
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
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to your Dashboard, {{ Auth::check() ? Auth::user()->name : 'Guest' }}!</h1> 
        <p>Haz ingresado sesión correctamente.</p>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-button">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
