<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy giá sản phẩm
        $item = Item::findOrFail($validated['item_id']);
        $totalPrice = $item->price * $validated['quantity'];
        $now = Carbon::now();

        $orderItem = OrderItem::create([
            'table_id' => $validated['table_id'],
            'item_id' => $validated['item_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'time' => $now
        ]);

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
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        $orderItem = OrderItem::findOrFail($id);

        if (isset($validated['item_id'])) {
            $item = Item::findOrFail($validated['item_id']);
            $validated['total_price'] = $item->price * ($validated['quantity'] ?? $orderItem->quantity);
        } elseif (isset($validated['quantity'])) {
            $validated['total_price'] = $orderItem->item->price * $validated['quantity'];
        }

        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    public function destroy($id)
    {
        OrderItem::destroy($id);
        return response()->json(['message' => 'OrderItem deleted']);
    }
}