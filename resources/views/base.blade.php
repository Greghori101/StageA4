<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" locale="{{ session('applocale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
</head>

<body class="bg-gray-100 text-gray-900 font-figtree">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        @include('nav/navbar')

        <!-- Main Content -->
        <main class="flex-1 container mx-auto p-4">
            @yield('content')
        </main>

        <!-- Sticky Bottom Navbar -->
        @include('nav/navbar-bottom')
    </div>

    <!-- Scripts -->
    @include('script')

</body>
</html>
