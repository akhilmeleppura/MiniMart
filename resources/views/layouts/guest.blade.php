<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MiniMart') }} — Sign In</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/minimart-icon.svg') }}">
        <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
          :root {
            --mm-primary: #2563EB;
            --mm-primary-dark: #1D4ED8;
            --mm-accent: #14B8A6;
            --mm-bg-dark: #0F172A;
            --mm-surface: #FFFFFF;
            --mm-text: #0F172A;
            --mm-text-muted: #64748B;
            --mm-border: #E2E8F0;
          }

          body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
          }

          @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
          }
          @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(10px) rotate(-2deg); }
          }
          @keyframes pulseGlow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
          }
          @keyframes fadeInSlide {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
          }

          .animate-float-1 { animation: floatSlow 7s ease-in-out infinite; }
          .animate-float-2 { animation: floatReverse 9s ease-in-out infinite; }
          .animate-pulse-glow { animation: pulseGlow 6s ease-in-out infinite; }
          .animate-fade-in { animation: fadeInSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

          @media (prefers-reduced-motion: reduce) {
            .animate-float-1, .animate-float-2, .animate-pulse-glow, .animate-fade-in {
              animation: none !important;
            }
          }
        </style>
    </head>
    <body class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-blue-600 selection:text-white">
        {{ $slot }}
    </body>
</html>
