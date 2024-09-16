<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="icon" type="image/x-icon" href="data:image/png;base64,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">
        

        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <body class="font-sans antialiased">
        @yield('content')
        <!-- Includi la sezione script specifica per ogni vista -->
        @yield('scripts')
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <!--
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            -->
            
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <div class="bg-gray-100 dark:bg-gray-900" style="color: white; height:50px;">
            <div style="display: flex; justify-content:center; gap:5px">
                <div>
                    <a href="https://github.com/lucaDomo" target=”_blank”>Luca Dominici</a>
                </div>
                <div> | </div>
                <div>
                    <span>Icons by <a href="https://icons8.it" style="color:#7D3CED" target=”_blank”>icons8.</a></span>
                </div>
            </div>
        </div>
    </body>
</html>
