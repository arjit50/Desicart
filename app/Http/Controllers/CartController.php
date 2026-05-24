<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    private function getSessionId(Request $request): string
    {
        if (!$request->session()->has('cart_session_id')) {
            $request->session()->put('cart_session_id', session_id() ?: bin2hex(random_bytes(16)));
        }
        return $request->session()->get('cart_session_id');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId($request);

        $cart = $this->cartService->getCart($userId, $sessionId);

        return view('cart.index', [
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId($request);

        $result = $this->cartService->addItemToCart(
            $userId,
            $sessionId,
            $request->product_id,
            $request->quantity
        );

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('cart.index')->with('success', $result['message']);
    }

    public function update(Request $request, int $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId($request);

        $result = $this->cartService->updateQuantity(
            $userId,
            $sessionId,
            $productId,
            $request->quantity
        );

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('cart.index')->with('success', $result['message']);
    }

    public function destroy(Request $request, int $productId)
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId($request);

        $deleted = $this->cartService->removeItemFromCart($userId, $sessionId, $productId);

        if ($request->wantsJson()) {
            return response()->json(['success' => $deleted]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function toggleSaveForLater(Request $request, int $productId)
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId($request);

        $this->cartService->toggleSaveForLater($userId, $sessionId, $productId);

        return redirect()->route('cart.index')->with('success', 'Cart item status updated.');
    }
}
