<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'staff_id' => 'required|exists:staff,id',
            'total_money' => 'nullable|integer',
            'date_pay' => 'nullable|date',
            'time' => 'nullable',
        ]);

        $bill = Bill::create($validated);
        return response()->json($bill);
    }

    public function show($id)
    {
        $bill = Bill::with('staff')->findOrFail($id);
        return response()->json($bill);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'staff_id' => 'sometimes|required|exists:staff,id',
            'total_money' => 'nullable|integer',
            'date_pay' => 'nullable|date',
            'time' => 'nullable',
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

    // Tính tổng tiền hóa đơn trong ngày hôm nay
    public function allBillToday()
    {
        $today = Carbon::today();
        $total = Bill::whereDate('date_pay', $today)->sum('total_money');
        return response()->json(['total_money_today' => $total]);
    }

    // Tính tổng tiền hóa đơn ngày hôm qua
    public function allBillYesterday()
    {
        $yesterday = Carbon::yesterday();
        $total = Bill::whereDate('date_pay', $yesterday)->sum('total_money');
        return response()->json(['total_money_yesterday' => $total]);
    }

    // Tính doanh thu theo giờ trong vòng 8 giờ gần nhất
    public function calculateHourlyRevenue()
    {
        $now = Carbon::now();
        $startTime = $now->copy()->subHours(8)->startOfHour(); // Lấy mốc 8 giờ trước
        $endTime = $now->copy()->startOfHour(); // Lấy mốc giờ hiện tại
    
        $totalMoney = Bill::whereDate('time', Carbon::today()) // Chỉ lấy dữ liệu hôm nay
            ->whereBetween('time', [$startTime, $endTime]) // Lọc trong khoảng 8 giờ gần nhất
            ->sum('total_money');
    
        return response()->json([
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'revenue' => $totalMoney
        ]);
    }
    
}
