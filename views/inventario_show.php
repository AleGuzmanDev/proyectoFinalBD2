<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Enterprise - Gestión de inventario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: rgb(182, 198, 238);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 80px;
            margin-right: 15px;
        }

        .title {
            font-size: 24px;
            color: #333;
            text-align: center;
            width: 100%;
        }

        .gears-bg {
            position: absolute;
            width: 100%;
            height: 200px;
            bottom: 0;
            left: 0;
            opacity: 0.1;
            z-index: 1;
        }

        .button-container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 300px;
            margin: 0 auto;
        }

        .button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            background-color: rgb(182, 198, 238);
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }

        .button:hover {
            background-color: rgb(162, 178, 218);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="MM Enterprise" class="logo">
        </div>

        <h1 class="title">Gestión de inventario</h1>

        <!-- SVG para los engranajes de fondo -->
        <svg class="gears-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,25 L54,25 L55,28 L56,25 L60,25 L58,30 L62,32 L59,35 L62,38 L58,40 L60,45 L56,45 L55,42 L54,45 L50,45 L52,40 L48,38 L51,35 L48,32 L52,30 Z" fill="#333">
                <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="0 55 35"
                    to="360 55 35"
                    dur="10s"
                    repeatCount="indefinite"/>
            </path>
            <path d="M30,45 L34,45 L35,48 L36,45 L40,45 L38,50 L42,52 L39,55 L42,58 L38,60 L40,65 L36,65 L35,62 L34,65 L30,65 L32,60 L28,58 L31,55 L28,52 L32,50 Z" fill="#333">
                <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="360 35 55"
                    to="0 35 55"
                    dur="10s"
                    repeatCount="indefinite"/>
            </path>
        </svg>

        <div class="button-container">
            <button class="button"><a href="inventario_show.php">Ver inventario</a></button>
            <button class="button">Actualizar inventario</button>
        </div>
    </div>
</body>
</html>