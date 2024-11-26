<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Z3ltfGVufDB8fDB8fHww') no-repeat left center / cover;
            position: relative;
            overflow: hidden;
        }

        /* Overlay con viñeta */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            box-shadow: inset 0 0 200px rgba(0, 0, 0, 0.9);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            max-width: 600px;
        }

        .content .error-code {
            font-size: 8rem;
            font-weight: 900;
            margin: 0;
            line-height: 1;
            color: white;
            text-shadow: 0px 4px 8px rgba(0, 0, 0, 0.8);
        }

        .content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 1rem;
        }

        .content p {
            font-size: 1.2rem;
            margin: 1rem 0;
        }

        .button {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #e3352f51;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #cc1f1a;
        }
    </style>
</head>
<body>
    <div class="content">
        <p class="error-code">404</p>
        <h1>Ooops... Página no encontrada</h1>
        <p>Verifica la URL a la que accediste o intenta ingresar a otra página.</p>
        <a href="javascript:history.back()" class="button">Regresar</a>
    </div>
</body>
</html>
