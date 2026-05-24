<x-guest-layout>
    <div class="min-h-screen flex overflow-hidden">
        <!-- Left Side - Forms (Scrollable) -->
        <div class="w-full lg:w-1/2 flex flex-col bg-white overflow-y-auto">
            <div class="flex-1 flex items-center justify-center p-4 lg:p-12">
                <div class="w-full max-w-md">
                <!-- Logo/Brand Section -->
                <div class="mb-12">
                    <h1 class="text-5xl font-black text-gray-900 mb-2">FreshiMart</h1>
                    <p class="text-gray-600 text-base">Quality grocery at your doorstep</p>
                </div>

                <!-- Tabs -->
                <div class="flex gap-1 mb-10 bg-gray-100 p-2 rounded-xl">
                    <button onclick="switchTab('login')" id="login-tab" 
                            class="flex-1 py-3 px-4 rounded-lg font-bold transition-all duration-300 bg-white text-gray-900 shadow-md">
                        Login
                    </button>
                    <button onclick="switchTab('register')" id="register-tab" 
                            class="flex-1 py-3 px-4 rounded-lg font-bold transition-all duration-300 text-gray-600 hover:text-gray-900">
                        Sign Up
                    </button>
                </div>

                <!-- LOGIN TAB -->
                <div id="login-content" class="tab-content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="Enter your email address">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-2">
                            <label for="password" class="block text-sm font-bold text-gray-800 mb-2">Password</label>
                            <input id="password" type="password" name="password" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="Enter your password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-right mb-6">
                                <a href="{{ route('password.request') }}" class="text-sm text-green-700 hover:text-green-800 font-semibold">
                                    Forgot password?
                                </a>
                            </div>
                        @endif

                        <!-- Remember Me -->
                        <div class="mb-8">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember" 
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-black hover:bg-gray-900 text-white font-bold py-3 rounded-lg transition duration-300 mb-6 text-lg">
                            Login
                        </button>

                        <!-- Divider -->
                        <div class="flex items-center mb-6">
                            <div class="flex-1 border-t-2 border-gray-300"></div>
                            <div class="px-4 text-sm text-gray-500 font-semibold">or</div>
                            <div class="flex-1 border-t-2 border-gray-300"></div>
                        </div>

                        <!-- Social Login -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <button type="button" class="flex items-center justify-center py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                <i class="fab fa-facebook text-blue-600 text-xl mr-2"></i>
                                <span class="text-gray-700">Facebook</span>
                            </button>
                            <button type="button" class="flex items-center justify-center py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                <i class="fab fa-google text-red-500 text-xl mr-2"></i>
                                <span class="text-gray-700">Google</span>
                            </button>
                        </div>

                        <!-- Sign Up Link -->
                        <div class="text-center">
                            <span class="text-gray-700">Don't have an account? </span>
                            <button type="button" onclick="switchTab('register')" class="text-green-700 hover:text-green-800 font-bold">
                                Create account
                            </button>
                        </div>
                    </form>
                </div>

                <!-- REGISTER TAB -->
                <div id="register-content" class="tab-content hidden">
                    <!-- Role Selection -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-800 mb-4">I'm registering as:</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Buyer Option -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="buyer" checked class="hidden peer" onclick="updateRegisterForm('buyer')">
                                <div class="peer-checked:ring-2 peer-checked:ring-green-700 peer-checked:bg-green-50 border-2 border-gray-300 rounded-lg p-4 cursor-pointer transition hover:border-green-700">
                                    <div class="text-center">
                                        <i class="fa-solid fa-shopping-cart text-3xl text-green-700 mb-2 block"></i>
                                        <span class="font-bold text-gray-900 text-sm">Buyer</span>
                                        <p class="text-xs text-gray-600 mt-1">Shop for groceries</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Shopkeeper Option -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="shopkeeper" class="hidden peer" onclick="updateRegisterForm('shopkeeper')">
                                <div class="peer-checked:ring-2 peer-checked:ring-orange-600 peer-checked:bg-orange-50 border-2 border-gray-300 rounded-lg p-4 cursor-pointer transition hover:border-orange-600">
                                    <div class="text-center">
                                        <i class="fa-solid fa-store text-3xl text-orange-600 mb-2 block"></i>
                                        <span class="font-bold text-gray-900 text-sm">Shopkeeper</span>
                                        <p class="text-xs text-gray-600 mt-1">Sell your products</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="register-form">
                        @csrf
                        <input type="hidden" name="role" value="buyer">

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="reg-name" class="block text-sm font-bold text-gray-800 mb-2">Full Name</label>
                            <input id="reg-name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="John Doe">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="reg-email" class="block text-sm font-bold text-gray-800 mb-2">Email Address</label>
                            <input id="reg-email" type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="you@example.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="reg-password" class="block text-sm font-bold text-gray-800 mb-2">Password</label>
                            <input id="reg-password" type="password" name="password" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-8">
                            <label for="reg-password-confirm" class="block text-sm font-bold text-gray-800 mb-2">Confirm Password</label>
                            <input id="reg-password-confirm" type="password" name="password_confirmation" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="w-full bg-black hover:bg-gray-900 text-white font-bold py-3 rounded-lg transition duration-300 mb-4 text-lg">
                            Create Account
                        </button>

                        <!-- Already have account -->
                        <div class="text-center">
                            <span class="text-gray-700">Already have an account? </span>
                            <button type="button" onclick="switchTab('login')" class="text-green-700 hover:text-green-800 font-bold">
                                Login here
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>

        <!-- Right Side - Hero Image with Overlay -->
        <div class="hidden lg:flex w-1/2 relative overflow-hidden">
            <!-- Background Image - Full Coverage -->
            <img src="{{ asset('images/grocery-hero.jpg') }}" alt="Fresh Groceries" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Dark Overlay Gradient - Bottom to Top -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-60"></div>

            <!-- Content - Positioned at Bottom -->
            <div class="relative flex flex-col items-center justify-end w-full h-full p-12 text-center pb-20">
                <h2 class="text-6xl font-black text-white mb-4 leading-tight drop-shadow-lg">
                    Fresh groceries
                </h2>
                <p class="text-2xl text-white font-light drop-shadow-md">
                    delivered to your doorstep
                </p>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all content
            document.getElementById('login-content').classList.add('hidden');
            document.getElementById('register-content').classList.add('hidden');
            
            // Remove active state
            document.getElementById('login-tab').classList.remove('bg-white', 'text-gray-900', 'shadow-md');
            document.getElementById('login-tab').classList.add('text-gray-600');
            document.getElementById('register-tab').classList.remove('bg-white', 'text-gray-900', 'shadow-md');
            document.getElementById('register-tab').classList.add('text-gray-600');

            // Show selected content
            if (tab === 'login') {
                document.getElementById('login-content').classList.remove('hidden');
                document.getElementById('login-tab').classList.add('bg-white', 'text-gray-900', 'shadow-md');
                document.getElementById('login-tab').classList.remove('text-gray-600');
            } else {
                document.getElementById('register-content').classList.remove('hidden');
                document.getElementById('register-tab').classList.add('bg-white', 'text-gray-900', 'shadow-md');
                document.getElementById('register-tab').classList.remove('text-gray-600');
            }
        }

        function updateRegisterForm(role) {
            document.querySelector('input[name="role"][type="hidden"]').value = role;
        }
    </script>
</x-guest-layout>
