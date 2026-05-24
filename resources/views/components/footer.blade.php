<!-- Freshimart Footer -->
<footer class="mt-auto border-t border-slate-200 pt-12 pb-6 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">

            <!-- Brand -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/desicart_logo.png') }}" alt="Freshimart" class="h-9 w-9 rounded" />
                    <span class="text-xl font-bold text-slate-900">Freshimart</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Fresh groceries delivered to your door with smart deals and real-time stock tracking.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-green-600 text-slate-600 hover:text-white transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-green-600 text-slate-600 hover:text-white transition-colors"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-green-600 text-slate-600 hover:text-white transition-colors"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-semibold">Quick Links</h4>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li><a href="{{ route('home') }}" class="hover:text-green-700 transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-green-700 transition-colors">Shop</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-green-700 transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-green-700 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-semibold">Categories</h4>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li><a href="{{ route('products.index') }}?category=fruits" class="hover:text-green-700 transition-colors">Fresh Fruits</a></li>
                    <li><a href="{{ route('products.index') }}?category=vegetables" class="hover:text-green-700 transition-colors">Vegetables</a></li>
                    <li><a href="{{ route('products.index') }}?category=dairy" class="hover:text-green-700 transition-colors">Dairy</a></li>
                    <li><a href="{{ route('products.index') }}?category=beverages" class="hover:text-green-700 transition-colors">Beverages</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-semibold">Contact Us</h4>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-location-dot text-green-600"></i><span>100 Fresh Ave, New York</span></li>
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-phone text-green-600"></i><span>+1 (800) 123-4567</span></li>
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-envelope text-green-600"></i><span>support@freshimart.com</span></li>
                </ul>
            </div>

        </div>

        <hr class="border-slate-200 mb-6" />
        <div class="flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Freshimart. All rights reserved.</p>
            <div class="flex space-x-6 mt-3 md:mt-0">
                <a href="#" class="hover:text-slate-700">Privacy Policy</a>
                <a href="#" class="hover:text-slate-700">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
