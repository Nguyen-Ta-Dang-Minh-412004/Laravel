// Cập nhật vai trò từ localStorage
function updateRole() {
    const userRole = localStorage.getItem('userRole'); // Lấy vai trò từ localStorage
    const nasRoleElement = document.getElementById('nasRole');

    if (userRole) {
        nasRoleElement.textContent = userRole; // Cập nhật vai trò trong ô NAS
    }
}

// Gọi API để lấy danh sách bàn theo khu vực
function fetchTablesByArea(area) {
    fetch(`http://127.0.0.1/tables/findByArea/{area_id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }   
            return response.json();
        })
        .then(data => {
            console.log(data);
            displayTables(data, area); // Gọi hàm để hiển thị bàn
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
        });
}
window.onload = function() {
    resetTableStatus(); // Gọi hàm reset khi trang được load
};

// Hàm để gọi API reset
function resetTableStatus() {
    fetch('http://127.0.0.1/table-times/reset', {
        method: 'PATCH', // Sử dụng phương thức PATCH để gọi API
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log('Reset thành công'); // Xử lý khi API thành công
        })
        .catch(error => {
            console.error('Có lỗi xảy ra khi gọi API:', error); // Bắt lỗi nếu có
        });
}

// Hàm hiển thị các bàn
function displayTables(tables, area) {
    // Tìm phần tử tương ứng với khu vực
    const grid = document.querySelector(`#${area}-grid`); // Sử dụng id của grid tương ứng với khu vực
    grid.innerHTML = ''; // Xóa nội dung hiện tại

    tables.forEach(table => {
        const tableItem = createTableItem(table, area); // Gọi hàm tạo bàn
        grid.appendChild(tableItem); // Thêm bàn vào grid
    });
}

// Thêm sự kiện click cho các mục trong aside
document.querySelectorAll('.content aside ul li').forEach(li => {
    li.addEventListener('click', () => {
        const area = li.getAttribute('data-area');
        fetchTablesByArea(area); // Gọi API khi nhấp vào từng khu vực
    });
});

window.addEventListener('load', () => {
    showContent('content-normal'); // Hiển thị nội dung mặc định khi tải trang

    // Thêm class 'active' cho phần tử đầu tiên
    const firstLi = document.querySelector('.content aside ul li[data-area="normal"]');
    firstLi.classList.add('active');
});

// Hàm tạo table-item
function createTableItem(table, area) {
    const tableItem = document.createElement('div');
    tableItem.className = 'table-item';
    tableItem.setAttribute('data-room', table.roomType); // Sử dụng roomType từ đối tượng table
    tableItem.setAttribute('data-status', table.status); // Sử dụng status từ đối tượng table

    // Đặt màu nền dựa trên trạng thái
    let backgroundColor = '';
    switch (table.status) {
        case 'booked':
            backgroundColor = 'rgb(147, 197, 253)';
            break;
        case 'broken':
            backgroundColor = 'rgb(252, 165, 165)';
            break;
        case 'use':
            backgroundColor = 'rgb(134, 239, 172)';
            break;
        default:
            backgroundColor = '';
    }

    if (backgroundColor) {
        tableItem.style.backgroundColor = backgroundColor; // Cập nhật màu nền nếu có
    }

    // Thêm nội dung cho tableItem
    tableItem.innerHTML = `
        <a href="#" data-name="Bàn ${table.tableNumber}" data-room="${table.roomType}">
            <img src="../img/billiard-table.svg" alt="Bàn ${table.tableNumber}">
        </a>
        <p class="p1">Bàn ${table.tableNumber}</p>
        <p class="status">Trạng thái: ${table.status}</p> <!-- Sử dụng trực tiếp table.status -->
    `;

    // Thêm sự kiện click cho table-item
    tableItem.addEventListener('click', () => {
        // Sử dụng trực tiếp table.status thay vì table_status
        showTablePopup(`${table.tableNumber}`, table.tableNumber, area, table.status);
    });

    return tableItem; // Trả về tableItem đã tạo
}

// Hàm hiển thị nội dung và cập nhật trạng thái active
function showContent(contentId) {
    // Ẩn tất cả các nội dung và xóa trạng thái active
    document.querySelectorAll('.article-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelectorAll('.content aside ul li').forEach(li => {
        li.classList.remove('active');
    });

    // Hiển thị nội dung được chọn và cập nhật trạng thái active
    const selectedContent = document.getElementById(contentId);
    selectedContent.classList.add('active');

    const index = ['content-normal', 'content-smoke', 'content-vip'].indexOf(contentId);
    const selectedLi = document.querySelectorAll('.content aside ul li')[index];
    selectedLi.classList.add('active');

    // Tái tạo bàn cho tab được chọn
    fetchTablesByArea(contentId.split('-')[1]); // Gọi API để lấy bàn cho loại phòng đã chọn
}

