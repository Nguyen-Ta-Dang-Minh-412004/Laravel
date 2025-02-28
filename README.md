FULL NAME: NGUYỄN TÁ ĐẶNG MINH 

I. Giới thiệu

Đây là hệ thống cho ứng dụng quản lý câu lạc bộ bi-a, giúp theo dõi các bàn chơi, người chơi, đơn hàng, nhân viên và doanh thu.

Công nghệ sử dụng

PHP (Laravel Framework)
HTML,CSS,JS
DATABASE
RENDER FOR DEPLOY WEB

II. Giao diện hệ thống:

1. Trang chủ:

![image](https://github.com/user-attachments/assets/c030f028-16d1-4ea4-b481-8f57af71b33e)

TẠI ĐÂY CÓ CÁC THANH HỖ TRỢ VÀ THANH HỆ THỐNG CỦA TRANG WEB

2. Giao diện trong phần chức năng đặt món ( hình quả chuông ):

 ![image](https://github.com/user-attachments/assets/b184fc9a-3088-4d7e-9989-f2dca07c94b2)

3. Giao diện về thông tin của bàn chơi:

![image](https://github.com/user-attachments/assets/c55aa923-00d8-429f-8f49-9b7fb6b0a73d)

4. Giao diện của tính năng đặt bàn:

![image](https://github.com/user-attachments/assets/0db66fc7-8bbf-4600-8c6b-ad2b13bee022)

5. Giao diện thanh toán bàn chơi:

![image](https://github.com/user-attachments/assets/2d60af12-d5aa-4b63-80fb-5e85658c1381)

4. Giao diện Footer:

   ![image](https://github.com/user-attachments/assets/4a435b2b-1470-48b2-9a8a-4804379d3fba)


III. Các chức năng chính và cách hoạt động: 

1. Chức năng đặt bàn:

 ![image](https://github.com/user-attachments/assets/91c98f4b-5336-48e2-b2ad-56e221547509)

 •	 Mô Tả
Ca sử dụng này cho phép nhân viên đặt bàn chơi cho khách hàng thông qua hệ thống. Hệ thống kiểm tra trạng thái bàn, xác thực thông tin khách hàng và xác nhận đặt bàn. Nếu bàn có sẵn và thông tin hợp lệ, hệ thống sẽ ghi nhận đặt bàn thành công. Nếu bàn đã có người sử dụng hoặc thông tin không hợp lệ, hệ thống sẽ báo lỗi.
•	Tác Nhân
•	Nhân viên: Người thực hiện thao tác đặt bàn.
•	Hệ thống: Kiểm tra trạng thái bàn và xác thực thông tin.
•	 Điều Kiện Kích Hoạt
•	Nhân viên đã đăng nhập vào hệ thống.
•	Tiền Điều Kiện
•	Hệ thống đã có danh sách bàn và trạng thái bàn.
•	Nhân viên có quyền đặt bàn trong hệ thống.
•	 Hậu Điều Kiện
•	Nếu đặt bàn thành công: Hệ thống cập nhật trạng thái bàn sang "Đang sử dụng".
•	Nếu đặt bàn thất bại: Hệ thống hiển thị thông báo lỗi phù hợp.
•	Luồng Sự Kiện
•	Luồng Cơ Bản (Thành công)
1.	Nhân viên chọn bàn chơi muốn đặt.
2.	Hệ thống hiển thị thông tin bàn chơi.
3.	Hệ thống kiểm tra tính khả dụng của bàn.
4.	Nếu bàn có sẵn, nhân viên nhập thông tin khách hàng.
5.	Hệ thống xác thực thông tin.
6.	Nếu thông tin hợp lệ, hệ thống cập nhật trạng thái bàn và thông báo đặt bàn thành công.
•	Luồng Thay Thế
•	 Bàn đang có người sử dụng:
o	Hệ thống hiển thị thông báo bàn đang được sử dụng.
o	Nhân viên chọn bàn khác hoặc hủy thao tác.
•	Luồng Ngoại Lệ
•	 Nhập thông tin khách hàng không hợp lệ:
o	Hệ thống báo lỗi thông tin không hợp lệ.
o	Nhân viên nhập lại thông tin khách hàng.
•	Business Rules
•	Nhân viên chỉ có thể đặt bàn nếu bàn đang trống.
•	Chỉ những nhân viên có quyền đặt bàn mới được thực hiện thao tác này.
•	Yêu Cầu Phi Chức Năng
•	Hệ thống phải phản hồi trong vòng 3 giây sau khi nhân viên chọn bàn.
•	Hệ thống phải hiển thị lỗi rõ ràng nếu đặt bàn thất bại.
•	Extension Point
•	Điểm mở rộng: Xác thực thông tin khách hàng.
o	Có thể tích hợp với hệ thống quản lý khách hàng để kiểm tra thông tin thành viên.

2. Chức năng đặt món:

 ![image](https://github.com/user-attachments/assets/a694fa12-f3c1-47b3-a8d7-18f36fe2e49d)

•	Mô Tả
Ca sử dụng này cho phép nhân viên đặt món ăn và thức uống cho khách hàng thông qua hệ thống. Hệ thống hiển thị danh sách các món có sẵn, xác thực thông tin đơn hàng và xác nhận đặt món. Nếu thông tin hợp lệ, hệ thống sẽ ghi nhận đơn hàng thành công. 
Tác Nhân
•	Nhân viên: Người thực hiện thao tác đặt món.
•	Hệ thống: Xử lý thông tin đặt món, kiểm tra tính hợp lệ và cập nhật đơn hàng.
•	. Điều Kiện Kích Hoạt
•	Nhân viên đã đăng nhập vào hệ thống.
•	Tiền Điều Kiện
•	Hệ thống có danh sách món ăn và thực đơn cập nhật.
•	Nhân viên có quyền đặt món trong hệ thống.
•	Hậu Điều Kiện
•	Nếu đặt món thành công: Hệ thống cập nhật đơn hàng và hiển thị thông báo.
•	Nếu đặt món thất bại: Hệ thống hiển thị thông báo lỗi phù hợp.
•	 Luồng Sự Kiện
•	Luồng Cơ Bản (Thành công)
1.	Nhân viên chọn món ăn, thức uống để đặt.
2.	Hệ thống hiển thị thông tin về các món ăn.
3.	Nhân viên nhập số lượng món ăn.
4.	Nhân viên chọn phòng bàn để giao món.
5.	Nhân viên nhấn nút đặt món.
6.	Hệ thống xác nhận và hiển thị thông báo đặt món thành công.
•	Luồng Thay Thế
•	Nhập số lượng món không hợp lệ:
o	Hệ thống hiển thị lỗi số lượng không hợp lệ.

•	Luồng Ngoại Lệ: không có
•	Business Rules
•	Nhân viên chỉ có thể đặt món nếu món còn trong thực đơn.
•	Số lượng món nhập vào phải lớn hơn 0.
•	Chỉ những nhân viên có quyền đặt món mới thực hiện thao tác này.
•	 Yêu Cầu Phi Chức Năng
•	Hệ thống phải phản hồi trong vòng 3 giây sau khi nhân viên nhấn đặt món.
•	Hệ thống phải hiển thị lỗi rõ ràng nếu đặt món thất bại.
•	Extension Point
•	Điểm mở rộng: Xác thực thông tin đặt món.
o	Có thể tích hợp với hệ thống quản lý kho để kiểm tra tồn kho nguyên liệu.

3. Chức năng thanh toán:

 ![image](https://github.com/user-attachments/assets/d960bae6-c07a-46a1-9cd4-18692cb5365b)


•	Mô tả
Hệ thống cho phép nhân viên lựa chọn phương thức thanh toán (tiền mặt hoặc tài khoản ngân hàng) và xử lý giao dịch theo quy định.
•	Các tác nhân
•	Nhân viên: Thực hiện thao tác thanh toán.
•	Hệ thống: Xử lý giao dịch, xác nhận thanh toán.
•	Ngân hàng: Hỗ trợ giao dịch qua tài khoản ngân hàng.
•	Điều kiện kích hoạt
•	Nhân viên đăng nhập vào hệ thống.
•	Nhân viên chọn chức năng thanh toán.
•	Tiền điều kiện
•	Hệ thống có kết nối internet.
•	Nếu thanh toán qua ngân hàng, tài khoản khách hàng hợp lệ.
•	Nếu thanh toán qua ngân hàng, thiết bị có thể nhận mã xác nhận.
•	Hậu điều kiện
•	Giao dịch hoàn tất thành công hoặc bị hủy nếu quá thời gian xác nhận.
•	Luồng sự kiện
1.	Nhân viên đăng nhập và chọn phương thức thanh toán.
2.	Nếu chọn tiền mặt → Thanh toán thành công.
3.	Nếu chọn tài khoản ngân hàng:
o	Nhập thông tin tài khoản → Hệ thống kiểm tra hợp lệ.
o	Nếu hợp lệ, hệ thống gửi mã xác nhận qua điện thoại.
o	Nhân viên nhập mã xác nhận.
o	Nếu đúng và trong thời gian quy định → Thanh toán thành công.
o	Nếu sai hoặc quá thời gian → Hệ thống yêu cầu hủy giao dịch.
•	 Business rules
•	Chỉ nhân viên hợp lệ được thực hiện thanh toán.
•	Giao dịch không hợp lệ phải bị từ chối.
•	Yêu cầu phi chức năng
•	Độ trễ thấp khi xử lý giao dịch.
•	Đảm bảo bảo mật thông tin tài khoản và mã xác nhận.
   Extension point
    Không có.


Liên hệ
Email: nguyentadangminh04@gmail.com
