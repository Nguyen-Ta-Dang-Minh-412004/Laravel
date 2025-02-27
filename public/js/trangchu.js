// Cập nhật vai trò từ localStorage
function updateRole() {
    const userRole = localStorage.getItem('userRole'); // Lấy vai trò từ localStorage
    const nasRoleElement = document.getElementById('nasRole');

    if (userRole) {
        nasRoleElement.textContent = userRole; // Cập nhật vai trò trong ô NAS
    }
}

const BASE_URL = 'https://laravel-kk8s.onrender.com'; // Địa chỉ cơ sở của API
const FETCH_TABLES_BY_AREA_API = `${BASE_URL}/api/tables/findByArea/{area_id}`;
const RESET_TABLE_STATUS_API = `${BASE_URL}/api/table-times/updateStatus`;
const LOAD_FOOD_OPTIONS_API = `${BASE_URL}/api/items/findFood`;
const LOAD_DRINK_OPTIONS_API = `${BASE_URL}/api/items/findDrink`;
const CREATE_ORDER_ITEM_API = `${BASE_URL}/api/order-items/create`;
const TABLE_TIMES_API = `${BASE_URL}/api/table-times/create`; 
const DoanhThuApi = `${BASE_URL}/doanhthu`;
const apiResetTable = `${BASE_URL}/api/table-times/resetTable`;
const apiFindTable = `${BASE_URL}/api/tables/findId`;
const apiPay = `${BASE_URL}/api/table-times/pay`;

document.querySelector(".BaoCao").addEventListener('click',(event) =>{
    event.preventDefault();
    window.location.href = DoanhThuApi;
});
// Khai báo các biến API cho các hàm fetch
const apiEndpoints = {
    fetchTablesByArea: (area) => `${FETCH_TABLES_BY_AREA_API.replace('{area_id}', area)}`,
    resetTableStatus: RESET_TABLE_STATUS_API,
    loadFoodOptions: LOAD_FOOD_OPTIONS_API,
    loadDrinkOptions: LOAD_DRINK_OPTIONS_API,
    createOrderItem: CREATE_ORDER_ITEM_API,
};

