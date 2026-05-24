<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DesiCart') }} - Smart Grocery Deals &amp; Inventory</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

        <style>
            #ls-overlay {
                position: fixed;
                inset: 0;
                z-index: 99999;
                background: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: opacity 0.5s ease;
            }
            #ls-canvas {
                position: absolute;
                inset: 0;
                display: block;
            }
            #ls-tagline {
                position: absolute;
                bottom: 22%;
                left: 0; right: 0;
                text-align: center;
                color: rgba(15,23,42,0);
                font-family: 'Outfit', sans-serif;
                font-size: clamp(11px, 1.3vw, 17px);
                letter-spacing: 0.4em;
                text-transform: uppercase;
                font-weight: 600;
                transition: color 0.6s ease;
                pointer-events: none;
            }
            /* Countdown timer ring */
            #ls-timer {
                position: absolute;
                bottom: 1.8rem;
                right: 2rem;
                width: 48px;
                height: 48px;
                cursor: pointer;
                z-index: 10;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #ls-timer svg {
                position: absolute;
                inset: 0;
                transform: rotate(-90deg);
            }
            #ls-timer-circle {
                fill: none;
                stroke: rgba(15,23,42,0.12);
                stroke-width: 2.5;
            }
            #ls-timer-progress {
                fill: none;
                stroke: rgba(27,127,77,0.75);
                stroke-width: 2.5;
                stroke-linecap: round;
                stroke-dasharray: 132;
                stroke-dashoffset: 0;
                transition: stroke-dashoffset 1s linear;
            }
            #ls-timer-num {
                position: relative;
                font-family: 'Outfit', sans-serif;
                font-size: 17px;
                font-weight: 700;
                color: rgba(15,23,42,0.55);
                line-height: 1;
                transition: color 0.3s;
                z-index: 1;
            }
            #ls-timer:hover #ls-timer-num { color: rgba(15,23,42,0.85); }
            #ls-timer:hover #ls-timer-progress { stroke: rgba(27,127,77,1); }
        </style>
    </head>
    <body class="bg-white text-slate-900 min-h-screen flex flex-col font-sans antialiased">

        {{-- =============================================
             BRAND SIGNATURE LOADING SCREEN (Curtain Split)
             Fires once per browser session via sessionStorage
        ============================================== --}}
        <div id="ls-curtain-left" class="fixed top-0 left-0 w-1/2 h-full bg-[#0a271d] z-[99999] transition-transform duration-700 ease-in-out origin-left"></div>
        <div id="ls-curtain-right" class="fixed top-0 right-0 w-1/2 h-full bg-[#0a271d] z-[99999] transition-transform duration-700 ease-in-out origin-right"></div>
        
        <div id="ls-content" class="fixed inset-0 z-[100000] flex flex-col items-center justify-center pointer-events-none transition-opacity duration-500">
            <svg width="400" height="120" viewBox="0 0 400 120" class="drop-shadow-2xl">
                <style>
                    .draw-desi {
                        fill: transparent;
                        stroke: rgba(255, 255, 255, 0.9);
                        stroke-width: 1.5px;
                        stroke-dasharray: 400;
                        stroke-dashoffset: 400;
                        animation: drawLine 1.5s ease-in-out forwards, fillDesi 0.5s 1.5s forwards;
                    }
                    .draw-cart {
                        fill: transparent;
                        stroke: rgba(255, 255, 255, 0.9);
                        stroke-width: 1.5px;
                        stroke-dasharray: 400;
                        stroke-dashoffset: 400;
                        animation: drawLine 1.5s ease-in-out forwards, fillCart 0.5s 1.5s forwards;
                    }
                    @keyframes drawLine {
                        to { stroke-dashoffset: 0; }
                    }
                    @keyframes fillDesi {
                        to { fill: #ffffff; stroke: transparent; }
                    }
                    @keyframes fillCart {
                        to { fill: #f97316; stroke: transparent; }
                    }
                </style>
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="'Outfit', sans-serif" font-weight="800" font-size="56" letter-spacing="1">
                    <tspan class="draw-desi">Desi</tspan><tspan class="draw-cart">Cart</tspan>
                </text>
            </svg>
            <div id="ls-subtext" class="mt-4 text-white/0 font-semibold tracking-[0.35em] uppercase text-xs transition-colors duration-700">
                Premium Groceries
            </div>
        </div>

        <script>
        (function () {
            var isHomePage = window.location.pathname === '/' || window.location.pathname === '';
            var animationShown = sessionStorage.getItem('brandAnimationShown');
            var shouldShowAnimation = isHomePage || !animationShown;

            var leftCurtain = document.getElementById('ls-curtain-left');
            var rightCurtain = document.getElementById('ls-curtain-right');
            var content = document.getElementById('ls-content');
            var subtext = document.getElementById('ls-subtext');

            if (!shouldShowAnimation) {
                if(leftCurtain) leftCurtain.style.display = 'none';
                if(rightCurtain) rightCurtain.style.display = 'none';
                if(content) content.style.display = 'none';
                return;
            }

            // Timeline:
            // 0s: SVG draws outline (CSS animation starts automatically)
            // 1.5s: SVG fills color (CSS animation starts)
            
            // Fade in subtext exactly as the logo fills with color
            setTimeout(function() {
                if(subtext) {
                    subtext.classList.remove('text-white/0');
                    subtext.classList.add('text-white/90');
                }
            }, 1500);

            // 2.8s: Fade out the logo and subtext
            setTimeout(function() {
                if(content) content.style.opacity = '0';
            }, 2800);

            // 3.1s: Split the curtains!
            setTimeout(function() {
                if(leftCurtain) leftCurtain.classList.add('scale-x-0');
                if(rightCurtain) rightCurtain.classList.add('scale-x-0');
            }, 3100);

            // 4.0s: Remove elements from DOM completely
            setTimeout(function() {
                if(leftCurtain) leftCurtain.style.display = 'none';
                if(rightCurtain) rightCurtain.style.display = 'none';
                if(content) content.style.display = 'none';
                sessionStorage.setItem('brandAnimationShown', 'true');
            }, 4000);

        })();
        </script>
        {{-- END LOADING SCREEN --}}

        <!-- Premium Navbar Header -->
        <header class="sticky top-0 z-50 w-full">
            <x-nav-bar :categories="isset($categories) ? $categories : \App\Models\Category::all()" />
        </header>

        <!-- Messages / Alerts -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-grow py-8">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Premium Footer -->
        <x-footer />

    </body>
</html>
