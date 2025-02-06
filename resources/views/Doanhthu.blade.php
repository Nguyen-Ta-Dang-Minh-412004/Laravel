<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billar web</title>
    <link rel="stylesheet" href="{{ asset('css/Doanhthu.css')}}">
    <link rel="stylesheet" href="{{ asset('../fontawesome/fontawesome-free-6.5.2-web/css/all.css')}}">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   
</head>
<body>
<header>
    <div class="head1">
        <div class="icon">
            <a href="">
                <i class="fa-solid fa-compact-disc"></i>
                <h2>Billiard Web</h2>
            </a>
        </div>
        <div class="head_conten">
            <div class="borrow">
                <a href="">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <p>Vay vốn</p>
                </a>
            </div>
            <div class="borrow">
                <a href="">
                    <i class="fa-solid fa-palette"></i>
                    <p>Chủ đề</p>
                </a>
            </div>
            <div class="borrow">
                <a href="">
                    <i class="fa-regular fa-comment-dots"></i>
                    <p>Hỗ trợ</p>
                </a>
            </div>
            <div class="borrow">
                <a href="">
                    <i class="fa-solid fa-location-dot"></i>
                    <p>Địa chỉ chi nhánh</p>
                </a>
            </div>
            <div class="borrow">
                <a href="">
                    <p>Tiếng Việt</p>
                    <i class="fa-solid fa-caret-down" style="color: black; margin-left: 10px;"></i>
                </a>
            </div>
            <a href=""><i class="fa-regular fa-envelope"></i></a>
            <i class="fa-solid fa-gear"></i>
            <p id="User_Name"></p>
            <i id="LogIn" class="fa-regular fa-circle-user" style="cursor: pointer;"></i>
        </div>
        <div class="LogInClient">
            <div class="icon">
                <span class="close">&times;</span>
                <a href="">
                    <i class="fa-solid fa-compact-disc"></i>
                    <h2>Billiard Web</h2>
                </a>
                <form>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username"><br><br>
                    <label for="password" style="margin-right: 4px;">Password:</label>
                    <input type="password" id="password" name="password"><br><br>
                    <button id="Submit" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

    <div class="head2">
        <div class="contents">
            <div class="view">
                <a href="">
                    <i class="fa-solid fa-eye"></i>
                    <p>Tổng quan</p>
                </a>
            </div>
            <div class="view">
                <a href="">
                    <i class="fa-solid fa-box"></i>
                    <p>Hàng hóa</p>
                </a>
            </div>
            <div class="view">
                <a href="../html/trangchu.html">
                    <i class="fa-solid fa-table"></i>
                    <p>Phòng bàn</p>
                </a>
            </div>
            <div class="view">
                <a href="">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    <p>Giao dịch</p>
                </a>
            </div>
            <div class="view">
                <a href="">
                    <i class="fa-solid fa-people-group"></i>
                    <p>Nhân viên</p>
                </a>
            </div>
            <div class="view">
                <a href="">
                    <i class="fa-solid fa-store"></i>
                    <p>Hàng online</p>
                </a>
            </div>
            <div class="view">
                <a href="">
                    <i class="fa-regular fa-clipboard"></i>
                    <p>Báo cáo</p>
                </a>
            </div>
        </div>
        <div class="service">
            <i class="fa-solid fa-bell-concierge"></i>
            <i class="fa-solid fa-calendar-check"></i>
            <i class="fa-regular fa-envelope"></i>
        </div>
    </div>
</header>
<main>
    <div class="main_left">
        <div class="sales-results">
            <h2>KẾT QUẢ BÁN HÀNG HÔM NAY</h2>
            <div class="result-container">
                <div class="result-item">
                    <div class="item red"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="text">
                        <h3 id="orderCount"></h3>
                        <p class="amount">
                            <span class="percentage down">
                                <i class="fa-solid fa-arrow-down"></i> <span id="moneyToday">62%</span>
                            </span>
                        </p>
                        <p class="previous">Hôm qua <span id="moneyYesterday"></span></p>
                    </div>
                </div>

                <div class="result-item">
                    <div class="item green"><i class="fa-solid fa-file-pen"></i></div>
                    <div class="text">
                        <h3>0 đơn đang phục vụ</h3>
                        <p class="amount">0</p>
                    </div>
                </div>
                <div class="result-item" style="border: unset;">
                    <div class="item teal"><i class="fa-solid fa-user-pen"></i></div>
                    <div class="text">
                        <h3>Khách hàng</h3>
                        <p class="amount">15 <span class="percentage up"><i class="fa-solid fa-arrow-up"></i> 36%</span></p>
                        <p class="previous">Hôm qua 11</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">
                <h2>DOANH SỐ HÔM NAY</h2>
                <i class="fa-solid fa-comment-dollar"></i>
                <p id="total-money-today">10,000,000 VND</p>
                <span>
            Hôm nay
            <i class="fa-solid fa-chevron-down"></i>
        </span>
            </div>
            <div class="daily">
                <p class="daily-option selected">Theo ngày</p>
                <p class="daily-option">Theo giờ</p>
                <p class="daily-option">Theo thứ</p>
            </div>
            <div class="chart">
                <div class="y-axis">
                    <!-- Nhãn sẽ được cập nhật qua JavaScript -->
                </div>
                <div class="x-axis" id="hourly-chart">
                    <!-- Các thanh sẽ được cập nhật thông qua JavaScript -->
                </div>
            </div>
        </div>




    </div>
    <div class="main_right">
        <h2>CÁC HOẠT ĐỘNG GẦN ĐÂY</h2>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
        <div class="active">
            <div class="sell"><i class="fa-solid fa-bell-concierge"></i></div>
            <div class="make">
                <p>Hoàng - Phạt tiền <span>vừa</span> đánh khách hàng <span>bằng gậy</span> <span class="price"> phạt 164,000</span>
                    <span class="time">an hour ago</span>
            </div>
        </div>
    </div>
</main>
<footer>

</footer>
</body>
</html>