// Thêm sự kiện click cho các mục trong aside
document.querySelectorAll('.content aside ul li').forEach((li, index) => {
    li.addEventListener('click', () => {
        const contentId = ['content-normal', 'content-smoke', 'content-vip'][index];
        showContent(contentId); // Gọi hàm showContent cho từng khu vực
    });
});
// const bookButton = document.getElementById('book-table');

function showTablePopup(tableId, tableName, roomType, status) {
    const popup = document.getElementById('popup');
    const popupTitle = document.getElementById('popup-title');
    const popupInfo = document.getElementById('popup-info');
    const bookButton = document.getElementById('book-table');
    const payButton = document.getElementById('pay');

    // Gán tableId vào thuộc tính data-table-id của popup
    popup.setAttribute('data-table-id', tableId);

    // Cập nhật tiêu đề và thông tin bàn
    popupTitle.textContent = `Thông tin bàn: ${tableName}`;
    popupInfo.innerHTML = `Phòng: ${roomType}<br>Trạng thái: ${status}`;
    // Cập nhật trạng thái nút theo trạng thái bàn
    if (status === 'use') {
        bookButton.disabled = false;
        payButton.disabled = false;
    } else if (status === 'broken') {
        bookButton.disabled = true;
        payButton.disabled = true;
    } else if (status === 'empty') {
        bookButton.disabled = false;
        payButton.disabled = true;
    } else {
        bookButton.disabled = false;
        payButton.disabled = true;
    }
    // Thêm sự kiện click cho nút "Đặt bàn" trong popup thông tin bàn
    bookButton.addEventListener('click', () => {
        const popup = document.getElementById('popup');
        popup.style.display = 'none'; // Ẩn popup thông tin bàn
        showDatBanPopup(tableId); // Hiển thị popup đặt bàn
    });
    // Hiển thị popup
    popup.style.display = 'flex';
}




document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('pay').addEventListener('click', function() {
        // Lấy tableId từ thuộc tính data-table-id của popup
        const popup = document.getElementById('popup');
        const tableId = popup.getAttribute('data-table-id');
        console.log(tableId);
        if (!tableId) {
            alert('Không tìm thấy ID của bàn!');
            return;
        }

        // Tính tổng tiền cần trả
        const totalPrice = pricePerHour * timePlayed;

        // Hiển thị thông tin thanh toán trong popup
        document.getElementById('tableId').textContent = tableId;
        document.getElementById('roomId').textContent = roomId;
        document.getElementById('pricePerHour').textContent = pricePerHour.toLocaleString();
        document.getElementById('timePlayed').textContent = timePlayed;
        document.getElementById('totalPrice').textContent = totalPrice.toLocaleString();

        // Hiển thị popup thanh toán
        document.getElementById('paymentPopup').style.display = 'block';
    });
});

//
// document.getElementById('closePopup').addEventListener('click', function() {
//     // Ẩn popup thanh toán
//     document.getElementById('paymentPopup').style.display = 'none';
// });
//
// document.getElementById('confirmPayment').addEventListener('click', function() {
//     const tableId = document.getElementById('tableId').textContent;
//
//     // Thực hiện gọi API thanh toán
//     fetch(`http://localhost:8080/pay/${tableId}`, {
//         method: 'POST',
//     })
//         .then(response => response.json()) // Chuyển đổi kết quả trả về thành JSON
//         .then(data => {
//             // Xử lý kết quả trả về từ API
//             console.log('Thanh toán thành công, số tiền:', data);
//
//             // Cập nhật giao diện sau khi thanh toán thành công
//             alert(`Thanh toán thành công! Tổng số tiền: ${data} VND`);
//
//             // Ẩn popup và reset trạng thái bàn
//             document.getElementById('paymentPopup').style.display = 'none';
//
//             // Cập nhật lại trạng thái bàn (ví dụ: 'empty')
//             updateTableStatus(tableId, 'empty');
//         })
//         .catch(error => {
//             console.error('Có lỗi xảy ra khi thanh toán:', error);
//             alert('Thanh toán thất bại! Vui lòng thử lại.');
//         });
// });


