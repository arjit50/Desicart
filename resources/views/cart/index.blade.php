<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <h1 class="text-3xl font-black text-slate-900 mb-8 flex items-center gap-3">
            <i class="fa-solid fa-basket-shopping text-emerald-600"></i>
            <span>Your Shopping Basket</span>
        </h1>

        @php
            $activeItems = $cart->items->where('save_for_later', false);
            $savedItems = $cart->items->where('save_for_later', true);
        @endphp

        @if($activeItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
                
                <!-- Left: Active Basket Items -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <div class="divide-y divide-slate-100">
                            @foreach($activeItems as $item)
                                <div class="py-6 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-center sm:items-start gap-5">
                                    
                                    <!-- Image -->
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 flex-shrink-0">
                                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-grow text-center sm:text-left">
                                        @if($item->product->category)
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">
                                                {{ $item->product->category->name }}
                                            </span>
                                        @endif
                                        <h3 class="text-base font-bold text-slate-800 hover:text-emerald-600 transition-colors">
                                            <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                        </h3>
                                        <div class="flex items-center justify-center sm:justify-start gap-2 mt-2">
                                            @if($item->product->has_discount)
                                                <span class="text-emerald-600 font-bold text-sm">${{ number_format($item->product->discount_price, 2) }}</span>
                                                <span class="text-slate-400 line-through text-xs">${{ number_format($item->product->price, 2) }}</span>
                                            @else
                                                <span class="text-slate-850 font-bold text-sm">${{ number_format($item->product->price, 2) }}</span>
                                            @endif
                                        </div>

                                        <!-- Stock Alert inside Cart -->
                                        @if($item->product->stock < 10)
                                            <span class="text-[10px] text-red-500 font-bold mt-1.5 inline-flex items-center gap-1">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Only {{ $item->product->stock }} left in stock
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Actions Panel -->
                                    <div class="flex flex-col items-center sm:items-end gap-3 flex-shrink-0">
                                        
                                        <!-- Quantity Form -->
                                        <form action="{{ route('cart.update', $item->product_id) }}" method="POST" class="flex items-center border border-slate-200 rounded-full p-0.5 bg-slate-50">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" {{ $item->quantity <= 1 ? 'disabled' : '' }} class="w-8 h-8 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 disabled:opacity-30 disabled:pointer-events-none transition-colors font-bold">&minus;</button>
                                            <span class="w-8 text-center text-xs font-bold text-slate-800">{{ $item->quantity }}</span>
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }} class="w-8 h-8 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 disabled:opacity-30 disabled:pointer-events-none transition-colors font-bold">&plus;</button>
                                        </form>

                                        <!-- Save & Delete Actions -->
                                        <div class="flex items-center gap-3">
                                            <form action="{{ route('cart.toggle-save', $item->product_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-emerald-600 hover:underline font-semibold flex items-center gap-1">
                                                    <i class="fa-regular fa-bookmark"></i> Save for later
                                                </button>
                                            </form>
                                            <span class="text-slate-200">|</span>
                                            <form action="{{ route('cart.destroy', $item->product_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:underline font-semibold flex items-center gap-1">
                                                    <i class="fa-regular fa-trash-can"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Cart Summary Box -->
                <div class="lg:col-span-4">
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm sticky top-24">
                        <h2 class="text-lg font-bold text-slate-900 mb-6">Order Summary</h2>

                        @php
                            $subtotal = $cart->subtotal;
                            $freeShippingThreshold = 50.00;
                            $deliveryFee = $subtotal >= $freeShippingThreshold ? 0.00 : 4.99;
                            $tax = round($subtotal * 0.08, 2);
                            $total = $subtotal + $deliveryFee + $tax;
                        @endphp

                        <!-- Free Delivery Progress Tracker -->
                        @if($subtotal < $freeShippingThreshold)
                            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-6">
                                @php
                                    $needed = $freeShippingThreshold - $subtotal;
                                    $percent = min(100, round(($subtotal / $freeShippingThreshold) * 100));
                                @endphp
                                <p class="text-xs font-semibold text-emerald-800 mb-2.5">
                                    Add <strong class="text-emerald-900 font-bold">${{ number_format($needed, 2) }}</strong> more to unlock <strong>FREE Delivery</strong>!
                                </p>
                                <div class="w-full bg-emerald-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-6 flex items-center gap-3 text-emerald-800">
                                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <div class="text-xs font-semibold">
                                    <span class="block font-bold text-emerald-900">Congratulations!</span>
                                    You qualify for free home delivery!
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4 mb-6 text-sm">
                            <div class="flex items-center justify-between text-slate-500">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-800">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500">
                                <span>Delivery Fee</span>
                                <span class="font-bold text-slate-800">
                                    @if($deliveryFee == 0)
                                        <span class="text-emerald-600">FREE</span>
                                    @else
                                        ${{ number_format($deliveryFee, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500">
                                <span>Est. Sales Tax (8%)</span>
                                <span class="font-bold text-slate-800">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="h-px bg-slate-100 my-4"></div>
                            <div class="flex items-center justify-between text-slate-900 font-black text-lg">
                                <span>Estimated Total</span>
                                <span class="text-emerald-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="w-full bg-gradient-premium text-white font-bold py-4 px-6 rounded-full shadow-lg hover:shadow-emerald-500/20 transition-all flex items-center justify-center space-x-2">
                            <span>Proceed to Checkout</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index') }}" class="text-xs text-slate-400 hover:text-emerald-600 font-bold transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- Empty Cart State -->
            <div class="bg-white border border-slate-100 rounded-3xl p-16 text-center shadow-sm mb-12">
                <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-basket-shopping text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Your Basket is Empty</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Before you proceed to checkout, you must add some products to your basket. You will find lots of interesting products on our shop.</p>
                <a href="{{ route('products.index') }}" class="bg-slate-900 hover:bg-emerald-600 text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-md transition-colors inline-block">
                    Explore Products
                </a>
            </div>
        @endif

        <!-- Section: Saved for Later Shelf -->
        @if($savedItems->count() > 0)
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 sm:p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fa-regular fa-bookmark text-emerald-600"></i>
                    <span>Saved for Later ({{ $savedItems->count() }})</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($savedItems as $item)
                        <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                            
                            <!-- Product Image -->
                            <div class="aspect-square bg-slate-50 rounded-xl overflow-hidden mb-3 border border-slate-100 relative">
                                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                            </div>

                            <!-- Title -->
                            <h3 class="text-sm font-bold text-slate-800 mb-1 line-clamp-2">{{ $item->product->name }}</h3>
                            <div class="mb-4">
                                @if($item->product->has_discount)
                                    <span class="text-emerald-600 font-bold text-xs">${{ number_format($item->product->discount_price, 2) }}</span>
                                    <span class="text-slate-400 line-through text-[10px] ml-1">${{ number_format($item->product->price, 2) }}</span>
                                @else
                                    <span class="text-slate-800 font-bold text-xs">${{ number_format($item->product->price, 2) }}</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto space-y-2.5">
                                <form action="{{ route('cart.toggle-save', $item->product_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-2 rounded-xl text-xs transition-colors">
                                        Move to Basket
                                    </button>
                                </form>
                                <form action="{{ route('cart.destroy', $item->product_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full border border-slate-200 text-red-500 hover:bg-red-50 font-bold py-2 rounded-xl text-xs transition-colors">
                                        Remove Item
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
