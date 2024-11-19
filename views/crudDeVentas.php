<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            margin-right: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-style: italic;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .buttons-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #b8c7e7;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #9ab0db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .generate-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="/api/placeholder/120/50" alt="MM Enterprise" class="logo">
        </div>
        
        <h1>Ventas</h1>
        
        <div class="input-group">
            <label>Producto</label>
            <input type="text" placeholder="Ingrese el producto">
        </div>
        
        <div class="input-group">
            <label>Cantidad</label>
            <input type="number" placeholder="Ingrese la cantidad">
        </div>
        
        <div class="buttons-group">
            <button class="btn">Agregar</button>
            <button class="btn">Actualizar</button>
            <button class="btn">Eliminar</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Valor unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>producto1</td>
                    <td>2</td>
                    <td>25000</td>
                    <td>50000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong>50000</strong></td>
                </tr>
            </tfoot>
        </table>
        
        <button class="btn generate-btn">Generar venta</button>
    </div>
</body>
</html>