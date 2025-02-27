<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../css/trangchu.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/all.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<div class="motherbox">
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
        </div>

        <div class="head2">
            <div class="contents">
                    <span class="view">
                        <a href="">
                            <i class="fa-solid fa-eye"></i>
                            <p>Tổng quan</p>
                        </a>
                    </span>
                <div class="view">
                    <a href="">
                        <i class="fa-solid fa-box"></i>
                        <p>Hàng hóa</p>
                    </a>
                </div>
                <div class="view">
                    <a href="">
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
                    <a href="" >
                        <i class="fa-regular fa-clipboard"></i>
                        <p class = "BaoCao">Báo cáo</p>
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

        <div class="content">
            <aside>
                <ul>
                    <li data-area="normal" >Phòng Thường</li>
                    <li data-area="smoke">Phòng Hút Thuốc</li>
                    <li data-area="vip">Phòng VIP</li>
                </ul>
            </aside>

            <div class="article-content" data-area="normal"></div>
            <div class="article-content" data-area="smoke"></div>
            <div class="article-content" data-area="vip"></div>


            <article>
                <div id="content-normal" class="article-content">
                    <div class="table-grid" id="normal-grid">

                    </div>
                </div>

                <div id="content-smoke" class="article-content">
                    <div class="table-grid" id="smoke-grid">
                        <!-- Phần tử mẫu sẽ được thêm bằng JavaScript -->
                    </div>
                </div>

                <div id="content-vip" class="article-content">
                    <div class="table-grid" id="vip-grid">
                        <!-- Phần tử mẫu sẽ được thêm bằng JavaScript -->
                    </div>
                </div>
            </article>
        </div>

    </main>
    <footer>
        <div class="footer-up">
            <div class="footer-up-left">
                <h4>Thông tin liên hệ:</h4>
                <p>SĐT: 0393 .xxx .xxx</p>
                <p>Email: ducnhatdeptrai@gmilk.com</p>
            </div>
            <div class="footer-up-mid">
                <h4>Chi nhánh:</h4>
                <p>Hà Nội</p>
                <p>Đà Nẵng</p>
                <p>HCM</p>
            </div>
            <div class="footer-up-right">
                <h4>Trang thông tin: </h4>
                <div class="info">
                    <div class="icon">
                        <img style="width: 7%;" src="../img/facebook-svgrepo-com.svg" alt="facebook">
                        <p>Facebook</p>
                    </div>
                    <div class="icon">
                        <img style="width: 7%;" src="../img/instagram-svgrepo-com.svg" alt="instagram">
                        <p>Instagram</p>
                    </div>
                    <div class="icon">
                        <img style="width: 7%;" src="../img/onlyfans-svgrepo-com.svg" alt="oF">
                        <p>Onlyfans</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-down">
            <p>2024 Quản lý Billiard. All Rights Reserved @@</p>
        </div>
    </footer>
</div>

<!-- Popup thông tin bàn -->
<div id="popupThongTin" class="dat-ban-popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup('popupThongTin')">&times;</span>
        <div class="thongTin">
            <h2 id="popup-title">Thông tin bàn</h2>
            <p id="popup-info">Thông tin bàn sẽ xuất hiện ở đây.</p>
        </div>
        <p id="amount-to-pay" style="display: none;">Số tiền cần thanh toán: 0 đồng</p>
        <div class="popup-buttons">
            <button id="book-table">Đặt bàn</button>
            <button id="pay">Thanh toán</button>
        </div>
    </div>
</div>

<!-- Popup thanh toán -->
<div id="paymentPopup" class="dat-ban-popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup('paymentPopup')">&times;</span>
        <h3>Thông tin thanh toán</h3>
        <div class="thongTin">
            <p>Mã bàn: <span id="tableId"></span></p>
            <p>Mã phòng: <span id="roomId"></span></p>
            <p>Tiền trên 1 giờ: <span id="pricePerHour"></span> VND</p>
            <p>Số thời gian chơi: <span id="timePlayed"></span></p>
            <p>Tổng tiền cần trả: <span id="totalPrice"></span> VND</p>
            <button id="confirmPayment">Xác nhận thanh toán</button>
        </div>
    </div>
</div>

<div id="dat-ban-popup" class="dat-ban-popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <h2>Đặt Bàn</h2>
        <div class="dat-ban-son">
            <div class="dat-ban-left">
                <div class="ten son">
                    <p>Tên khách hàng: </p>
                    <input type="text" id="ten-khach-hang" placeholder="Nhập tên khách hàng">
                </div>
                <div class="id-dat-ban son">
                    <p>Mã đặt bàn: </p>
                    <input type="text" id="ma-dat-ban" placeholder="Mã đặt bàn" disabled>
                </div>
                <div class="time-start son">
                    <p>Thời gian bắt đầu: </p>
                    <input type="time" id="thoi-gian-bat-dau">
                </div>
                <div class="thoi-luong son">
                    <p>Thời lượng: </p>
                    <input type="number" id="thoi-luong" placeholder="Nhập thời lượng">
                </div>
            </div>
            <div class="dat-ban-right">
                <div class="nhanvien son">
                    <p>Tên nhân viên: </p>
                    <input type="text" id="ten-nhan-vien" placeholder="minh-chan" disabled>
                </div>
                <div class="room-table son">
                    <p>Phòng bàn: </p>
                </div>
            </div>
        </div>
        <div class="dat-ban-button">
            <button>Thêm thông tin</button>
            <button>Hủy thông tin</button>
        </div>
    </div>
</div>

<!-- Popup window -->
<div id="order-popup" class="order-modal">
    <div class="order-modal-content">
        <div class="popup-header">
            <h2>Đặt món</h2>
            <div class="header-right">
                <span class="close">&times;</span>
            </div>
        </div>
        <div class="popup-sections">
            <div class="section food-section">
                <h3>Đồ ăn</h3>
                <div class="item">
                    <label for="mon-an">Món:</label>
                    <select id="mon-an">
                        <option value="">Chọn món</option>
                        <option value="mon1">Món 1</option>
                        <option value="mon2">Món 2</option>
                        <option value="mon3">Món 3</option>
                    </select>
                </div>
                <div class="item">
                    <label for="so-luong-mon">Số lượng:</label>
                    <input type="number" id="so-luong-mon" min="0" value="0">
                </div>
            </div>
            <div class="section drink-section">
                <h3>Đồ uống</h3>
                <div class="item">
                    <label for="thuc-uong">Thức uống:</label>
                    <select id="thuc-uong">
                        <option value="">Chọn thức uống</option>

                    </select>
                </div>
                <div class="item">
                    <label for="so-luong-thuc-uong">Số lượng:</label>
                    <input type="number" id="so-luong-thuc-uong" min="0" value="0">
                </div>
            </div>
            <div class="section table-section">
                <h3>Chọn bàn</h3>
                <div class="item">
                    <label for="room-select">Chọn phòng:</label>
                    <select id="room-select">
                        <option value="">Chọn phòng</option>
                        <option value="normal">Normal</option>
                        <option value="smoke">Smoke</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                <div class="item">
                    <label for="table-select">Chọn bàn:</label>
                    <select id="table-select">
                        <option value="">Chọn bàn</option>
                    </select>
                </div>
            </div>
            <div class="section staff-section">
                <h3>Nhân viên phục vụ</h3>
                <div class="item">
                    <label for="nhan-vien">Nhân viên:</label>
                    <select id="nhan-vien" disabled>
                        <option value="nv1">hoangw-chan</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit">Đặt đồ</button>
    </div>
</div>
<script src="../js/trangchu.js"></script>
</body>
</html>