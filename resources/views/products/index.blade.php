<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm sticky top-24">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center justify-between">
                        <span>Filters</span>
                        @if(count($filters) > 0)
                            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Clear All</a>
                        @endif
                    </h2>

                    <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                        
                        <!-- Search (if hidden on navbar) -->
                        <div class="block md:hidden">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Search</label>
                            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Keywords..." 
                                   class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3 py-2 text-sm" />
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Categories</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                @foreach($categories as $category)
                                    <label class="flex items-center space-x-2.5 cursor-pointer">
                                        <input type="radio" name="category" value="{{ $category->slug }}" 
                                               {{ (isset($filters['category']) && $filters['category'] === $category->slug) ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="w-4.5 h-4.5 text-emerald-600 border-slate-300 focus:ring-emerald-500/20 rounded-full" />
                                        <span class="text-sm text-slate-600 hover:text-slate-800">{{ $category->name }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold bg-slate-100 px-1.5 py-0.5 rounded-md ml-auto">{{ $category->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Brands</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                @foreach($brands as $brand)
                                    <label class="flex items-center space-x-2.5 cursor-pointer">
                                        <input type="radio" name="brand" value="{{ $brand->slug }}" 
                                               {{ (isset($filters['brand']) && $filters['brand'] === $brand->slug) ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="w-4.5 h-4.5 text-emerald-600 border-slate-300 focus:ring-emerald-500/20 rounded-full" />
                                        <span class="text-sm text-slate-600 hover:text-slate-800">{{ $brand->name }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold bg-slate-100 px-1.5 py-0.5 rounded-md ml-auto">{{ $brand->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Price Range</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" placeholder="Min" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3 py-2 text-xs" />
                                <span class="text-slate-400">&ndash;</span>
                                <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}" placeholder="Max" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3 py-2 text-xs" />
                            </div>
                        </div>

                        <!-- Rating -->
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Minimum Rating</label>
                            <div class="space-y-2">
                                @foreach([4, 3, 2] as $rate)
                                    <label class="flex items-center space-x-2.5 cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $rate }}" 
                                               {{ (isset($filters['rating']) && (int)$filters['rating'] === $rate) ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="w-4.5 h-4.5 text-emerald-600 border-slate-300 focus:ring-emerald-500/20 rounded-full" />
                                        <span class="text-sm text-slate-600 flex items-center space-x-1">
                                            <span>{{ $rate }}+</span>
                                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Buttons (for inputs like min/max price that don't trigger submit instantly) -->
                        <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors duration-200">
                            Apply Filters
                        </button>

                    </form>
                </div>
            </aside>

            <!-- Product Grid Catalog -->
            <div class="flex-grow">
                
                <!-- Sort and Header Section -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900">Grocery Catalog</h1>
                        <p class="text-sm text-slate-500">Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</p>
                    </div>

                    <!-- Sorting -->
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center space-x-2 w-full sm:w-auto">
                        <!-- Keep other filter values as hidden fields -->
                        @foreach($filters as $k => $v)
                            @if($k !== 'sort' && $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                            @endif
                        @endforeach
                        <label class="text-sm text-slate-500 whitespace-nowrap">Sort By:</label>
                        <select name="sort" onchange="this.form.submit()" 
                                class="bg-slate-50 border-0 focus:ring-2 focus:ring-emerald-500/30 rounded-full text-sm text-slate-700 font-medium px-4 py-2 pr-8">
                            <option value="latest" {{ (!isset($filters['sort']) || $filters['sort'] === 'latest') ? 'selected' : '' }}>Latest Arrivals</option>
                            <option value="price_low" {{ (isset($filters['sort']) && $filters['sort'] === 'price_low') ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ (isset($filters['sort']) && $filters['sort'] === 'price_high') ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popularity" {{ (isset($filters['sort']) && $filters['sort'] === 'popularity') ? 'selected' : '' }}>Customer Rating</option>
                        </select>
                    </form>
                </div>

                <!-- Catalog Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            <div class="group bg-white border border-slate-100 hover:border-emerald-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 relative flex flex-col h-full">
                                
                                <!-- Wishlist Toggle Button -->
                                <div class="absolute right-4 top-4 z-10">
                                    <form action="{{ route('dashboard.wishlist.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        @php
                                            $isWishlisted = Auth::check() ? Auth::user()->wishlists()->where('product_id', $product->id)->exists() : false;
                                        @endphp
                                        <button type="submit" class="w-9 h-9 rounded-full bg-white hover:bg-red-50 text-slate-400 hover:text-red-500 border border-slate-100 flex items-center justify-center transition-all duration-200">
                                            @if($isWishlisted)
                                                <i class="fa-solid fa-heart text-red-500 text-sm"></i>
                                            @else
                                                <i class="fa-regular fa-heart text-sm"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>

                                <!-- Discount Badge -->
                                @if($product->discount_price)
                                    <div class="absolute left-4 top-4 z-10">
                                        @php
                                            $saving = $product->price - $product->discount_price;
                                            $pct = round(($saving / $product->price) * 100);
                                        @endphp
                                        <span class="bg-amber-400 text-slate-950 text-[10px] font-extrabold px-2.5 py-1 rounded-full">
                                            Save {{ $pct }}%
                                        </span>
                                    </div>
                                @endif

                                <!-- Image -->
                                <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-50">
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                </a>

                                <!-- Details -->
                                <div class="p-5 flex flex-col flex-grow">
                                    <span class="text-xs text-slate-400 font-semibold uppercase mb-1">{{ $product->category->name }}</span>
                                    <h3 class="text-base font-bold text-slate-800 hover:text-emerald-600 transition-colors mb-2 line-clamp-1">
                                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    
                                    <!-- Rating -->
                                    <div class="flex items-center space-x-1 mb-3">
                                        <div class="flex text-amber-400 text-xs">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <span class="text-xs font-bold text-slate-700">{{ $product->rating }}</span>
                                        <span class="text-xs text-slate-400">({{ $product->reviews()->count() }})</span>
                                    </div>

                                    <!-- Price -->
                                    <div class="flex items-baseline space-x-2 mb-4">
                                        @if($product->discount_price)
                                            <span class="text-lg font-black text-emerald-600">${{ number_format($product->discount_price, 2) }}</span>
                                            <span class="text-sm text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-black text-slate-900">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <!-- Stock Check -->
                                        @if($product->stock > 0)
                                            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                                                <span>Stock: <strong>{{ $product->stock }} units</strong></span>
                                                @if($product->stock < 15)
                                                    <span class="text-red-500 font-semibold"><i class="fa-solid fa-circle-exclamation mr-1"></i> Low Stock</span>
                                                @else
                                                    <span class="text-emerald-500 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> In Stock</span>
                                                @endif
                                            </div>
                                            <form action="{{ route('cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl text-sm transition-all duration-200 flex items-center justify-center space-x-2">
                                                    <i class="fa-solid fa-cart-plus text-base"></i>
                                                    <span>Add to Basket</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="text-xs text-red-500 font-bold mb-4"><i class="fa-solid fa-ban mr-1"></i> Out of Stock</div>
                                            <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-3 px-4 rounded-xl text-sm cursor-not-allowed">
                                                Temporarily Unavailable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div>
                        {{ $products->links() }}
                    </div>

                @else
                    <!-- No Results -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-16 text-center shadow-sm">
                        <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-6">
                            <i class="fa-solid fa-basket-shopping text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">No Products Found</h3>
                        <p class="text-slate-500 max-w-sm mx-auto mb-6">We couldn't find any products matching your selected filters. Try broadening your keywords or removing some limits.</p>
                        <a href="{{ route('products.index') }}" class="bg-gradient-premium text-white font-semibold px-6 py-3 rounded-full text-sm shadow-md shadow-emerald-100 hover:opacity-90 transition-opacity">
                            View All Products
                        </a>
                    </div>
                @endif

            </div>

        </div>

    </div>
</x-app-layout>
