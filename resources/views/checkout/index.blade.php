<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <h1 class="text-3xl font-black text-slate-900 mb-8 flex items-center gap-3">
            <i class="fa-solid fa-credit-card text-emerald-600"></i>
            <span>Secure Checkout</span>
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left: Checkout Forms -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Main Order Placement Form -->
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="space-y-6">
                    @csrf
                    <!-- Pass coupon code forward -->
                    <input type="hidden" name="coupon_code" value="{{ $couponCode }}" />

                    <!-- Section 1: Shipping Address -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center justify-between">
                            <span>1. Shipping Address</span>
                            <a href="{{ route('dashboard.addresses') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[10px]"></i> Add Address
                            </a>
                        </h2>

                        @if($addresses->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($addresses as $address)
                                    <label class="relative border-2 rounded-2xl p-4 flex flex-col cursor-pointer transition-all duration-200 {{ ($defaultAddress && $defaultAddress->id === $address->id) ? 'border-emerald-500 bg-emerald-50/20' : 'border-slate-100 hover:border-slate-200 bg-white' }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="address_id" value="{{ $address->id }}" 
                                                       {{ ($defaultAddress && $defaultAddress->id === $address->id) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-emerald-600 border-slate-350 focus:ring-emerald-500/20" />
                                                <span class="font-bold text-slate-800 text-sm capitalize">{{ $address->type }} Address</span>
                                            </div>
                                            @if($address->is_default)
                                                <span class="bg-emerald-500 text-white font-extrabold text-[8px] tracking-wider uppercase px-2 py-0.5 rounded-full">Default</span>
                                            @endif
                                        </div>
                                        <div class="mt-3 text-xs text-slate-500 space-y-1">
                                            <p class="font-bold text-slate-700">{{ $address->name }}</p>
                                            <p>{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p>{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                                            <p>{{ $address->country }}</p>
                                            <p class="font-semibold text-slate-650 mt-1"><i class="fa-solid fa-phone text-[10px]"></i> {{ $address->phone }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                                <i class="fa-solid fa-location-dot text-slate-300 text-3xl mb-3 block"></i>
                                <h3 class="font-bold text-slate-700 mb-1">No Saved Addresses Found</h3>
                                <p class="text-slate-500 text-xs mb-4">You must add a shipping address before completing your checkout.</p>
                                <a href="{{ route('dashboard.addresses') }}" class="inline-block bg-slate-950 hover:bg-slate-900 text-white font-bold text-xs px-5 py-2.5 rounded-full transition-colors">
                                    Create Address
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Section 2: Payment Method -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-900 mb-6">2. Select Payment Method</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- COD -->
                            <label class="border-2 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-emerald-200 bg-white transition-all [&:has(input:checked)]:border-emerald-500 [&:has(input:checked)]:bg-emerald-50/20">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4 text-emerald-600 border-slate-350 focus:ring-emerald-500/20" />
                                    <div>
                                        <span class="block font-bold text-slate-800 text-sm">Cash / Delivery</span>
                                        <span class="text-[10px] text-slate-400">Pay on parcel arrival</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-money-bill-wave text-emerald-600 text-lg"></i>
                            </label>

                            <!-- Stripe -->
                            <label class="border-2 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-emerald-200 bg-white transition-all [&:has(input:checked)]:border-emerald-500 [&:has(input:checked)]:bg-emerald-50/20">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="stripe" class="w-4 h-4 text-emerald-600 border-slate-350 focus:ring-emerald-500/20" />
                                    <div>
                                        <span class="block font-bold text-slate-800 text-sm">Stripe Card</span>
                                        <span class="text-[10px] text-slate-400">Instant credit card</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-credit-card text-emerald-600 text-lg"></i>
                            </label>

                            <!-- PayPal -->
                            <label class="border-2 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-emerald-200 bg-white transition-all [&:has(input:checked)]:border-emerald-500 [&:has(input:checked)]:bg-emerald-50/20">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="paypal" class="w-4 h-4 text-emerald-600 border-slate-350 focus:ring-emerald-500/20" />
                                    <div>
                                        <span class="block font-bold text-slate-800 text-sm">PayPal Account</span>
                                        <span class="text-[10px] text-slate-400">Secure wallet login</span>
                                    </div>
                                </div>
                                <i class="fa-brands fa-paypal text-emerald-600 text-lg"></i>
                            </label>
                        </div>
                    </div>

                    <!-- Section 3: Extra Notes -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">3. Delivery Instructions (Optional)</h2>
                        <textarea name="notes" rows="3" placeholder="Apartment code, dropoff location, or details to help delivery agent..." class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-2xl px-4 py-3 text-sm"></textarea>
                    </div>

                </form>
            </div>

            <!-- Right: Order Review -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Items list summary -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-base font-bold text-slate-900 mb-4">Order Items</h2>
                    
                    <div class="divide-y divide-slate-100 max-h-60 overflow-y-auto pr-1 mb-4">
                        @foreach($cart->items->where('save_for_later', false) as $item)
                            <div class="py-3 flex items-center gap-3 first:pt-0 last:pb-0">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex-shrink-0">
                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $item->product->name }}</h4>
                                    <span class="text-[10px] text-slate-450 block font-medium">Qty: {{ $item->quantity }} &times; ${{ number_format($item->product->final_price, 2) }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-700 flex-shrink-0">
                                    ${{ number_format($item->product->final_price * $item->quantity, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="h-px bg-slate-100 mb-6"></div>

                    <!-- Coupon Code Input Box -->
                    <h3 class="text-xs font-bold text-slate-450 uppercase tracking-wider mb-2.5">Have a Promo Coupon?</h3>
                    <form action="{{ route('checkout.index') }}" method="GET" class="flex gap-2 mb-4">
                        <input type="text" name="coupon_code" value="{{ $couponCode }}" placeholder="Enter code (e.g. SAVE10)" 
                               class="bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3 py-2 text-xs font-mono font-bold uppercase flex-grow" />
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2 rounded-xl text-xs transition-colors">
                            Apply
                        </button>
                    </form>

                    <!-- Coupon application alerts -->
                    @if($couponCode)
                        @if($couponSuccess)
                            <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl p-3 text-xs font-semibold flex items-center gap-2 mb-6">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                                <span>Coupon Applied successfully! Saved ${{ number_format($discount, 2) }}</span>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-100 text-red-800 rounded-xl p-3 text-xs font-semibold flex items-center gap-2 mb-6">
                                <i class="fa-solid fa-circle-xmark text-red-500 text-sm"></i>
                                <span>{{ $couponMessage }}</span>
                            </div>
                        @endif
                    @endif

                    <!-- Financial Summary -->
                    <div class="space-y-4 mb-6 text-sm">
                        <div class="flex items-center justify-between text-slate-500">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-850">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        @if($discount > 0)
                            <div class="flex items-center justify-between text-emerald-600 font-semibold">
                                <span>Discount</span>
                                <span>&minus;${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-slate-500">
                            <span>Delivery Fee</span>
                            <span class="font-bold text-slate-850">
                                @if($deliveryFee == 0)
                                    <span class="text-emerald-600">FREE</span>
                                @else
                                    ${{ number_format($deliveryFee, 2) }}
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-slate-500">
                            <span>Est. Sales Tax (8%)</span>
                            <span class="font-bold text-slate-850">${{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="h-px bg-slate-100 my-4"></div>

                        <div class="flex items-center justify-between text-slate-900 font-black text-base">
                            <span>Order Total</span>
                            <span class="text-emerald-600 text-lg">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Submit trigger -->
                    @if($addresses->count() > 0)
                        <button type="submit" form="checkout-form" class="w-full bg-gradient-premium text-white font-bold py-4 px-6 rounded-full shadow-lg hover:shadow-emerald-500/20 transition-all flex items-center justify-center space-x-2">
                            <span>Place Order (${{ number_format($total, 2) }})</span>
                            <i class="fa-solid fa-lock text-sm"></i>
                        </button>
                    @else
                        <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-6 rounded-full cursor-not-allowed flex items-center justify-center space-x-2">
                            <span>Address Required</span>
                            <i class="fa-solid fa-ban text-sm"></i>
                        </button>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
