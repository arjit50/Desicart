<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Heading -->
        <div>
            <h1 class="text-4xl font-serif font-black text-slate-900 leading-tight">
                Welcome<br>back!
            </h1>
        </div>

        <!-- Hidden Remember Me -->
        <input type="hidden" name="remember" value="1">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-500 mb-1.5">{{ __('Email') }}</label>
            <input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-500 mb-1.5">{{ __('Password') }}</label>
            <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
            
            <div class="flex justify-end mt-2">
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <button type="submit" class="auth-btn-black">
                {{ __('Login') }}
            </button>
        </div>

        <!-- Separator -->
        <div class="relative flex items-center justify-center py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-100"></div>
            </div>
            <span class="relative bg-white px-4 text-xs font-semibold text-slate-400">or</span>
        </div>

        <!-- Social Buttons -->
        <div class="grid grid-cols-2 gap-4">
            <a href="#" class="social-btn">
                <svg class="h-5 w-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                </svg>
                Facebook
            </a>
            <a href="#" class="social-btn">
                <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.48c0,-0.61 -0.06,-1.2 -0.16,-1.72z" fill="#4285F4" />
                    <path d="M12,20.72c2.63,0 4.84,-0.87 6.45,-2.37l-3.3,-2.58c-0.91,0.61 -2.08,0.98 -3.15,0.98c-2.42,0 -4.47,-1.64 -5.2,-3.84H3.37v2.66c1.62,3.22 4.96,5.15 8.63,5.15z" fill="#34A853" />
                    <path d="M6.8,12.91c-0.18,-0.55 -0.29,-1.13 -0.29,-1.73s0.11,-1.18 0.29,-1.73V6.79H3.37c-0.62,1.24 -0.97,2.64 -0.97,4.12s0.35,2.88 0.97,4.12L6.8,12.91z" fill="#FBBC05" />
                    <path d="M12,5.28c1.43,0 2.72,0.49 3.73,1.45l2.8,-2.8C16.83,2.3 14.62,1.4 12,1.4C8.33,1.4 4.99,3.33 3.37,6.55L6.8,9.21c0.73,-2.2 2.78,-3.93 5.2,-3.93z" fill="#EA4335" />
                </svg>
                Google
            </a>
        </div>

        <!-- Switch Link -->
        <div class="pt-6 text-center">
            <span class="block text-xs font-semibold text-slate-400 mb-3">Don't have an account?</span>
            <a href="{{ route('register') }}" class="auth-btn-secondary">
                Create account
            </a>
        </div>
    </form>
</x-guest-layout>
