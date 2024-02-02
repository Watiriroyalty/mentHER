<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'mentHER') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files from Welcome Blade -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File from Welcome Blade -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

      <!-- Bootstrap JavaScript and Popper.js -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

     <!-- Include BotMan JavaScript -->
     <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@latest"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-light text-dark">
    <div class="min-h-screen">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        @if (auth()->check())
    @foreach(auth()->user()->unreadNotifications as $notification)
        <div>
            {{ $notification->data['message'] }}
            @if (isset($notification->data['link']))
                <a href="{{ $notification->data['link'] }}">View</a>
            @endif
        </div>
    @endforeach
@endif

        <!-- Page Content -->
        <main class="container mx-auto p-4">
            {{ $slot }}
        </main>
    </div>
</body>
</html>

<div id="botmanWidget"></div>


<!-- Initialize BotMan -->
<script>
    var botmanWidget = {
        aboutText: 'Need Help?',
        introMessage: "Hi! I'm your virtual assistant.",
        mainColor: '#456990',
        bubbleBackground: '#456990',
        bubbleAvatarUrl: '/img/blackpanther.jpg', 
    };
</script>
