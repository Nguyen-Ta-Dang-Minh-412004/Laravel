// Định nghĩa một hàm để gọi tất cả các API
function loadData() {
    const BASE_URL = 'https://laravel-kk8s.onrender.com'; 
    const FETCH_ORDER_COUNT_API = `${BASE_URL}/api/bills/findByDate`;
    const FETCH_MONEY_TODAY_API = `${BASE_URL}/api/bills/billToday`;
    const FETCH_MONEY_YESTERDAY_API = `${BASE_URL}/api/bills/billYesterday`;
    const FETCH_MONEY_BY_HOUR_API = `${BASE_URL}/api/bills/revernue`;
    const TrangChuApi = `${BASE_URL}/`;

    document.querySelector(".TrangChu").addEventListener('click',(event) =>{
        event.preventDefault();
        window.location.href = BASE_URL;
    });
    // Gọi API lấy số đơn theo ngày hôm nay
    const today = new Date().toISOString().split("T")[0]; // Lấy ngày hôm nay
    fetch(`${FETCH_ORDER_COUNT_API}?date=${today}`) // Thêm tham số ngày vào API
        .then(response => response.json())
        .then(data => {
            const orderCount = data.length; 
            console.log(data);
            document.getElementById('orderCount').innerText = orderCount + " đơn đã xong";
        })
        .catch(error => console.error('Error fetching order count:', error));

    // Gọi API lấy tổng tiền hôm nay
    fetch(FETCH_MONEY_TODAY_API)
        .then(response => response.json())
        .then(data => {
            const moneyToday = data.toLocaleString();
            document.getElementById('moneyToday').innerText = moneyToday + " VND";
        })
        .catch(error => console.error('Error fetching money today:', error));

    // Gọi API lấy tổng tiền hôm qua
    fetch(FETCH_MONEY_YESTERDAY_API)
        .then(response => response.json())
        .then(data => {
            const moneyYesterday = data.toLocaleString(); // Chuyển đổi thành chuỗi có dấu phẩy
            document.getElementById('moneyYesterday').innerText = moneyYesterday + " VND";
        })
        .catch(error => console.error('Error fetching money yesterday:', error));
}

// Gọi hàm loadData khi trang web được tải
document.addEventListener('DOMContentLoaded', loadData);

document.addEventListener('DOMContentLoaded', function() {
    fetch(FETCH_MONEY_TODAY_API)
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-money-today').textContent = data.toLocaleString('vi-VN') + ' VND';
        })
        .catch(error => console.error('Error fetching moneyToday:', error));

    fetch(FETCH_MONEY_BY_HOUR_API)
        .then(response => response.json())
        .then(data => {
            const hourlyChart = document.getElementById('hourly-chart');
            const maxRevenue = Math.max(...data);

            // Kiểm tra nếu maxRevenue là 0
            if (maxRevenue === 0) {
                console.warn("Max revenue is 0, no chart will be displayed");
                return;
            }

            hourlyChart.innerHTML = '';

            const currentTime = new Date();

            for (let i = 0; i < data.length; i++) {
                const bar = document.createElement('div');
                bar.classList.add('bar');

                const barHeight = (data[i] / maxRevenue) * 100;

                // Đảm bảo chiều cao không âm
                const validBarHeight = barHeight >= 0 ? barHeight : 0;

                console.log(`Doanh thu: ${data[i]}, Chiều cao: ${validBarHeight}%`);

                bar.innerHTML = `
                    <div class="height" style="height: ${validBarHeight}%;"></div>
                    <span>${getFormattedTime(currentTime, i)}h</span>
                `;

                hourlyChart.appendChild(bar);
            }
        })
        .catch(error => console.error('Error fetching moneyByHour:', error));

    function getFormattedTime(currentTime, hoursAgo) {
        const date = new Date(currentTime);
        date.setHours(currentTime.getHours() - (7 - hoursAgo));
        return date.getHours();
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const hourlyChart = document.getElementById("hourlyChart");
    const yAxis = document.querySelector(".y-axis");

    if (!hourlyChart || !yAxis) {
        console.error('Không tìm thấy phần tử "hourlyChart" hoặc "y-axis".');
        return;
    }

    fetch("https://laravel-kk8s.onrender.com/api/bills/revernue")
        .then((response) => response.json())
        .then((data) => {
            console.log("Dữ liệu từ API:", data);

            const hourlyData = data.hourly_revenue.map((item) => item.revenue); // Chỉ lấy doanh thu
            const timeLabels = data.hourly_revenue.map((item) => item.hour); // Lấy khoảng thời gian

            hourlyChart.innerHTML = "";
            yAxis.innerHTML = "";

            const maxRevenue = Math.max(...hourlyData, 1); // Tránh chia cho 0

            hourlyData.forEach((value, index) => {
                const bar = document.createElement("div");
                bar.classList.add("bar");

                const heightDiv = document.createElement("div");
                heightDiv.classList.add("height");
                heightDiv.style.height = `${(value / maxRevenue) * 100}px`; // Tỉ lệ chiều cao

                const label = document.createElement("span");
                label.innerText = timeLabels[index]; // Hiển thị khoảng thời gian "00:00 - 01:00"

                bar.appendChild(heightDiv);
                bar.appendChild(label);
                hourlyChart.appendChild(bar);
            });

            for (let i = 5; i >= 0; i--) {
                const gridLine = document.createElement("div");
                gridLine.classList.add("grid-line");

                const label = document.createElement("span");
                label.innerText = `${Math.round((maxRevenue / 5) * i)} VND`;

                gridLine.appendChild(label);
                yAxis.appendChild(gridLine);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi lấy dữ liệu:", error);
            alert("Không thể tải dữ liệu doanh thu theo giờ.");
        });
});