// Hàm hiển thị popup đặt bàn
function showDatBanPopup(table_id) {
    const datBanPopup = document.getElementById('dat-ban-popup');
    datBanPopup.style.display = 'flex'; // Hiển thị popup đặt bàn

    // Tìm phần tử .room-table.son và cập nhật nội dung với table_id
    const roomTableElement = datBanPopup.querySelector('.room-table.son');
    if (roomTableElement) {
        roomTableElement.innerHTML = `<p>Phòng bàn: ${table_id}</p>`;
    }

    // Lấy nút "Thêm thông tin"
    const addInfoButton = datBanPopup.querySelector('.dat-ban-button button:first-child');

    // Xóa sự kiện click cũ (nếu có) để tránh bị lặp sự kiện
    addInfoButton.onclick = null;

    // Thêm sự kiện click cho nút "Thêm thông tin"
    addInfoButton.onclick = function() {
        // Lấy thông tin từ các input
        const tenKhachHang = document.getElementById('ten-khach-hang').value;
        const thoiGianBatDau = document.getElementById('thoi-gian-bat-dau').value;  // Đây là input[type="time"]
        const thoiLuong = document.getElementById('thoi-luong').value;

        // Kiểm tra giá trị thoiGianBatDau và thoiLuong có hợp lệ hay không
        if (!thoiGianBatDau || !thoiLuong) {
            alert("Vui lòng nhập đầy đủ thông tin thời gian bắt đầu và thời lượng.");
            return;
        }

        // Tính thời gian kết thúc
        const time_end = calculateEndTime(thoiGianBatDau, thoiLuong);

        // Tạo đối tượng request
        const tableTimeRequest = {
            table_id: table_id,
            staff_id:1,
            time_start: thoiGianBatDau,
            time_end: time_end,
        };

        console.log(tableTimeRequest); // Kiểm tra dữ liệu trước khi gửi

        // Gửi yêu cầu PUT đến API
        fetch('http://localhost:8080/table-times/', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(tableTimeRequest),
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Đặt bàn thất bại');
                }
            })
            .then(data => {
                alert('Đặt bàn thành công!');
                datBanPopup.style.display = 'none'; // Ẩn popup sau khi hoàn tất
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Thời gian bị trùng!');
            });
    };
}

// Hàm tính thời gian kết thúc dựa trên thời gian bắt đầu và thời lượng
function calculateEndTime(startTime, durationInHours) {
    // startTime được trả về từ input[type="time"] với định dạng HH:MM
    const [startHour, startMinute] = startTime.split(':').map(Number);
    const duration = Number(durationInHours);

    let endHour = startHour + duration;
    let endMinute = startMinute;

    if (endHour >= 24) {
        endHour = endHour % 24;  // Điều chỉnh nếu giờ vượt quá 24
    }

    // Tạo đối tượng Date và thiết lập giờ/phút
    const endTime = new Date();
    endTime.setHours(endHour);
    endTime.setMinutes(endMinute);

    // Trả về thời gian kết thúc dưới dạng HH:MM (chỉ lấy phần giờ và phút)
    return endTime.toTimeString().slice(0, 5);
}





function closeDatBanPopup() {
    const datBanPopup = document.getElementById('dat-ban-popup');
    const inputFields = datBanPopup.querySelectorAll('input'); // Lấy tất cả các trường input trong popup

    // Xóa nội dung của các trường input
    inputFields.forEach(field => field.value = '');

    datBanPopup.style.display = 'none'; // Ẩn popup đặt bàn
}

// Đóng popup đặt bàn khi nhấn nút đóng (nút X)
const datBanCloseButton = document.querySelector('#dat-ban-popup .close');
datBanCloseButton.addEventListener('click', closeDatBanPopup); // Đóng và xóa thông tin khi nhấn nút X

// Thêm sự kiện click cho nút "Hủy" trong popup đặt bàn
const cancelBookingButton = document.querySelector('.dat-ban-button button:nth-child(2)'); // Nút hủy đặt bàn (nút thứ 2 trong .dat-ban-button)
cancelBookingButton.addEventListener('click', closeDatBanPopup); // Khi nhấn nút Hủy, đóng popup và xóa thông tin

// Đóng popup thông tin bàn khi nhấn nút đóng
const closeButton = document.querySelector('#popup .close');
closeButton.addEventListener('click', () => {
    const popup = document.getElementById('popup');
    popup.style.display = 'none'; // Ẩn popup thông tin bàn
});

// Lấy tham chiếu đến biểu tượng bell-concierge và popup order-modal
const bellIcon = document.querySelector('.fa-bell-concierge');
const orderModal = document.getElementById('order-popup');

// Thêm sự kiện click cho biểu tượng bell-concierge
bellIcon.addEventListener('click', () => {
    orderModal.style.display = 'flex'; // Hiển thị popup
});

// Thêm sự kiện đóng cho nút close trong order-modal
const orderModalCloseBtn = orderModal.querySelector('.close');
orderModalCloseBtn.addEventListener('click', () => {
    orderModal.style.display = 'none'; // Ẩn popup khi nhấn nút đóng
});

