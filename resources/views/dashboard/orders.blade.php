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
            <div class="flex-grow space-y-6">
                
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h1 class="text-xl font-black text-slate-900 mb-2">Order History</h1>
                    <p class="text-sm text-slate-500 mb-6">Review invoices and status details for all your e-commerce purchases.</p>

                    @if($orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-slate-150 rounded-2xl overflow-hidden shadow-sm">
                                    
                                    <!-- Header details -->
                                    <div class="bg-slate-50 border-b border-slate-100 p-4 flex flex-wrap items-center justify-between gap-4 text-xs font-bold text-slate-500">
                                        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                                            <div>
                                                <span class="block uppercase tracking-wider text-[10px] text-slate-400">Order Placed</span>
                                                <span class="text-slate-700 font-bold mt-0.5 block">{{ $order->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div>
                                                <span class="block uppercase tracking-wider text-[10px] text-slate-400">Total Charged</span>
                                                <span class="text-emerald-600 font-extrabold mt-0.5 block">${{ number_format($order->total, 2) }}</span>
                                            </div>
                                            <div>
                                                <span class="block uppercase tracking-wider text-[10px] text-slate-400">Ship To</span>
                                                <span class="text-slate-700 font-bold mt-0.5 block truncate max-w-[150px]">{{ explode("\n", $order->shipping_address)[0] }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block uppercase tracking-wider text-[10px] text-slate-400 text-right sm:text-left">Order #</span>
                                            <span class="font-mono text-slate-800 bg-slate-200 px-2 py-0.5 rounded-md text-[10px] mt-0.5 block">{{ $order->order_number }}</span>
                                        </div>
                                    </div>

                                    <!-- Content items and details -->
                                    <div class="p-5">
                                        <!-- Status Indicator -->
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="w-2.5 h-2.5 rounded-full 
                                                {{ $order->status === 'delivered' ? 'bg-emerald-500' : '' }}
                                                {{ $order->status === 'pending' ? 'bg-amber-500' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-500' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-indigo-500' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-slate-400' : '' }}"></span>
                                            <span class="text-xs font-extrabold capitalize text-slate-700">Status: {{ $order->status }}</span>
                                        </div>

                                        <div class="divide-y divide-slate-100">
                                            @foreach($order->items as $item)
                                                <div class="py-4 first:pt-0 last:pb-0 flex items-center gap-4">
                                                    <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                                                    </div>
                                                    <div class="flex-grow min-w-0">
                                                        <h4 class="text-sm font-bold text-slate-800 hover:text-emerald-600 transition-colors truncate">
                                                            <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                                        </h4>
                                                        <span class="text-xs text-slate-400 font-semibold block mt-0.5">Quantity: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</span>
                                                    </div>
                                                    <span class="text-sm font-bold text-slate-800 flex-shrink-0">
                                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50/50 border border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-file-invoice text-slate-350 text-3xl mb-3 block"></i>
                            <p class="text-slate-500 text-sm mb-4">No order logs found in your history.</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-2.5 rounded-full transition-colors">
                                Shop Fresh Catalog
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
