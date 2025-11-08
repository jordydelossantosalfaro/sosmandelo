<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::query()->with(['orderItems']);

        // Filtrar por estado
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Buscar por número de orden
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Ordenar
        $query->orderBy('created_at', 'desc');

        // Paginación
        $perPage = $request->get('per_page', 20);
        $orders = $query->paginate($perPage)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.product.images']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:received,confirmed,prepared,in_transit,delivered,rescheduled,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Estado de la orden actualizado correctamente.');
    }

    /**
     * Update the payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed',
        ]);

        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Estado de pago actualizado correctamente.');
    }

    /**
     * Update the invoice status.
     */
    public function updateInvoiceStatus(Request $request, Order $order)
    {
        $request->validate([
            'invoice_status' => 'required|in:pending,paid',
        ]);

        $order->invoice_status = $request->invoice_status;
        $order->save();

        return redirect()->back()->with('success', 'Estado de facturación actualizado correctamente.');
    }

    /**
     * Save notes for the order.
     */
    public function saveNotes(Request $request, Order $order)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $order->notes = $request->notes;
        $order->save();

        return redirect()->back()->with('success', 'Notas guardadas correctamente.');
    }
}
