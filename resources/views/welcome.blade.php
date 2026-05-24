<x-app-layout>
    
    <!-- Hero Section - Split Layout with Auto-Scrolling Carousel -->
    <style>
        .hero-carousel {
            overflow: hidden;
            border-radius: 24px;
            position: relative;
            background: linear-gradient(135deg, #ff9a56 0%, #ff7043 100%);
        }
        .carousel-images {
            display: flex;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }
        .carousel-image {
            flex: 0 0 100%;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #ffb380 0%, #ff9a56 100%);
            position: relative;
        }
        .carousel-image img {
            width: 100%;
            height: 100%;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            display: block;
        }
        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
        }
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        .dot.active {
            background-color: #ffffff;
            width: 28px;
            border-radius: 5px;
        }
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 15;
            background: white;
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .carousel-nav-btn:hover {
            background: #f0f0f0;
            transform: translateY(-50%) scale(1.1);
        }
        .carousel-nav-btn.prev {
            left: 16px;
        }
        .carousel-nav-btn.next {
            right: 16px;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Side - Text Content -->
            <div class="bg-slate-100 p-8 rounded-[2rem] shadow-sm scroll-reveal" data-reveal-delay="120">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-4">
                    We deliver <br/>
                    <span class="text-green-700">grocery all over</span> <br/>
                    <span class="animate-text-shine">India</span>
                </h1>
                <p class="text-sm font-semibold text-green-600 uppercase tracking-widest mb-8">GET THEM ALL IN OUR STORE</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold text-base px-8 py-3 rounded transition-colors duration-300">
                    SHOP NOW
                </a>
            </div>
            
            <!-- Right Side - Auto-Scrolling Carousel with Orange Background -->
            <div class="relative scroll-reveal" data-reveal-delay="240" x-data="heroCarousel()" x-init="init()">
                <div class="hero-carousel h-96 relative">
                    <!-- Carousel Images -->
                    <div class="carousel-images" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                        <div class="carousel-image">
                            <img src="{{ asset('images/carousel/Gemini_Generated_Image_sag0pqsag0pqsag0 (1).png') }}" alt="Carousel Slide 1" loading="lazy">
                        </div>
                        <div class="carousel-image">
                            <img src="{{ asset('images/carousel/Gemini_Generated_Image_sag0pqsag0pqsag0 (2).png') }}" alt="Carousel Slide 2" loading="lazy">
                        </div>
                        <div class="carousel-image">
                            <img src="{{ asset('images/carousel/Gemini_Generated_Image_sag0pqsag0pqsag0 (3).png') }}" alt="Carousel Slide 3" loading="lazy">
                        </div>
                        <div class="carousel-image">
                            <img src="{{ asset('images/carousel/Gemini_Generated_Image_sag0pqsag0pqsag0 (4).png') }}" alt="Carousel Slide 4" loading="lazy">
                        </div>
                        <div class="carousel-image">
                            <img src="{{ asset('images/carousel/Gemini_Generated_Image_sag0pqsag0pqsag0 (5).png') }}" alt="Carousel Slide 5" loading="lazy">
                        </div>
                    </div>

                    <!-- Navigation Arrows -->
                    <button @click="prev()" class="carousel-nav-btn prev" aria-label="Previous">
                        <i class="fa-solid fa-chevron-left text-orange-600 text-xl"></i>
                    </button>
                    <button @click="next()" class="carousel-nav-btn next" aria-label="Next">
                        <i class="fa-solid fa-chevron-right text-orange-600 text-xl"></i>
                    </button>

                    <!-- Carousel Dots -->
                    <div class="carousel-dots">
                        <template x-for="(i) in 5" :key="i">
                            <button @click="currentSlide = i - 1" :class="{ 'active': currentSlide === i - 1 }" class="dot"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Carousel Logic -->
    <script>
        function heroCarousel() {
            return {
                currentSlide: 0,
                autoplayInterval: null,
                init() {
                    this.startAutoplay();
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % 5;
                    this.resetAutoplay();
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + 5) % 5;
                    this.resetAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % 5;
                    }, 3500);
                },
                resetAutoplay() {
                    clearInterval(this.autoplayInterval);
                    this.startAutoplay();
                }
            }
        }
    </script>

    <!-- Popular Right Now Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 mb-16 scroll-reveal" data-reveal-delay="120">
        <div class="flex items-center justify-between mb-8 scroll-reveal" data-reveal-delay="160">
            <h2 class="text-3xl font-bold text-green-700">Popular right now</h2>
            <a href="{{ route('products.index') }}" class="text-slate-600 hover:text-green-700 font-semibold flex items-center gap-2">
                View All <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
        
        <!-- Products Carousel -->
        <div class="relative">
            <div class="flex items-center gap-6">
                <!-- Previous Button -->
                <button onclick="document.querySelector('.products-carousel').scrollLeft -= 300" 
                        class="absolute left-0 z-10 bg-white hover:bg-slate-100 border border-slate-200 rounded-full p-3 shadow transition-colors">
                    <i class="fa-solid fa-chevron-left text-slate-900"></i>
                </button>
                
                <!-- Carousel -->
                <div class="products-carousel flex gap-6 overflow-x-auto scroll-smooth scrollbar-none px-16">
                    @foreach($popularProducts as $product)
                        <a href="{{ route('products.show', $product) }}" 
                           class="flex-shrink-0 w-40 group cursor-pointer scroll-reveal" data-reveal-delay="240">
                            <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-shadow p-4">
                                <div class="w-full h-40 bg-slate-100 rounded-lg overflow-hidden mb-4 flex items-center justify-center">
                                    <img src="{{ $product->primary_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                                <h3 class="text-sm font-semibold text-slate-900 text-center group-hover:text-green-700 transition-colors">
                                    {{ Str::limit($product->name, 25) }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <!-- Next Button -->
                <button onclick="document.querySelector('.products-carousel').scrollLeft += 300" 
                        class="absolute right-0 z-10 bg-white hover:bg-slate-100 border border-slate-200 rounded-full p-3 shadow transition-colors">
                    <i class="fa-solid fa-chevron-right text-slate-900"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Weekly Best Deals Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 mb-16 scroll-reveal" data-reveal-delay="120">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-8 scroll-reveal" data-reveal-delay="160">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">The week's best for less</h2>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                View All
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div class="grid grid-cols-1 lg:grid-cols-[1.4fr,0.9fr] gap-6">
                <a href="{{ route('products.index') }}?search=offer" class="group relative overflow-hidden rounded-[2rem] bg-slate-900 text-white shadow-2xl shadow-emerald-300/20 flex flex-col justify-between p-8 min-h-[340px] overflow-hidden scroll-reveal" data-reveal-delay="220">
                    <div class="absolute inset-0 opacity-30 bg-black"></div>
                    <img src="{{ asset('images/deals/offercard (2).png') }}" alt="Offer" class="absolute inset-0 h-full w-full object-cover opacity-80" />
                    <div class="relative z-10">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-2 text-xs uppercase tracking-[0.2em] text-white/90">Hot Deal</span>
                        <div class="mt-8">
                            <p class="text-5xl sm:text-6xl font-extrabold leading-tight">Save 25%</p>
                            <p class="mt-3 text-lg font-semibold text-white/90">On fresh grocery essentials</p>
                        </div>
                    </div>
                    <div class="relative z-10 grid gap-3">
                        <span class="inline-flex items-center justify-center rounded-full bg-white/10 border border-white/20 px-7 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">Shop now</span>
                        <div class="grid grid-cols-2 gap-2 text-[11px] text-white/80">
                            <span class="rounded-full bg-white/10 px-2.5 py-1.5">Free Shipping</span>
                            <span class="rounded-full bg-white/10 px-2.5 py-1.5">Best Sellers</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('products.index') }}?search=masala" class="group relative overflow-hidden rounded-[2rem] bg-slate-950 text-white shadow-2xl shadow-slate-900/30 flex flex-col justify-between p-6 min-h-[340px] scroll-reveal" data-reveal-delay="240">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-2 text-xs uppercase tracking-[0.2em] text-white/90">Masala</span>
                        <div class="mt-6">
                            <p class="text-3xl sm:text-4xl font-extrabold leading-tight">Bold spices</p>
                            <p class="mt-3 text-sm sm:text-base text-slate-300">Flavorful blends crafted for every kitchen.</p>
                        </div>
                    </div>
                    <div class="relative h-36 overflow-hidden rounded-3xl bg-slate-800 mt-5">
                        <img src="{{ asset('images/deals/masala.png') }}" alt="Masala" class="w-full h-full object-cover opacity-90" />
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="group overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-[320px] scroll-reveal" data-reveal-delay="260">
                    <a href="{{ route('products.index', ['search' => 'rice']) }}" class="block relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ asset('images/deals/rice.png') }}" alt="Rice" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </a>
                    <div class="p-2 flex flex-col flex-grow">
                        <div class="mb-1">
                            <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2">Minute Instant White Rice</h3>
                            <p class="text-[10px] uppercase text-slate-400 tracking-[0.18em]">Rice</p>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-900">$3.99</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">SAVE 20%</span>
                        </div>
                        <a href="{{ route('products.index', ['search' => 'rice']) }}" class="mt-auto inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white py-2 text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fa-solid fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>

                <div class="group overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-[320px] scroll-reveal" data-reveal-delay="280">
                    <a href="{{ route('products.index', ['search' => 'wheat']) }}" class="block relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ asset('images/deals/wheat.png') }}" alt="Wheat" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </a>
                    <div class="p-2 flex flex-col flex-grow">
                        <div class="mb-1">
                            <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2">Whole Wheat Flour</h3>
                            <p class="text-[10px] uppercase text-slate-400 tracking-[0.18em]">Wheat</p>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-900">$4.29</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">SAVE 18%</span>
                        </div>
                        <a href="{{ route('products.index', ['search' => 'wheat']) }}" class="mt-auto inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white py-2 text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fa-solid fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>

                <div class="group overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-[320px] scroll-reveal" data-reveal-delay="300">
                    <a href="{{ route('products.index', ['search' => 'olive oil']) }}" class="block relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ asset('images/deals/olive oil.png') }}" alt="Olive Oil" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </a>
                    <div class="p-2 flex flex-col flex-grow">
                        <div class="mb-1">
                            <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2">Extra Virgin Olive Oil</h3>
                            <p class="text-[10px] uppercase text-slate-400 tracking-[0.18em]">Olive Oil</p>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-900">$8.99</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">SAVE 15%</span>
                        </div>
                        <a href="{{ route('products.index', ['search' => 'olive oil']) }}" class="mt-auto inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white py-2 text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fa-solid fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>

                <div class="group overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-[320px] scroll-reveal" data-reveal-delay="320">
                    <a href="{{ route('products.index', ['search' => 'palm oil']) }}" class="block relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ asset('images/deals/palmoil.png') }}" alt="Palm Oil" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </a>
                    <div class="p-2 flex flex-col flex-grow">
                        <div class="mb-1">
                            <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2">Premium Palm Oil</h3>
                            <p class="text-[10px] uppercase text-slate-400 tracking-[0.18em]">Palm Oil</p>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-900">$5.49</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">SAVE 12%</span>
                        </div>
                        <a href="{{ route('products.index', ['search' => 'palm oil']) }}" class="mt-auto inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white py-2 text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fa-solid fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hot Deals Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 mb-16 scroll-reveal" data-reveal-delay="120">
        <div class="flex items-center justify-between mb-8 scroll-reveal" data-reveal-delay="160">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Trending Smart Deals</h2>
                <p class="text-sm text-slate-500">Stock up and save big with our top discounted items</p>
            </div>
            <a href="{{ route('products.index') }}?sort=price_low" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">View All Deals &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($trending as $product)
                <div class="group scroll-reveal bg-white border border-slate-100 hover:border-emerald-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 relative flex flex-col h-full">
                    
                    <!-- Discount Badge -->
                    <div class="absolute left-4 top-4 z-10">
                        @php
                            $saving = $product->price - $product->discount_price;
                            $pct = round(($saving / $product->price) * 100);
                        @endphp
                        <span class="bg-amber-400 text-slate-950 text-xs font-extrabold px-3 py-1 rounded-full shadow-sm">
                            Save {{ $pct }}%
                        </span>
                    </div>

                    <!-- Product Image -->
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

                        <!-- Price and Stock -->
                        <div class="flex items-baseline space-x-2 mb-4">
                            <span class="text-lg font-black text-emerald-600">${{ number_format($product->discount_price, 2) }}</span>
                            <span class="text-sm text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
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
    </div>

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 mb-16 scroll-reveal" data-reveal-delay="120">
        <div class="flex items-center justify-between mb-8 scroll-reveal" data-reveal-delay="160">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Featured Fresh Favorites</h2>
                <p class="text-sm text-slate-500">Pick from our highest customer-rated items</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Explore Catalog &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featured as $product)
                <div class="group scroll-reveal bg-white border border-slate-100 hover:border-emerald-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 relative flex flex-col h-full" data-reveal-delay="220">
                    
                    <!-- Product Image -->
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revealElements = document.querySelectorAll('.scroll-reveal');
            if (!('IntersectionObserver' in window)) {
                revealElements.forEach(el => el.classList.add('reveal-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.revealDelay, 10) || 0;
                        entry.target.style.transitionDelay = `${delay}ms`;
                        entry.target.classList.add('reveal-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.18
            });

            revealElements.forEach(el => observer.observe(el));
        });
    </script>
</x-app-layout>
