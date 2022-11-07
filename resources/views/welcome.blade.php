<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-gray-100 py-4" id="app">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <main-interface></main-interface>
            </div>
           
        </div>
    </body>
    @vite('resources/js/app.js')
</html>
