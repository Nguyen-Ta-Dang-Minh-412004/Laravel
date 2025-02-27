<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Hiển thị danh sách nhân viên.
     */
    public function index()
    {
        $staffs = Staff::all();
        return response()->json($staffs);
    }

    /**
     * Lưu thông tin nhân viên mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'time_working' => 'required|integer',
            'position' => 'required|exists:positions,id',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
        ]);

        $staff = Staff::create($request->all());

        return response()->json($staff, 201);
    }

    /**
     * Hiển thị thông tin một nhân viên cụ thể.
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return response()->json($staff);
    }

    /**
     * Cập nhật thông tin nhân viên.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string',
            'time_working' => 'sometimes|integer',
            'position' => 'sometimes|exists:positions,id',
            'gender' => 'sometimes|in:male,female',
            'address' => 'nullable|string',
        ]);

        $staff->update($request->all());

        return response()->json($staff);
    }

    /**
     * Xóa nhân viên.
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return response()->json(['message' => 'Xóa nhân viên thành công']);
    }
}
