<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        $addressCount = Address::where('user_id', $userId)->count();

        return view('dashboard.index', [
            'orders' => $orders,
            'wishlistCount' => $wishlistCount,
            'addressCount' => $addressCount
        ]);
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('dashboard.orders', [
            'orders' => $orders
        ]);
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('dashboard.addresses', [
            'addresses' => $addresses
        ]);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean'
        ]);

        $userId = Auth::id();
        $isDefault = $request->has('is_default');

        if ($isDefault) {
            Address::where('user_id', $userId)->where('type', $request->type)->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => $userId,
            'type' => $request->type,
            'name' => $request->name,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'is_default' => $isDefault
        ]);

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function destroyAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }

    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with(['product.images'])
            ->paginate(9);

        return view('dashboard.wishlist', [
            'wishlistItems' => $wishlist
        ]);
    }

    public function toggleWishlist(Request $request, int $productId)
    {
        $userId = Auth::id();
        if (!$userId) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Please login to manage your wishlist.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to manage your wishlist.');
        }

        $wishlist = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            $added = false;
            $message = 'Product removed from wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $added = true;
            $message = 'Product added to wishlist.';
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'added' => $added, 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    }
}
