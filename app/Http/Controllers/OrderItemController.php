<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['table', 'item'])->get();
        return response()->json($orderItems);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'nullable|integer',
            'total_price' => 'nullable|integer',
        ]);

        $orderItem = OrderItem::create($validated);
        return response()->json($orderItem);
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['table', 'item'])->findOrFail($id);
        return response()->json($orderItem);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'table_id' => 'sometimes|required|exists:tables,id',
            'item_id' => 'sometimes|required|exists:items,id',
            'quantity' => 'nullable|integer',
            'total_price' => 'nullable|integer',
        ]);

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    public function destroy($id)
    {
        OrderItem::destroy($id);
        return response()->json(['message' => 'OrderItem deleted']);
    }
}
