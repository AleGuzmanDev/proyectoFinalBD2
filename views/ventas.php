<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Enterprise - Ventas</title>
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
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo {
            width: 80px;
            margin-right: 15px;
        }

        .title {
            font-size: 24px;
            color: #333;
        }

        .select-container {
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat;
            background-position: right 10px center;
            background-color: white;
        }

        .button {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(182, 198, 238);
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: rgb(162, 178, 218);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Ventas</h1>
        </div>

        <!-- <div class="select-container">
            <select>
                <option value="">Domingo, 31 de octubre</option> -->
                <!-- Más opciones aquí -->
            <!-- </select>

            <select>
                <option value="">2024</option> -->
                <!-- Más opciones aquí -->
            <!-- </select>
        </div> -->

        <button class="button"> <a href="reporte_general.php">Reporte general</a></button>
        <button class="button"> <a href="reporte_vendedor.php">Reporte por vendedor</a></button>
        <!-- <button class="button">Comisiones</button> -->
    </div>
</body>
</html>