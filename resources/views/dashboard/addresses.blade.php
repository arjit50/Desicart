<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Dashboard Sidebar Navigation -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-gauge-high"></i> Overview
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.orders') ? 'bg-emerald-600 text-white' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-receipt"></i> Order History
                    </a>
                    <a href="{{ route('dashboard.addresses') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.addresses') ? 'bg-emerald-600 text-white' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-location-dot"></i> Saved Addresses
                    </a>
                    <a href="{{ route('dashboard.wishlist') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('dashboard.wishlist') ? 'bg-emerald-600 text-white' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-heart"></i> My Wishlist
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ Route::is('profile.edit') ? 'bg-emerald-600 text-white' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-user-gear"></i> Profile Settings
                    </a>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="flex-grow space-y-8">
                
                <!-- Saved Points List -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h1 class="text-xl font-black text-slate-900 mb-2">Saved Addresses</h1>
                    <p class="text-sm text-slate-500 mb-6">Manage shipping locations and billing credentials.</p>

                    @if($addresses->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($addresses as $address)
                                <div class="border border-slate-200 rounded-2xl p-5 relative bg-slate-50 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-bold text-slate-700 capitalize">
                                                {{ $address->type }}
                                            </span>
                                            @if($address->is_default)
                                                <span class="inline-flex items-center rounded-full bg-emerald-500 px-2.5 py-0.5 text-[8px] font-extrabold uppercase tracking-wider text-white">Default</span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-slate-600 space-y-1">
                                            <p class="font-bold text-slate-800 text-sm mb-1">{{ $address->name }}</p>
                                            <p>{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p>{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                                            <p>{{ $address->country }}</p>
                                            <p class="font-semibold text-slate-500 mt-2"><i class="fa-solid fa-phone mr-1"></i> {{ $address->phone }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-4 border-t border-slate-200 flex justify-end">
                                        <form action="{{ route('dashboard.addresses.destroy', $address->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-600 hover:underline font-bold flex items-center gap-1">
                                                <i class="fa-regular fa-trash-can"></i> Delete Address
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 border border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-location-arrow text-slate-300 text-3xl mb-3 block"></i>
                            <p class="text-slate-500 text-sm">No saved locations in your address book yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Add Address Form -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-2">Create New Address</h2>
                    <p class="text-sm text-slate-500 mb-6">Input address details below to add a new shipping or billing location.</p>

                    <form action="{{ route('dashboard.addresses.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Address Type</label>
                                <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 font-medium">
                                    <option value="shipping">Shipping Address</option>
                                    <option value="billing">Billing Address</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Recipient Name</label>
                                <input type="text" name="name" required placeholder="John Doe" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Phone Number</label>
                                <input type="text" name="phone" required placeholder="123-456-7890" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- Address Line 1 -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Address Line 1</label>
                                <input type="text" name="address_line_1" required placeholder="123 Main St" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line_2" placeholder="Apt, Suite, Unit" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">City</label>
                                <input type="text" name="city" required placeholder="New York" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- State -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">State / Province</label>
                                <input type="text" name="state" required placeholder="NY" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- ZIP Code -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ZIP / Postal Code</label>
                                <input type="text" name="zip_code" required placeholder="10001" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- Country -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Country</label>
                                <input type="text" name="country" required placeholder="United States" 
                                       class="w-full bg-slate-50 border border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-3.5 py-2.5 text-sm" />
                            </div>

                            <!-- Default checkbox -->
                            <div class="flex items-center pt-6">
                                <label class="flex items-center space-x-2.5 cursor-pointer">
                                    <input type="checkbox" name="is_default" value="1" 
                                           class="w-4.5 h-4.5 text-emerald-600 border-slate-300 focus:ring-emerald-500/20 rounded" />
                                    <span class="text-sm text-slate-650 font-semibold">Set as default address</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="bg-slate-900 hover:bg-emerald-600 text-white font-bold py-3.5 px-8 rounded-full shadow-md transition-colors text-sm">
                            Add Address
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
