<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Dashboard - FreshCart</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-white">
        <div class="flex">
            <!-- Sidebar -->
            @auth('admin')
                <x-admin.navbar/>
            @endauth

            <!-- Main Content -->
            <main class="flex-1 min-h-screen bg-gray-50 p-8 @auth('admin') ml-70 @endauth">
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack('scripts')
    </body>
</html>