<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema en Mantenimiento</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F3F4F6; /* bg-gray-100 */
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-xl mx-auto text-center p-8">
            <div class="mb-4">
                <i class="ph ph-warning text-6xl text-sigedra-warning"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Sistema no disponible</h1>
            <p class="text-lg text-gray-600">
                El sistema se encuentra temporalmente fuera de servicio por mantenimiento. Por favor, inténtelo de nuevo más tarde.
            </p>
            <p class="text-lg text-gray-600 mt-4">
                Disculpe las molestias.
            </p>
        </div>
    </div>
</body>
</html>