// Thêm sự kiện đóng popup khi click bên ngoài modal
window.addEventListener('click', (event) => {
    if (event.target === orderModal) {
        orderModal.style.display = 'none';
    }
});
document.getElementById('room-select').addEventListener('change', function() {
    const room = this.value;

    // Kiểm tra xem phòng có được chọn hay chưa
    if (room) {
        // Gửi yêu cầu GET tới API findArea
        fetch(`http://:8080/tables/findArea/${room}`)
            .then(response => response.json())
            .then(data => {
                // Làm rỗng phần tử table-select trước khi thêm bàn mới
                const tableSelect = document.getElementById('table-select');
                tableSelect.innerHTML = '<option value="">Chọn bàn</option>'; // Đặt lại tùy chọn mặc định

                // Duyệt qua danh sách các bàn và thêm chúng vào dropdown table-select
                data.forEach(table => {
                    const option = document.createElement('option');
                    option.value = table.id; // Giả sử bảng có thuộc tính id
                    option.textContent = `Bàn ${table.id}`;
                    tableSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Lỗi khi gọi API:', error);
            });
    }
});
// Gọi API để lấy danh sách món ăn
function loadFoodOptions() {
    fetch('http://localhost:8080/items/findFood')
        .then(response => response.json())
        .then(data => {
            const foodSelect = document.getElementById('mon-an');
            foodSelect.innerHTML = '<option value="">Chọn món</option>'; // Xóa các tùy chọn cũ
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;  // Sử dụng id của món ăn làm giá trị
                option.textContent = item.name;  // Hiển thị tên món ăn
                foodSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching food items:', error);
        });
}

// Gọi API để lấy danh sách đồ uống
function loadDrinkOptions() {
    fetch('http://localhost:8080/items/findDrink')
        .then(response => response.json())
        .then(data => {
            const drinkSelect = document.getElementById('thuc-uong');
            drinkSelect.innerHTML = '<option value="">Chọn thức uống</option>'; // Xóa các tùy chọn cũ
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;  // Sử dụng id của đồ uống làm giá trị
                option.textContent = item.name;  // Hiển thị tên đồ uống
                drinkSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching drink items:', error);
        });
}

// Gọi khi mở popup hoặc khi cần cập nhật món ăn và đồ uống
document.addEventListener('DOMContentLoaded', function () {
    loadFoodOptions(); // Gọi khi trang được tải
    loadDrinkOptions(); // Gọi khi trang được tải
});
document.querySelector('.order-modal button[type="submit"]').addEventListener('click', function() {
    const tableId = document.getElementById('table-select').value; // ID bàn
    const foodItemId = document.getElementById('mon-an').value; // ID món ăn
    const foodQuantity = document.getElementById('so-luong-mon').value; // Số lượng món ăn
    const drinkItemId = document.getElementById('thuc-uong').value; // ID đồ uống
    const drinkQuantity = document.getElementById('so-luong-thuc-uong').value; // Số lượng đồ uống

    // Tạo đối tượng request cho món ăn
    const foodOrderItem = {
        table_id: tableId,
        item: foodItemId,
        quantity: foodQuantity,
    };

    // Tạo đối tượng request cho đồ uống
    const drinkOrderItem = {
        table_id: tableId,
        item: drinkItemId,
        quantity: drinkQuantity,
    };

    console.log('Food Order Item:', foodOrderItem);
    console.log('Drink Order Item:', drinkOrderItem);

    let totalPrice = 0; // Biến để lưu tổng tiền

    // Tạo mảng các promise để xử lý yêu cầu
    const promises = [];

    // Gửi yêu cầu tạo món ăn nếu có chọn món ăn
    if (foodItemId) {
        const foodOrderPromise = fetch('http://localhost:8080/order_items/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(foodOrderItem),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(foodData => {
                console.log('Food response:', foodData);
                totalPrice += foodData.totalPrice; // Cộng giá trị vào tổng tiền
            })
            .catch(error => {
                console.error('Error creating food order:', error);
            });

        promises.push(foodOrderPromise); // Thêm promise vào mảng
    }

    // Gửi yêu cầu tạo đồ uống nếu có chọn đồ uống
    if (drinkItemId) {
        const drinkOrderPromise = fetch('http://localhost:8080/order_items/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(drinkOrderItem),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(drinkData => {
                console.log('Drink response:', drinkData);
                totalPrice += drinkData.totalPrice; // Cộng giá trị vào tổng tiền
            })
            .catch(error => {
                console.error('Error creating drink order:', error);
            });

        promises.push(drinkOrderPromise); // Thêm promise vào mảng
    }

    // Chờ cho cả hai yêu cầu (nếu có) hoàn thành
    Promise.all(promises).then(() => {
        // Hiển thị tổng giá trị đơn hàng
        if (totalPrice > 0) {
            alert(`Tổng giá trị đơn hàng là: ${totalPrice}`);
        } else {
            alert('Không có món nào được đặt!');
        }
    });
});
