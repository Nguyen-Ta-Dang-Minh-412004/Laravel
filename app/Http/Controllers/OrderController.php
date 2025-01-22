<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['player', 'table'])->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'table_id' => 'required|exists:tables,id',
            'order_date' => 'required|date',
            'start_time' => 'required|time',
            'end_time' => 'required|time',
            'total_price' => 'nullable|integer',
        ]);

        $order = Order::create($validated);
        return response()->json($order);
    }

    public function show($id)
    {
        $order = Order::with(['player', 'table'])->findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'player_id' => 'sometimes|required|exists:players,id',
            'table_id' => 'sometimes|required|exists:tables,id',
            'order_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required|time',
            'end_time' => 'sometimes|required|time',
            'total_price' => 'nullable|integer',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);
        return response()->json($order);
    }

    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Order deleted']);
    }
}
