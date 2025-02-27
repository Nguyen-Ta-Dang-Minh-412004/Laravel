<?php

namespace App\Http\Controllers;

use App\Models\TableTime;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'staff_id'   => 'required|exists:staff,id', 
            'table_id'   => 'required|exists:tables,id',
            'time_start' => 'required|date_format:H:i:s',
            'time_end'   => 'required|date_format:H:i:s|after:time_start', 
            'date'       => 'required|date_format:Y-m-d',
        ]);

        $conflicts = TableTime::where('table_id', $validated['table_id'])
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->whereBetween('time_start', [$validated['time_start'], $validated['time_end']])
                      ->orWhereBetween('time_end', [$validated['time_start'], $validated['time_end']]);
                })
                ->orWhere(function ($q) use ($validated) {
                    $q->where('time_start', '<', $validated['time_start'])
                      ->where('time_end', '>', $validated['time_end']);
                });
            })
            ->exists();

        if ($conflicts) {
            return response()->json(['error' => 'Thời gian bị trùng với khoảng thời gian đã có.'], 400);
        }

        // Lưu dữ liệu
        $tableTime = TableTime::create($validated);
        $this->updateTableStatus($validated['table_id'], $validated['date']);

        return response()->json($tableTime, 200);
    }

    public function show($id)
    {
        $tableTime = TableTime::with(['staff', 'table'])->findOrFail($id);
        return response()->json($tableTime);
    }

    public function update(Request $request, $id)
    {
        $tableTime = TableTime::findOrFail($id);

        $validated = $request->validate([
            'staff_id'   => 'sometimes|required|exists:staff,id',
            'table_id'   => 'sometimes|required|exists:tables,id',
            'time_start' => 'sometimes|required|date_format:H:i:s',
            'time_end'   => 'sometimes|required|date_format:H:i:s|after:time_start',
            'date'       => 'sometimes|required|date_format:Y-m-d',
        ]);

        // Nếu có cập nhật time_start hoặc time_end, cần kiểm tra trùng lịch
        if (isset($validated['time_start']) || isset($validated['time_end']) || isset($validated['date'])) {
            $date = $validated['date'] ?? $tableTime->date;
            $timeStart = $validated['time_start'] ?? $tableTime->time_start;
            $timeEnd = $validated['time_end'] ?? $tableTime->time_end;

            $conflicts = TableTime::where('table_id', $validated['table_id'] ?? $tableTime->table_id)
                ->where('date', $date)
                ->where('id', '!=', $id) // Loại bỏ bản ghi hiện tại
                ->where(function ($query) use ($timeStart, $timeEnd) {
                    $query->whereBetween('time_start', [$timeStart, $timeEnd])
                          ->orWhereBetween('time_end', [$timeStart, $timeEnd])
                          ->orWhere(function ($q) use ($timeStart, $timeEnd) {
                              $q->where('time_start', '<', $timeStart)
                                ->where('time_end', '>', $timeEnd);
                          });
                })
                ->exists();

            if ($conflicts) {
                return response()->json(['error' => 'Thời gian bị trùng với khoảng thời gian đã có.'], 400);
            }
        }

        $tableTime->update($validated);
        $this->updateTableStatus($tableTime->table_id, $tableTime->date);

        return response()->json($tableTime);
    }

    public function destroy($id)
    {
        $tableTime = TableTime::findOrFail($id);
        $date = $tableTime->date;
        $tableTime->delete();

        $this->updateTableStatus($tableTime->table_id, $date);

        return response()->json(['message' => 'TableTime deleted'], 204);
    }
    
    public function findByTable($id)
    {
        return TableTime::where('table_id', $id)->get();
    }
    public function updateTableStatus($tableId = null, $date = null)
    {
        $currentTime = Carbon::now();
        
        if ($tableId) {
            // Cập nhật cho một bàn cụ thể
            $tables = Table::where('id', $tableId)->get();
        } else {
            // Cập nhật cho tất cả các bàn
            $tables = Table::all();
        }

        foreach ($tables as $table) {
            // Lấy danh sách thời gian đặt bàn theo thứ tự thời gian bắt đầu
            $activeTimes = TableTime::where('table_id', $table->id)
                ->when($date, function($query) use ($date) {
                    return $query->where('date', $date);
                })
                ->orderBy('date')
                ->orderBy('time_start')
                ->get();

            // Nếu bàn bị hỏng thì giữ nguyên trạng thái
            if ($table->status === 'broken') {
                continue; // Bỏ qua bàn này
            }

            $isUpdatedToUse = false;
            $hasUpcomingBooking = false;

            foreach ($activeTimes as $time) {
                $timeStart = Carbon::createFromFormat('Y-m-d H:i:s', "{$time->date} {$time->time_start}");
                $timeEnd = $time->time_end
                    ? Carbon::createFromFormat('Y-m-d H:i:s', "{$time->date} {$time->time_end}")
                    : null;

                if ($timeEnd && $timeEnd->lessThan($timeStart)) {
                    $timeEnd->addDay();
                }

                // Kiểm tra nếu bàn đang trong khoảng thời gian sử dụng
                if (!$isUpdatedToUse && $currentTime->between($timeStart, $timeEnd)) {
                    $table->status = 'use';
                    $isUpdatedToUse = true;
                    break; // Thoát khỏi vòng lặp khi đã cập nhật trạng thái
                }

                // Kiểm tra nếu có lịch đặt trong tương lai
                if ($currentTime->lessThan($timeStart)) {
                    $hasUpcomingBooking = true;
                }
            }

            if (!$isUpdatedToUse) {
                if ($hasUpcomingBooking) {
                    $table->status = 'booked';
                } else {
                    $table->status = 'empty';
                }
            }

            // Lưu trạng thái mới
            $table->save();
        }

        return response()->json(['message' => 'Table statuses updated']);
    }
    public function pay($id)
    {
        $localTime = Carbon::now();
    
        // Lấy danh sách thời gian của bàn theo thứ tự gần hiện tại nhất
        $tableTimes = TableTime::where('table_id', $id)
            ->whereHas('table', function ($query) {
                $query->where('status', 'use');
            })
            ->orderBy('time_start', 'desc')
            ->get();
    
        // Kiểm tra nếu không có dữ liệu
        if ($tableTimes->isEmpty()) {
            return response()->json(['error' => 'Không tìm thấy bàn đang sử dụng.'], 400);
        }
    
        $activeTime = null;
    
        // Duyệt danh sách TableTime để tìm bản ghi hợp lệ
        foreach ($tableTimes as $time) {
            $timeStart = Carbon::parse("{$time->date} {$time->time_start}");
            $timeEnd = $time->time_end ? Carbon::parse("{$time->date} {$time->time_end}") : $localTime;
    
            // Nếu time_end nhỏ hơn time_start (qua ngày hôm sau), cộng thêm 1 ngày
            if ($timeEnd->lessThan($timeStart)) {
                $timeEnd->addDay();
            }
    
            if ($timeStart->lessThanOrEqualTo($localTime) && $timeEnd->greaterThanOrEqualTo($localTime)) {
                $activeTime = $time;
                break; // Dừng khi tìm thấy bản ghi đúng
            }
        }
    
        // Nếu không tìm thấy thời gian hợp lệ
        if (!$activeTime) {
            return response()->json(['error' => 'Không tìm thấy bàn đang sử dụng.'], 400);
        }
    
        // Tính thời gian sử dụng
        $timeStart = Carbon::parse("{$activeTime->date} {$activeTime->time_start}");
        $totalMinutes = $timeStart->diffInMinutes($localTime);
    
        // Làm tròn thành giờ
        $hours = ($totalMinutes / 60);
        if ($totalMinutes % 60 >= 30) {
            $hours += 1;
        }
    
        // Tính tiền
        $table = $activeTime->table;
        $pricePerHour = $table->price;
        $totalPrice = $hours * $pricePerHour;
    
        // Cập nhật trạng thái bàn và thời gian kết thúc
        $activeTime->time_end = $localTime;
    
        // Lưu vào database
        $table->save();
        $activeTime->save();
        $this->updateTableStatus($id);

        return response()->json([
            'message' => 'Thanh toán thành công.',
            'time_used' => $totalMinutes,
            'total_price' => round($totalPrice, 2),
        ]);
    }

    public function resetTableTime()
    {
        $today = Carbon::today()->toDateString();
        $tableTimes = TableTime::all();
    
        foreach ($tableTimes as $time) {
            $conflictingTime = TableTime::where('table_id', $time->table_id)
                ->where('id', '!=', $time->id)
                ->where('date', $today)
                ->where(function ($query) use ($time) {
                    $query->whereBetween('time_start', [$time->time_start, $time->time_end])
                          ->orWhereBetween('time_end', [$time->time_start, $time->time_end])
                          ->orWhere(function ($q) use ($time) {
                              $q->where('time_start', '<', $time->time_start)
                                ->where('time_end', '>', $time->time_end);
                          });
                })->first();
    
            if ($conflictingTime) {
                $time->delete();
            } else {
                $time->date = $today;
                $time->save();
            }
        }
    
        return response()->json(['message' => 'Reset TableTime successfully']);
    }
}
