<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        return response()->json(Position::all(), 200);
    }

    public function show($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Không tìm thấy vị trí'], 404);
        }
        return response()->json($position, 200);
    }

    // Thêm bản ghi mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'type_salary' => 'required|in:QuanLy,NhanVien',
            'salary' => 'nullable|numeric',
        ]);

        $position = Position::create($data);
        return response()->json($position, 201);
    }

    // Cập nhật bản ghi
    public function update(Request $request, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Không tìm thấy vị trí'], 404);
        }

        $data = $request->validate([
            'type_salary' => 'in:QuanLy,NhanVien',
            'salary' => 'numeric',
        ]);

        $position->update($data);
        return response()->json($position, 200);
    }

    // Xóa bản ghi
    public function destroy($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Không tìm thấy vị trí'], 404);
        }

        $position->delete();
        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
