

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
    </head>
    <body class="h-full">
        <div class="min-h-screen w-full bg-blue-100 relative overflow-hidden flex flex-col justify-center items-center">
            <!-- Bubble -->
            <div class="absolute -left-20 -top-20 w-72 h-72 bg-blue-200 rounded-full opacity-60"></div>
            <div class="absolute right-10 -top-10 w-40 h-40 bg-blue-200 rounded-full opacity-50"></div>
            <div class="absolute -right-24 bottom-10 w-64 h-64 bg-blue-200 rounded-full opacity-40"></div>

            <!-- Slot untuk form -->
            {{ $slot }}
        </div>
    </body>
</html>
