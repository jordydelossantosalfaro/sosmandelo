<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::with('images')->whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                $quantity = $cart[$product->id];
                $price = $product->promotional_price ?? $product->price;
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Validate product exists
        $product = Product::findOrFail($productId);

        // Get cart from session
        $cart = Session::get('cart', []);

        // Add or update product quantity
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // Update cart in session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Update cart quantity
     */
    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Get cart from session
        $cart = Session::get('cart', []);

        // Update quantity
        if ($quantity > 0) {
            $cart[$productId] = $quantity;
        } else {
            unset($cart[$productId]);
        }

        // Update cart in session
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado.');
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart($productId)
    {
        // Get cart from session
        $cart = Session::get('cart', []);

        // Remove product
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        // Update cart in session
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Clear cart
     */
    public function clearCart()
    {
        // Clear cart in session
        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        // Redirect if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        $cartItems = [];
        $total = 0;

        $productIds = array_keys($cart);
        $products = Product::with('images')->whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $price = $product->promotional_price ?? $product->price;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ];
        }

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    /**
     * Process order
     */
    public function processOrder(Request $request)
    {
        $cart = Session::get('cart', []);

        // Validate if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        // Validate form data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'customer_email' => 'nullable|email|max:255',
            'terms_accepted' => 'required|accepted',
            'invoice_required' => 'boolean',
            'invoice_ruc' => 'required_if:invoice_required,1|nullable|string|max:20',
            'invoice_business_name' => 'required_if:invoice_required,1|nullable|string|max:255',
            'invoice_address' => 'required_if:invoice_required,1|nullable|string|max:500',
            'payment_type' => 'required|in:cash,digital,card,transfer',
            'notes' => 'nullable|string|max:500',
        ]);

        // Calculate order total
        $cartItems = [];
        $total = 0;

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $price = $product->promotional_price ?? $product->price;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ];
        }

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'delivery_address' => $validated['delivery_address'],
            'customer_email' => $validated['customer_email'] ?? null,
            'terms_accepted' => true, // Si llegamos aquí, los términos fueron aceptados
            'invoice_required' => $request->has('invoice_required'),
            'invoice_ruc' => $validated['invoice_ruc'] ?? null,
            'invoice_business_name' => $validated['invoice_business_name'] ?? null,
            'invoice_address' => $validated['invoice_address'] ?? null,
            'total_amount' => $total,
            'status' => 'received',
            'order_type' => 'standard',
            'invoice_status' => 'pending',
            'payment_status' => 'pending',
            'payment_type' => $validated['payment_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['subtotal'],
            ]);
        }

        // Clear cart
        Session::forget('cart');

        // Store order ID in session for confirmation page
        Session::put('last_order_id', $order->id);

        return redirect()->route('cart.confirmation');
    }

    /**
     * Display confirmation page
     */
    public function confirmation()
    {
        $orderId = Session::get('last_order_id');

        if (!$orderId) {
            return redirect()->route('catalogo.index');
        }

        $order = Order::with('orderItems.product')->findOrFail($orderId);

        return view('cart.confirmation', compact('order'));
    }
}
