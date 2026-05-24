<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Dashboard Sidebar Navigation -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-gauge-high"></i> Overview
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.orders') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-receipt"></i> Order History
                    </a>
                    <a href="{{ route('dashboard.addresses') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.addresses') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-location-dot"></i> Saved Addresses
                    </a>
                    <a href="{{ route('dashboard.wishlist') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.wishlist') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-heart"></i> My Wishlist
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('profile.edit') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-user-gear"></i> Profile Settings
                    </a>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="flex-grow space-y-8">
                
                <!-- Greeting -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 mb-1">Hello, {{ Auth::user()->name }}!</h1>
                        <p class="text-sm text-slate-500">Welcome back. Manage your orders, delivery points, and wishlisted items.</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 text-xl font-black uppercase">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                </div>

                <!-- Statistics Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Orders card -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Orders</span>
                            <span class="block text-2xl font-black text-slate-800">{{ Auth::user()->orders()->count() }}</span>
                        </div>
                    </div>
                    <!-- Wishlist card -->
                    <a href="{{ route('dashboard.wishlist') }}" class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex items-center gap-5 hover:border-emerald-250 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">My Wishlist</span>
                            <span class="block text-2xl font-black text-slate-800">{{ $wishlistCount }} Items</span>
                        </div>
                    </a>
                    <!-- Addresses card -->
                    <a href="{{ route('dashboard.addresses') }}" class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex items-center gap-5 hover:border-emerald-250 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fa-solid fa-map-pin"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Saved Addresses</span>
                            <span class="block text-2xl font-black text-slate-800">{{ $addressCount }} Points</span>
                        </div>
                    </a>
                </div>

                <!-- Section: Recent Orders -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center justify-between">
                        <span>Recent Orders</span>
                        <a href="{{ route('dashboard.orders') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">View All Orders &rarr;</a>
                    </h2>

                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 font-bold">
                                        <th class="pb-3 text-xs uppercase tracking-wider">Order No.</th>
                                        <th class="pb-3 text-xs uppercase tracking-wider">Date</th>
                                        <th class="pb-3 text-xs uppercase tracking-wider">Items Count</th>
                                        <th class="pb-3 text-xs uppercase tracking-wider">Total</th>
                                        <th class="pb-3 text-xs uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-slate-700">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="py-4 font-mono font-bold text-slate-900 text-xs">
                                                {{ $order->order_number }}
                                            </td>
                                            <td class="py-4 text-slate-505">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="py-4">{{ $order->items->sum('quantity') }} items</td>
                                            <td class="py-4 font-bold text-emerald-600">${{ number_format($order->total, 2) }}</td>
                                            <td class="py-4">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold capitalize 
                                                    {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                                    {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-slate-100 text-slate-500' : '' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50/50 border border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-dolly text-slate-300 text-3xl mb-3 block"></i>
                            <p class="text-slate-550 text-sm mb-4">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-2.5 rounded-full transition-colors">
                                Browse Catalogue
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
