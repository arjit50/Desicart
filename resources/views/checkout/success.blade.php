<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Success Banner -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                <i class="fa-solid fa-circle-check text-4xl animate-bounce"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-2">Order Confirmed!</h1>
            <p class="text-slate-500 text-base">Thank you for your purchase. Your order is being processed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Details Panel -->
            <div class="md:col-span-7 space-y-6">
                
                <!-- Order Number & Info -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Order Information</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-slate-500">Order Number</span>
                            <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md text-xs">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-slate-500">Date & Time</span>
                            <span class="font-bold text-slate-800">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-slate-500">Payment Status</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold capitalize {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-slate-500">Shipping Status</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold capitalize bg-blue-100 text-blue-800">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Shipping Destination</h2>
                    <div class="text-slate-650 text-sm whitespace-pre-line leading-relaxed">
                        {{ $order->shipping_address }}
                    </div>
                </div>

                @if($order->notes)
                    <!-- Delivery Notes -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Delivery Instructions</h2>
                        <p class="text-slate-600 text-sm italic">"{{ $order->notes }}"</p>
                    </div>
                @endif
            </div>

            <!-- Receipt Breakdown Panel -->
            <div class="md:col-span-5">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Receipt Details</h2>

                    <!-- Items List -->
                    <div class="divide-y divide-slate-100 mb-6 max-h-48 overflow-y-auto pr-1">
                        @foreach($order->items as $item)
                            <div class="py-2.5 flex justify-between items-center gap-3 first:pt-0 last:pb-0">
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $item->product->name }}</h4>
                                    <span class="text-[10px] text-slate-400 font-medium">Qty: {{ $item->quantity }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-700">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="h-px bg-slate-100 mb-4"></div>

                    <!-- Pricing Math -->
                    <div class="space-y-3.5 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-800">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-emerald-600 font-semibold">
                                <span>Discount</span>
                                <span>&minus;${{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-slate-500">
                            <span>Delivery Fee</span>
                            <span class="font-bold text-slate-800">
                                @if($order->delivery_fee == 0)
                                    FREE
                                @else
                                    ${{ number_format($order->delivery_fee, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Sales Tax (8%)</span>
                            <span class="font-bold text-slate-800">${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="h-px bg-slate-100 my-3"></div>
                        <div class="flex justify-between text-slate-900 font-black text-sm">
                            <span>Grand Total</span>
                            <span class="text-emerald-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation CTAs -->
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('products.index') }}" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-full shadow-md text-sm text-center transition-colors">
                        Continue Shopping
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-6 rounded-full text-sm text-center transition-colors">
                        Track Order History
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
