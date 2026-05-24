<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DesiCart') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

        <style>
            /* Lock the page — no full-page scroll ever */
            html, body {
                height: 100% !important;
                overflow: hidden !important;
            }

            /* Thin, elegant scrollbar on the form panel only */
            .form-scroll-panel::-webkit-scrollbar {
                width: 4px;
            }
            .form-scroll-panel::-webkit-scrollbar-track {
                background: transparent;
            }
            .form-scroll-panel::-webkit-scrollbar-thumb {
                background: #e2e8f0;
                border-radius: 9999px;
            }
            .form-scroll-panel::-webkit-scrollbar-thumb:hover {
                background: #cbd5e1;
            }
            /* Firefox */
            .form-scroll-panel {
                scrollbar-width: thin;
                scrollbar-color: #e2e8f0 transparent;
            }

            /* Custom CSS Overrides for Auth Split Screen */
            input.auth-input {
                background-color: #ffffff !important;
                border: 1px solid #e2e8f0 !important; /* light gray border */
                color: #0f172a !important;
                border-radius: 6px !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                line-height: 1.25rem !important;
                transition: all 0.2s ease-in-out !important;
                box-shadow: none !important;
                width: 100% !important;
            }
            input.auth-input:focus {
                border-color: #0f172a !important;
                outline: none !important;
                box-shadow: 0 0 0 1px #0f172a !important;
            }
            button.auth-btn-black, button[type="submit"].auth-btn-black {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                background-color: #111111 !important;
                color: #ffffff !important;
                border-radius: 6px !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                font-weight: 600 !important;
                transition: background-color 0.2s ease-in-out !important;
                border: none !important;
                cursor: pointer !important;
            }
            button.auth-btn-black:hover, button[type="submit"].auth-btn-black:hover {
                background-color: #222222 !important;
            }
            .social-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 0.5rem !important;
                width: 100% !important;
                background-color: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                color: #1f2937 !important;
                border-radius: 6px !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                font-weight: 500 !important;
                transition: all 0.2s ease-in-out !important;
                text-decoration: none !important;
            }
            .social-btn:hover {
                background-color: #f8fafc !important;
                border-color: #cbd5e1 !important;
            }
            .auth-btn-secondary {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                background-color: #f1f5f9 !important; /* light slate */
                color: #0f172a !important;
                border-radius: 6px !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                font-weight: 600 !important;
                transition: all 0.2s ease-in-out !important;
                border: none !important;
                text-decoration: none !important;
            }
            .auth-btn-secondary:hover {
                background-color: #e2e8f0 !important;
            }
            .auth-link {
                font-size: 0.75rem !important;
                color: #475569 !important;
                text-decoration: underline !important;
                transition: color 0.2s ease-in-out !important;
            }
            .auth-link:hover {
                color: #0f172a !important;
            }
        </style>
    </head>
    <body class="font-sans text-slate-900 antialiased bg-white overflow-hidden">
        <div class="h-screen flex flex-row overflow-hidden">
            <!-- Left Side - Form Container (scrolls internally) -->
            <div class="w-full lg:w-[45%] h-full flex flex-col bg-white overflow-y-auto form-scroll-panel">
                <div class="flex-1 flex flex-col justify-center px-8 py-10 sm:px-16 lg:px-20 xl:px-24">
                    <div class="mx-auto w-full max-w-md">
                        <!-- Site Logo -->
                        <div class="mb-10">
                            <a href="/">
                                <img src="{{ asset('images/desicart_logo.png') }}" alt="{{ config('app.name', 'DesiCart') }}" class="h-10 w-auto object-contain">
                            </a>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Right Side - Grocery Image Banner (fixed, no scroll) -->
            <div class="hidden lg:flex lg:w-[55%] h-full relative flex-shrink-0">
                <!-- Cover Image -->
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/grocery_auth_bg.png') }}');"></div>
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/40"></div>
                <!-- Text Content at the bottom -->
                <div class="absolute bottom-16 left-16 right-16 z-10">
                    <h2 class="text-5xl font-black font-serif leading-tight text-white drop-shadow-lg">
                        Fresh groceries<br>delivered to your door
                    </h2>
                    <p class="mt-4 text-base text-white/80 font-medium drop-shadow">Quality produce &amp; essentials, every day.</p>
                </div>
            </div>
        </div>
    </body>
</html>
