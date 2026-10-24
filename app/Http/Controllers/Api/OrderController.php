<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan seluruh pesanan (untuk dashboard admin).
     */
    public function index()
    {
        $orders = Order::latest()->get();

        return OrderResource::collection($orders);
    }

    /**
     * Simpan pesanan baru dari transaksi checkout pelanggan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:150',
            'email'  => 'required|email|max:150',
            'method' => 'required|string|max:50',
            'total'  => 'required|numeric|min:0',
            'items'  => 'required|array',
        ]);

        $orderId = 'JPR-' . substr(time() . mt_rand(100, 999), -6);

        $order = Order::create([
            'id'     => $orderId,
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'method' => $validated['method'],
            'total'  => $validated['total'],
            'status' => 'Pending',
            'items'  => $validated['items'],
        ]);

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Memperbarui status pesanan (Pending, Diproses, Selesai).
     */
    public function updateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return new OrderResource($order);
    }
}
