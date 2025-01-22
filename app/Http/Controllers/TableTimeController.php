<?php

namespace App\Http\Controllers;

use App\Models\TableTime;
use Illuminate\Http\Request;

class TableTimeController extends Controller
{
    public function index()
    {
        $tableTimes = TableTime::with(['staff', 'table'])->get();
        return response()->json($tableTimes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'table_id' => 'required|exists:tables,id',
            'time_start' => 'required|time',
            'time_end' => 'required|time',
        ]);

        $tableTime = TableTime::create($validated);
        return response()->json($tableTime);
    }

    public function show($id)
    {
        $tableTime = TableTime::with(['staff', 'table'])->findOrFail($id);
        return response()->json($tableTime);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'staff_id' => 'sometimes|required|exists:users,id',
            'table_id' => 'sometimes|required|exists:tables,id',
            'time_start' => 'nullable|time',
            'time_end' => 'nullable|time',
        ]);

        $tableTime = TableTime::findOrFail($id);
        $tableTime->update($validated);
        return response()->json($tableTime);
    }

    public function destroy($id)
    {
        TableTime::destroy($id);
        return response()->json(['message' => 'TableTime deleted']);
    }
}