// Gọi API để lấy danh sách bàn theo khu vực
function fetchTablesByArea(area) {
    area_id = 0;

    if(area === 'normal'){
        area_id = 0;
    }
    else if(area === 'smoke'){
        area_id = 1;
    }
    else{
        area_id = 2;
    }
    fetch(`https://laravel-kk8s.onrender.com/api/tables/findByArea/${area_id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }   
            return response.json();
        })
        .then(data => {
            console.log(data);
            displayTables(data, area); 
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
        });
}

function ResetTable() {
    fetch(apiResetTable, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token') // Nếu cần token xác thực
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            console.log('Đã reset thời gian bàn thành công!');
        } else {
            console.log('Lỗi: ' + (data.error || 'Không xác định'));
        }
    })
    .catch(error => {
        console.error('Lỗi khi gọi API:', error);
    });
}
window.onload = function() {
    ResetTable();
    resetTableStatus(); // Gọi hàm reset khi trang được load
};

// Hàm để gọi API reset
function resetTableStatus() {
    fetch(apiEndpoints.resetTableStatus, {
        method: 'POST', // Sử dụng phương thức PATCH để gọi API
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
    const grid = document.querySelector(`#${area}-grid`); 
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
        console.log(area);

        // Ẩn tất cả các khu vực
        document.querySelectorAll('.article-content').forEach(content => {
            content.style.display = 'none';
        });

        // Hiển thị khu vực được chọn
        const selectedContent = document.getElementById(`content-${area}`);
        if (selectedContent) {
            selectedContent.style.display = 'block';
        }

        // Gọi API lấy dữ liệu bàn
        fetchTablesByArea(area);
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
        <a href="#" data-name="Bàn ${table.table_number}" data-room="${table.roomType}">
            <img src="../img/billiard-table.svg" alt="Bàn ${table.table_number}">
        </a>
        <p class="p1">Bàn ${table.table_number}</p>
        <p class="status">Trạng thái: ${table.status}</p> <!-- Sử dụng trực tiếp table.status -->
    `;

    // Thêm sự kiện click cho table-item
    tableItem.addEventListener('click', () => {
        showTablePopup(`${table.table_number}`, table.table_number, area, table.status);
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
    const popup = document.getElementById('popupThongTin');
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
        const popup = document.getElementById('popupThongTin');
        popup.style.display = 'none'; // Ẩn popup thông tin bàn
        showDatBanPopup(tableId); // Hiển thị popup đặt bàn
    });
    // Hiển thị popup
    popup.style.display = 'flex';
}
async function findTable(id) {
    try {
        const response = await fetch(`${apiFindTable}/${id}`);
        
        if (!response.ok) {
            throw new Error('Không tìm thấy bàn');
        }

        const data = await response.json();
        return {
            area_id: data.area,
            price: data.price
        };

    } catch (error) {
        console.error('Lỗi:', error);
        alert('Không tìm thấy bàn hoặc có lỗi xảy ra.');
        return null; // Trả về null nếu có lỗi
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('pay').addEventListener('click', async function() {
        const popup = document.getElementById('popupThongTin');
        const tableId = popup.getAttribute('data-table-id');

        if (!tableId) {
            alert('Không tìm thấy ID của bàn!');
            return;
        }

        try {
            // Đợi fetch dữ liệu bàn
            const table = await findTable(tableId);
            if (!table) return; // Nếu lỗi khi lấy bàn, thoát khỏi hàm

            // Gọi API thanh toán
            const response = await fetch(`${apiPay}/${tableId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ table_id: tableId })
            });

            if (!response.ok) {
                throw new Error('Không thể thực hiện thanh toán.');
            }

            const data = await response.json();

            // Cập nhật dữ liệu thanh toán từ API
            document.getElementById('tableId').textContent = tableId;
            document.getElementById('roomId').textContent = table.area_id || 'Không xác định';
            document.getElementById('pricePerHour').textContent = table.price.toLocaleString();
            document.getElementById('timePlayed').textContent = `${data.time_used} phút`;
            document.getElementById('totalPrice').textContent = (data.total_price || 0).toLocaleString();
            // Hiển thị popup thanh toán
            document.getElementById('paymentPopup').style.display = 'block';
            document.getElementById('confirmPayment').addEventListener('click', function() {
                document.getElementById('paymentPopup').style.display = 'none'; 
                document.getElementById('popupThongTin').style.display = 'none'; 
                window.location.reload();
            });

        } catch (error) {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi thanh toán. Vui lòng thử lại!');
        }
    });
});



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
    addInfoButton.onclick = function () {
        const tenKhachHang = document.getElementById("ten-khach-hang").value;
        let thoiGianBatDau = document.getElementById("thoi-gian-bat-dau").value;
        const thoiLuong = document.getElementById("thoi-luong").value;
    
        if (!thoiGianBatDau || !thoiLuong || isNaN(thoiLuong) || thoiLuong <= 0) {
            alert("Vui lòng nhập đầy đủ và chính xác thông tin thời gian.");
            return;
        }
    
        if (typeof table_id === "undefined") {
            alert("Lỗi: Không xác định được bàn.");
            return;
        }
    
        let time_end;
        try {
            time_end = calculateEndTime(thoiGianBatDau, thoiLuong);
        } catch (error) {
            console.error("Lỗi khi tính toán thời gian kết thúc:", error);
            alert("Có lỗi xảy ra khi tính toán thời gian kết thúc.");
            return;
        }
    
        thoiGianBatDau = thoiGianBatDau + ":00"; 
        time_end = time_end + ":00"; 
    
        // Ngày hôm nay
        const today = new Date().toISOString().split("T")[0];
    
        const tableTimeRequest = {
            staff_id: 2,  // Đặt cứng ID nhân viên (hoặc có thể lấy từ dữ liệu đăng nhập)
            table_id: table_id,
            time_start: thoiGianBatDau,
            time_end: time_end,
            date: today
        };
    
        console.log("Đang gửi request:", tableTimeRequest);
    
        fetch(TABLE_TIMES_API, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(tableTimeRequest),
        })
            .then((response) => {
                console.log("Phản hồi từ server:", response);
    
                // Kiểm tra nếu phản hồi không chứa JSON
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    return response.text().then(text => {
                        console.error("Phản hồi không phải JSON:", text);
                        throw new Error("Phản hồi từ server không hợp lệ.");
                    });
                }
    
                return response.json();
            })
            .then((data) => {
                alert("Đặt bàn thành công!");
                console.log("Phản hồi JSON từ server:", data);
                datBanPopup.style.display = "none"; 
            })
            .catch((error) => {
                console.error("Lỗi:", error);
                alert("Lỗi: " + error.message);
            });
    };
    

}
// Hàm tính thời gian kết thúc dựa trên thời gian bắt đầu và thời lượng
function calculateEndTime(startTime, durationInHours) {
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
const closeButton = document.querySelector('#popupThongTin .close');
closeButton.addEventListener('click', () => {
    const popup = document.getElementById('popupThongTin');
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
        fetch(apiEndpoints.fetchTablesByArea(room))
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
    fetch(apiEndpoints.loadFoodOptions)
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
    fetch(apiEndpoints.loadDrinkOptions)
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
    const tableId = document.getElementById('table-select').value; 
    const foodItemId = document.getElementById('mon-an').value; 
    let foodQuantity = document.getElementById('so-luong-mon').value;
    const drinkItemId = document.getElementById('thuc-uong').value; 
    let drinkQuantity = document.getElementById('so-luong-thuc-uong').value; 

    // Chuyển số lượng sang kiểu số
    foodQuantity = foodQuantity ? parseInt(foodQuantity, 10) : 0;
    drinkQuantity = drinkQuantity ? parseInt(drinkQuantity, 10) : 0;

    // Kiểm tra nếu không có bàn hoặc không có món nào được chọn
    if (!tableId) {
        alert("Vui lòng chọn bàn.");
        return;
    }

    if ((!foodItemId || foodQuantity <= 0) && (!drinkItemId || drinkQuantity <= 0)) {
        alert("Vui lòng chọn ít nhất một món ăn hoặc thức uống với số lượng hợp lệ.");
        return;
    }

    let totalPrice = 0;
    let successCount = 0; // Đếm số đơn hàng thành công
    const promises = [];

    // Gửi yêu cầu đặt món ăn nếu có chọn
    if (foodItemId && foodQuantity > 0) {
        const foodOrderItem = {
            table_id: parseInt(tableId, 10),
            item_id: parseInt(foodItemId, 10),
            quantity: foodQuantity,
        };

        const foodOrderPromise = fetch(apiEndpoints.createOrderItem, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(foodOrderItem),
        })
        .then(response => {
            if (!response.ok) throw new Error("Lỗi khi đặt món ăn.");
            return response.json();
        })
        .then(foodData => {
            console.log('Food response:', foodData);
            if (foodData.total_price) totalPrice += foodData.total_price;
            successCount++; // Tăng số lượng đơn thành công
        })
        .catch(error => console.error('Lỗi khi đặt món ăn:', error));

        promises.push(foodOrderPromise);
    }

    // Gửi yêu cầu đặt thức uống nếu có chọn
    if (drinkItemId && drinkQuantity > 0) {
        const drinkOrderItem = {
            table_id: parseInt(tableId, 10),
            item_id: parseInt(drinkItemId, 10),
            quantity: drinkQuantity,
        };

        const drinkOrderPromise = fetch(apiEndpoints.createOrderItem, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(drinkOrderItem),
        })
        .then(response => {
            if (!response.ok) throw new Error("Lỗi khi đặt thức uống.");
            return response.json();
        })
        .then(drinkData => {
            console.log('Drink response:', drinkData);
            if (drinkData.total_price) totalPrice += drinkData.total_price;
            successCount++; // Tăng số lượng đơn thành công
        })
        .catch(error => console.error('Lỗi khi đặt thức uống:', error));

        promises.push(drinkOrderPromise);
    }

    // Chờ tất cả các yêu cầu hoàn thành
    Promise.allSettled(promises).then(() => {
        if (totalPrice > 0) {
            alert(`Tổng giá trị đơn hàng: ${totalPrice} VNĐ`);
            if (successCount > 0) {
                document.querySelector('.order-modal').style.display = 'none'; // Ẩn popup
            }
        } else {
            alert("Không có món nào được đặt!");
        }
    });
});


