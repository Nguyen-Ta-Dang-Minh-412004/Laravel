<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return response()->json($tables);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|integer',
            'statust' => 'required|in:empty,booked,use,broken',
            'price' => 'nullable|integer',
            'area' => 'nullable|integer',
        ]);

        $table = Table::create($validated);
        return response()->json($table);
    }

    public function show($id)
    {
        $table = Table::findOrFail($id);
        return response()->json($table);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'table_number' => 'sometimes|required|integer',
            'statust' => 'sometimes|required|in:empty,booked,use,broken',
            'price' => 'nullable|integer',
            'area' => 'nullable|integer',
        ]);

        $table = Table::findOrFail($id);
        $table->update($validated);
        return response()->json($table);
    }

    public function destroy($id)
    {
        Table::destroy($id);
        return response()->json(['message' => 'Table deleted']);
    }
}
