<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Dashboard Sidebar Navigation -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-gauge-high"></i> Overview
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.orders') ? 'bg-emerald-600 text-white' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-receipt"></i> Order History
                    </a>
                    <a href="{{ route('dashboard.addresses') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.addresses') ? 'bg-emerald-600 text-white' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-location-dot"></i> Saved Addresses
                    </a>
                    <a href="{{ route('dashboard.wishlist') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.wishlist') ? 'bg-emerald-600 text-white' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-heart"></i> My Wishlist
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('profile.edit') ? 'bg-emerald-600 text-white' : 'text-slate-655 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-user-gear"></i> Profile Settings
                    </a>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="flex-grow space-y-6">
                
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h1 class="text-xl font-black text-slate-900 mb-2">My Wishlist</h1>
                    <p class="text-sm text-slate-500 mb-6">Review and add products saved for later purchasing.</p>

                    @if($wishlistItems->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($wishlistItems as $item)
                                @php
                                    $product = $item->product;
                                @endphp
                                @if($product)
                                    <div class="border border-slate-150 rounded-2xl p-4 flex flex-col justify-between bg-white relative group">
                                        
                                        <!-- Wishlist toggle / Remove button -->
                                        <div class="absolute right-3 top-3 z-10">
                                            <form action="{{ route('dashboard.wishlist.toggle', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-full bg-white hover:bg-red-50 text-red-500 flex items-center justify-center border border-slate-100 shadow-sm transition-colors" title="Remove from Wishlist">
                                                    <i class="fa-solid fa-heart text-xs"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div>
                                            <!-- Product Image -->
                                            <div class="aspect-square bg-slate-50 rounded-xl overflow-hidden mb-3 border border-slate-100 relative">
                                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                                            </div>

                                            <!-- Details -->
                                            @if($product->category)
                                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">{{ $product->category->name }}</span>
                                            @endif
                                            <h3 class="text-sm font-bold text-slate-800 hover:text-emerald-600 transition-colors mb-2 line-clamp-1">
                                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>

                                            <!-- Price -->
                                            <div class="flex items-center gap-2 mb-4">
                                                @if($product->has_discount)
                                                    <span class="text-emerald-600 font-bold text-sm">${{ number_format($product->discount_price, 2) }}</span>
                                                    <span class="text-slate-400 line-through text-xs">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="text-slate-850 font-bold text-sm">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Cart placement -->
                                        <div>
                                            @if($product->stock > 0)
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-colors flex items-center justify-center gap-2">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                        <span>Add to Basket</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-red-500 font-bold block text-center mb-2"><i class="fa-solid fa-ban mr-1"></i> Out of Stock</span>
                                                <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-2.5 px-4 rounded-xl text-xs cursor-not-allowed">
                                                    Unavailable
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $wishlistItems->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50/50 border border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-regular fa-heart text-slate-350 text-3xl mb-3 block"></i>
                            <p class="text-slate-550 text-sm mb-4">No products saved in your wishlist.</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-2.5 rounded-full transition-colors">
                                Add Items Now
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
