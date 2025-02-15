<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('staff')->get();
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
        return response()->json($total);
    }

    // Tính tổng tiền hóa đơn ngày hôm qua
    public function allBillYesterday()
    {
        $yesterday = Carbon::yesterday();
        $total = Bill::whereDate('date_pay', $yesterday)->sum('total_money');
        return response()->json($total);
    }

    // Tính doanh thu theo giờ trong vòng 8 giờ gần nhất
    public function calculateHourlyRevenue()
    {
        $now = Carbon::now();
        $hourlyRevenue = [];

        for ($i = 7; $i >= 0; $i--) {
            $startTime = $now->copy()->subHours($i + 1)->startOfHour(); // Bắt đầu của giờ
            $endTime = $now->copy()->subHours($i)->startOfHour(); // Kết thúc của giờ

            // Tính tổng doanh thu trong khoảng thời gian đó
            $totalMoney = Bill::whereDate('time', Carbon::today())
                ->whereBetween('time', [$startTime, $endTime])
                ->sum('total_money');

            // Thêm vào mảng
            $hourlyRevenue[] = [
                'hour' => $startTime->format('H:i') . ' - ' . $endTime->format('H:i'),
                'revenue' => $totalMoney
            ];
        }

        return response()->json([
            'date' => Carbon::today()->format('Y-m-d'),
            'hourly_revenue' => $hourlyRevenue
        ]);
    } 
    public function findByDate(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $bills = Bill::whereDate('date_pay', $validated['date'])->with('staff')->get();
        return response()->json($bills);
    }
}
