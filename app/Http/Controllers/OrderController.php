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
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s',
        ]);

        // Tính toán tổng tiền nếu có thời gian kết thúc
        $startTime = strtotime($validated['start_time']);
        $endTime = isset($validated['end_time']) ? strtotime($validated['end_time']) : null;
        $pricePerHour = Order::find($validated['table_id'])->table->price;

        $totalPrice = 0;
        if ($endTime) {
            $duration = ($endTime - $startTime) / 3600; // Đơn vị giờ
            $totalPrice = ceil($duration * $pricePerHour);
        }

        $order = Order::create(array_merge($validated, ['total_price' => $totalPrice]));
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
            'start_time' => 'sometimes|required|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        // Cập nhật lại tổng tiền nếu có thời gian kết thúc
        if (isset($validated['end_time'])) {
            $startTime = strtotime($order->start_time);
            $endTime = strtotime($validated['end_time']);
            $pricePerHour = $order->table->price;

            $duration = ($endTime - $startTime) / 3600; // Đơn vị giờ
            $order->total_price = ceil($duration * $pricePerHour);
            $order->save();
        }

        return response()->json($order);
    }

    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Order deleted']);
    }
}
