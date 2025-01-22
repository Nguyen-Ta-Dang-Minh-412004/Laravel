<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('user')->get();
        return response()->json($bills);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_money' => 'nullable|integer',
            'date_pay' => 'nullable|date',
            'time' => 'nullable|time',
        ]);

        $bill = Bill::create($validated);
        return response()->json($bill);
    }

    public function show($id)
    {
        $bill = Bill::with('user')->findOrFail($id);
        return response()->json($bill);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total_money' => 'nullable|integer',
            'date_pay' => 'nullable|date',
            'time' => 'nullable|time',
        ]);

        $bill = Bill::findOrFail($id);
        $bill->update($validated);
        return response()->json($bill);
    }

    public function destroy($id)
    {
        Bill::destroy($id);
        return response()->json(['message' => 'Bill deleted']);
    }
}
