<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BillController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TableTimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PositionController;

Route::prefix('position')->group(function () {
    Route::get('/all', [PositionController::class, 'index']);             // Lấy danh sách chức vụ
    Route::get('/findId/{id}', [PositionController::class, 'show']);      // Lấy chi tiết chức vụ
    Route::post('/create', [PositionController::class, 'store']);        // Tạo mới chức vụ
    Route::put('/update/{id}', [PositionController::class, 'update']);    // Cập nhật chức vụ
    Route::delete('/delete/{id}', [PositionController::class, 'destroy']); // Xóa chức vụ
});

// API Routes cho users
Route::prefix('users')->group(function () {
    Route::get('/all', [UserController::class, 'index']);              // Lấy danh sách người dùng
    Route::get('/findId/{id}', [UserController::class, 'show']);        // Lấy chi tiết người dùng
    Route::post('/create', [UserController::class, 'store']);          // Tạo mới người dùng
    Route::put('/update/{id}', [UserController::class, 'update']);      // Cập nhật thông tin người dùng
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);  // Xóa người dùng
});

// API Routes cho tables
Route::prefix('tables')->group(function () {
    Route::get('/all', [TableController::class, 'index']);             // Lấy danh sách bàn
    Route::get('/findId/{id}', [TableController::class, 'show']);      // Lấy chi tiết bàn
    Route::post('/create', [TableController::class, 'store']);        // Tạo mới bàn
    Route::put('/update/{id}', [TableController::class, 'update']);    // Cập nhật thông tin bàn
    Route::delete('/delete/{id}', [TableController::class, 'destroy']); // Xóa bàn
    Route::get('/findByArea/{area_id}', [TableController::class, 'findByArea']); // Tìm bàn theo khu vực
});


// API Routes cho players
Route::prefix('players')->group(function () {
    Route::get('/all', [PlayerController::class, 'index']);             // Lấy danh sách người chơi
    Route::get('/findId/{id}', [PlayerController::class, 'show']);      // Lấy chi tiết người chơi
    Route::post('/create', [PlayerController::class, 'store']);        // Tạo mới người chơi
    Route::put('/update/{id}', [PlayerController::class, 'update']);    // Cập nhật thông tin người chơi
    Route::delete('/delete/{id}', [PlayerController::class, 'destroy']); // Xóa người chơi
});

// API Routes cho orders
Route::prefix('orders')->group(function () {
    Route::get('/all', [OrderController::class, 'index']);             // Lấy danh sách đơn hàng
    Route::get('/findId/{id}', [OrderController::class, 'show']);      // Lấy chi tiết đơn hàng
    Route::post('/create', [OrderController::class, 'store']);        // Tạo mới đơn hàng
    Route::put('/update/{id}', [OrderController::class, 'update']);    // Cập nhật thông tin đơn hàng
    Route::delete('/delete/{id}', [OrderController::class, 'destroy']); // Xóa đơn hàng
});

// API Routes cho items
Route::prefix('items')->group(function () {
    Route::get('/all', [ItemController::class, 'index']);             // Lấy danh sách món ăn
    Route::get('/findId/{id}', [ItemController::class, 'show']);      // Lấy chi tiết món ăn
    Route::get('/findFood', [ItemController::class, 'findFood']);      // Lấy chi tiết món ăn
    Route::get('/findDrink', [ItemController::class, 'findDrink']);      // Lấy chi tiết đò uống
    Route::post('/create', [ItemController::class, 'store']);        // Tạo mới món ăn
    Route::put('/update/{id}', [ItemController::class, 'update']);    // Cập nhật thông tin món ăn
    Route::delete('/delete/{id}', [ItemController::class, 'destroy']); // Xóa món ăn
});

// API Routes cho bills
Route::prefix('bills')->group(function () {
    Route::get('/all', [BillController::class, 'index']);             // Lấy danh sách hóa đơn
    Route::get('/findId/{id}', [BillController::class, 'show']);      // Lấy chi tiết hóa đơn
    Route::get('/billToday', [BillController::class, 'allBillToday']); // Lấy tổng tiền hôm nay
    Route::get('/billYesterday', [BillController::class, 'allBillYesterday']); // Lấy tổng tiền hôm qua
    Route::get('/revernue', [BillController::class, 'calculateHourlyRevenue']); // Lấy trung bình tiền trong 8h gần nhất
    Route::post('/create', [BillController::class, 'store']);        // Tạo mới hóa đơn
    Route::put('/update/{id}', [BillController::class, 'update']);    // Cập nhật thông tin hóa đơn
    Route::delete('/delete/{id}', [BillController::class, 'destroy']); // Xóa hóa đơn
    Route::get('/findByDate', [BillController::class, 'findByDate']); // Tìm hóa đơn theo ngày
});

// API Routes cho order_items
Route::prefix('order-items')->group(function () {
    Route::get('/all', [OrderItemController::class, 'index']);             // Lấy danh sách món trong đơn hàng
    Route::get('/findId/{id}', [OrderItemController::class, 'show']);      // Lấy chi tiết món trong đơn hàng
    Route::post('/create', [OrderItemController::class, 'store']);        // Tạo mới món trong đơn hàng
    Route::put('/update/{id}', [OrderItemController::class, 'update']);    // Cập nhật món trong đơn hàng
    Route::delete('/delete/{id}', [OrderItemController::class, 'destroy']); // Xóa món trong đơn hàng
});

// API Routes cho table_times
Route::prefix('table-times')->group(function () {
    Route::get('/all', [TableTimeController::class, 'index']);             // Lấy danh sách thời gian bàn
    Route::get('/findId/{id}', [TableTimeController::class, 'show']);      // Lấy chi tiết thời gian bàn
    Route::post('/create', [TableTimeController::class, 'store']);        // Tạo mới thời gian bàn
    Route::put('/update/{id}', [TableTimeController::class, 'update']);    // Cập nhật thời gian bàn
    Route::delete('/delete/{id}', [TableTimeController::class, 'destroy']); // Xóa thời gian bàn
    Route::get('/findTable/{id}', [TableTimeController::class, 'findByTable']); // Lấy danh sách bàn
    Route::post('/pay/{id}', [TableTimeController::class, 'pay']);                    //Thanh toán tiền bàn hiện tại
    Route::post('/updateStatus', [TableTimeController::class, 'updateTableStatus']); //Update status của table theo id
});

Route::prefix('staff')->group(function () {
    Route::get('/all', [StaffController::class, 'index']);             // Lấy danh sách nhân viên
    Route::get('/findId/{id}', [StaffController::class, 'show']);      // Lấy chi tiết nhân viên
    Route::post('/create', [StaffController::class, 'store']);        // Tạo mới nhân viên
    Route::put('/update/{id}', [StaffController::class, 'update']);    // Cập nhật nhân viên
    Route::delete('/delete/{id}', [StaffController::class, 'destroy']); // Xóa nhân viên
});
