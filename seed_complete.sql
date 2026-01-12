-- =====================
-- TRAVEL BOOKING SYSTEM - COMPLETE SEED DATA
-- Database: db_web_du_lich
-- Generated: 2026-01-12
-- =====================

USE db_web_du_lich;

-- =====================
-- CLEAR ALL OLD DATA
-- =====================
SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM wishlist;
DELETE FROM reviews;
DELETE FROM bookings;
DELETE FROM tour_services;
DELETE FROM tour_departures;
DELETE FROM tour_itineraries;
DELETE FROM tour_images;
DELETE FROM tours;
DELETE FROM services;
DELETE FROM users;

-- Reset AUTO_INCREMENT
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE services AUTO_INCREMENT = 1;
ALTER TABLE tours AUTO_INCREMENT = 1;
ALTER TABLE tour_itineraries AUTO_INCREMENT = 1;
ALTER TABLE tour_departures AUTO_INCREMENT = 1;
ALTER TABLE tour_services AUTO_INCREMENT = 1;
ALTER TABLE bookings AUTO_INCREMENT = 1;
ALTER TABLE reviews AUTO_INCREMENT = 1;
ALTER TABLE wishlist AUTO_INCREMENT = 1;
ALTER TABLE tour_images AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================
-- INSERT: USERS (16 người)
-- =====================
INSERT INTO users (id, fullname, phone, email, password, role, status) VALUES
 (1, 'Nguyễn Văn An',     '0901000001', 'an.nguyen@example.com',      '123456', 'customer', 1),
 (2, 'Trần Thị Bình',     '0901000002', 'binh.tran@example.com',      '123456', 'customer', 1),
 (3, 'Lê Hoàng Nam',      '0901000003', 'nam.le@example.com',         '123456', 'customer', 1),
 (4, 'Phạm Thu Hà',       '0901000004', 'ha.pham@example.com',        '123456', 'customer', 1),
 (5, 'Đỗ Minh Quân',      '0901000005', 'quan.do@example.com',        '123456', 'customer', 1),
 (6, 'Hoàng Yến Nhi',     '0901000006', 'nhi.hoang@example.com',      '123456', 'customer', 1),
 (7, 'Vũ Thành Long',     '0901000007', 'long.vu@example.com',        '123456', 'customer', 1),
 (8, 'Bùi Khánh Linh',    '0901000008', 'linh.bui@example.com',       '123456', 'customer', 1),
 (9, 'Admin Chính',       '0901999001', 'admin1@example.com',         '123456', 'admin',    1),
 (10,'Admin Hệ Thống',    '0901999002', 'admin2@example.com',         '123456', 'admin',    1),
 (11, 'Ngô Thị Ích',      '0901000009', 'ich.ngo@example.com',        '123456', 'customer', 1),
 (12, 'Kiều Văn Khoa',    '0901000010', 'khoa.kieu@example.com',      '123456', 'customer', 1),
 (13, 'Mạc Thị Linh',     '0901000011', 'linh.mac@example.com',       '123456', 'customer', 1),
 (14, 'Nhân Công Minh',   '0901000012', 'minh.nhan@example.com',      '123456', 'customer', 1),
 (15, 'Ông Thị Ngọc',     '0901000013', 'ngoc.ong@example.com',       '123456', 'customer', 1),
 (16, 'Phó Văn Phúc',     '0901000014', 'phuc.pho@example.com',       '123456', 'customer', 1);

-- =====================
-- INSERT: SERVICES (8 dịch vụ)
-- =====================
INSERT INTO services (id, name, slug, description, icon, status) VALUES
 (1, 'Khách sạn 3 sao',             'khach-san-3-sao',     'Lưu trú khách sạn tiêu chuẩn 3 sao.',         NULL, 1),
 (2, 'Khách sạn 4 sao',             'khach-san-4-sao',     'Lưu trú khách sạn tiêu chuẩn 4 sao.',         NULL, 1),
 (3, 'Khách sạn 5 sao',             'khach-san-5-sao',     'Resort/khách sạn cao cấp 5 sao.',            NULL, 1),
 (4, 'Xe đưa đón sân bay/bến xe',   'xe-dua-don',          'Xe đưa đón tại điểm hẹn, xe đời mới.',       NULL, 1),
 (5, 'Hướng dẫn viên tiếng Việt',   'hdv-tieng-viet',      'HDV tiếng Việt theo suốt chương trình.',     NULL, 1),
 (6, 'Hướng dẫn viên tiếng Anh',    'hdv-tieng-anh',       'HDV tiếng Anh cho khách quốc tế.',           NULL, 1),
 (7, 'Ăn uống theo chương trình',   'an-uong',             'Bao gồm bữa sáng/trưa/tối theo chương trình.',NULL, 1),
 (8, 'Bảo hiểm du lịch',            'bao-hiem-du-lich',    'Bảo hiểm du lịch trọn gói.',                  NULL, 1);

-- =====================
-- INSERT: TOURS (8 tour)
-- =====================
INSERT INTO tours (id, name, slug, description, location, region, duration, price_default, price_child, cover_image) VALUES
 (1, 'Hà Nội - Hạ Long 3N2Đ',
   'ha-noi-ha-long-3n2d',
   'Khởi hành từ Hà Nội, tham quan Vịnh Hạ Long, ngủ tàu, khám phá hang động và thưởng thức hải sản.',
   'Hà Nội', 'Miền Bắc', '3 ngày 2 đêm', 3500000.00, 2200000.00, NULL),
 (2, 'Hà Nội - Sapa - Fansipan 4N3Đ',
   'ha-noi-sapa-fansipan-4n3d',
   'Khám phá Sapa, trekking bản làng, chinh phục đỉnh Fansipan bằng cáp treo.',
   'Hà Nội', 'Miền Bắc', '4 ngày 3 đêm', 5200000.00, 3000000.00, NULL),
 (3, 'Ninh Bình - Tràng An - Tam Cốc 2N1Đ',
   'ninh-binh-trang-an-tam-coc',
   'Thuyền trên sông Tràng An, tham quan Tam Cốc - Bích Động và cố đô Hoa Lư.',
   'Ninh Bình', 'Miền Bắc', '2 ngày 1 đêm', 1900000.00, 1200000.00, NULL),
 (4, 'Đà Nẵng - Hội An - Bà Nà 4N3Đ',
   'da-nang-hoi-an-ba-na',
   'Tham quan biển Mỹ Khê, phố cổ Hội An, Bà Nà Hills và Cầu Vàng.',
   'Đà Nẵng', 'Miền Trung', '4 ngày 3 đêm', 4500000.00, 2600000.00, NULL),
 (5, 'Huế - Động Phong Nha 3N2Đ',
   'hue-dong-phong-nha',
   'Tham quan cố đô Huế, Đại Nội, chùa Thiên Mụ và động Phong Nha.',
   'Huế', 'Miền Trung', '3 ngày 2 đêm', 4200000.00, 2500000.00, NULL),
 (6, 'Đà Lạt - Thành phố ngàn hoa 3N2Đ',
   'da-lat-thanh-pho-ngan-hoa',
   'Không khí se lạnh, vườn hoa, hồ Tuyền Lâm, nông trại dâu, quán cà phê view đồi núi.',
   'Đà Lạt', 'Miền Nam', '3 ngày 2 đêm', 3300000.00, 2000000.00, NULL),
 (7, 'Nha Trang - Biển đảo 3N2Đ',
   'nha-trang-bien-dao',
   'Tắm biển, tham quan đảo, lặn ngắm san hô và thưởng thức hải sản.',
   'Nha Trang', 'Miền Nam', '3 ngày 2 đêm', 3600000.00, 2100000.00, NULL),
 (8, 'Phú Quốc - Thiên đường nghỉ dưỡng 4N3Đ',
   'phu-quoc-thien-duong-nghi-duong',
   'Nghỉ dưỡng resort, VinWonders, Safari, câu cá, lặn ngắm san hô.',
   'Phú Quốc', 'Miền Nam', '4 ngày 3 đêm', 7200000.00, 4200000.00, NULL);

-- =====================
-- INSERT: TOUR_ITINERARIES (26 lịch trình)
-- =====================
INSERT INTO tour_itineraries (id, tour_id, day_number, description) VALUES
 (1, 1, 1, 'Đón khách tại Hà Nội, khởi hành đi Hạ Long, lên du thuyền, ăn trưa và tham quan hang động.'),
 (2, 1, 2, 'Dậy sớm ngắm bình minh trên vịnh, chèo kayak, thăm làng chài nổi.'),
 (3, 1, 3, 'Ăn sáng trên tàu, trả phòng, trở về Hà Nội, kết thúc chương trình.'),
 (4, 2, 1, 'Đón khách tại Hà Nội, di chuyển lên Sapa, nhận phòng, dạo chơi thị trấn, chợ đêm.'),
 (5, 2, 2, 'Tham quan bản Cát Cát, trekking nhẹ, tìm hiểu văn hóa bản địa.'),
 (6, 2, 3, 'Đi cáp treo lên đỉnh Fansipan, chụp hình, thưởng ngoạn cảnh quan.'),
 (7, 2, 4, 'Tự do mua sắm, trả phòng, về lại Hà Nội.'),
 (8, 3, 1, 'Xuất phát từ Hà Nội, tham quan cố đô Hoa Lư, chùa Bái Đính.'),
 (9, 3, 2, 'Đi thuyền Tràng An/Tam Cốc, ngắm cảnh núi đá vôi và đồng lúa, trở về Hà Nội.'),
 (10, 4, 1, 'Đón tại sân bay/ga Đà Nẵng, check-in khách sạn, tham quan biển Mỹ Khê.'),
 (11, 4, 2, 'Tham quan Bà Nà Hills, Cầu Vàng, vui chơi khu Fantasy Park.'),
 (12, 4, 3, 'Tham quan phố cổ Hội An, chụp ảnh đèn lồng, trải nghiệm ẩm thực.'),
 (13, 4, 4, 'Tự do mua sắm, trả phòng, tiễn khách ra sân bay.'),
 (14, 5, 1, 'Đón khách tại Huế, tham quan Đại Nội, chùa Thiên Mụ, thưởng thức ẩm thực Huế.'),
 (15, 5, 2, 'Khởi hành đi Quảng Bình, tham quan động Phong Nha/Thiên Đường.'),
 (16, 5, 3, 'Trả khách về Huế, kết thúc chương trình.'),
 (17, 6, 1, 'Đón khách tại Đà Lạt, tham quan quảng trường Lâm Viên, chợ đêm Đà Lạt.'),
 (18, 6, 2, 'Thăm hồ Tuyền Lâm, Thiền viện Trúc Lâm, vườn hoa và nông trại dâu.'),
 (19, 6, 3, 'Tự do mua sắm đặc sản, trả phòng, tiễn khách ra sân bay.'),
 (20, 7, 1, 'Đón khách tại Nha Trang, tham quan Tháp Bà Ponagar, tắm bùn khoáng.'),
 (21, 7, 2, 'Lên tàu tham quan đảo, lặn biển ngắm san hô, tắm biển.'),
 (22, 7, 3, 'Tự do mua sắm, trả phòng, kết thúc chương trình.'),
 (23, 8, 1, 'Đón khách, nhận phòng resort, nghỉ ngơi, tắm biển.'),
 (24, 8, 2, 'Tham quan VinWonders hoặc Safari, vui chơi giải trí.'),
 (25, 8, 3, 'Tham gia tour câu cá, lặn ngắm san hô.'),
 (26, 8, 4, 'Tự do buổi sáng, trả phòng, tiễn khách ra sân bay.');

-- =====================
-- INSERT: TOUR_DEPARTURES (38 đợt khởi hành)
-- =====================
INSERT INTO tour_departures (id, tour_id, departure_location, departure_date, price_moving, price_moving_child, seats_total, seats_available, status) VALUES
 (1, 1, 'Hà Nội', '2026-01-15', 800000.00, 500000.00, 30, 24, 'open'),
 (2, 1, 'Hà Nội', '2026-02-10', 800000.00, 500000.00, 30, 5, 'open'),
 (3, 1, 'Hà Nội', '2026-03-10', 850000.00, 520000.00, 30, 0, 'full'),
 (4, 1, 'Hà Nội', '2025-01-12', 750000.00, 450000.00, 30, 20, 'open'),
 (5, 1, 'Hà Nội', '2025-02-08', 750000.00, 450000.00, 30, 15, 'open'),
 (6, 1, 'Hà Nội', '2025-03-05', 750000.00, 450000.00, 30, 10, 'open'),
 (7, 1, 'Hà Nội', '2025-04-10', 750000.00, 450000.00, 30, 8, 'open'),
 (8, 2, 'Hà Nội', '2026-01-20', 900000.00, 550000.00, 25, 18, 'open'),
 (9, 2, 'Hà Nội', '2026-02-18', 950000.00, 580000.00, 25, 10, 'open'),
 (10, 2, 'Hà Nội', '2026-03-20', 950000.00, 580000.00, 25, 0, 'full'),
 (11, 2, 'Hà Nội', '2025-01-28', 850000.00, 500000.00, 25, 18, 'open'),
 (12, 2, 'Hà Nội', '2025-03-10', 850000.00, 500000.00, 25, 14, 'open'),
 (13, 3, 'Hà Nội', '2026-02-15', 400000.00, 250000.00, 40, 32, 'open'),
 (14, 3, 'Hà Nội', '2026-03-25', 450000.00, 260000.00, 40, 12, 'open'),
 (15, 3, 'Hà Nội', '2025-01-20', 350000.00, 200000.00, 40, 35, 'open'),
 (16, 3, 'Hà Nội', '2025-03-18', 350000.00, 200000.00, 40, 28, 'open'),
 (17, 4, 'Đà Nẵng', '2026-02-10', 700000.00, 450000.00, 30, 20, 'open'),
 (18, 4, 'Đà Nẵng', '2026-03-15', 750000.00, 470000.00, 30, 0, 'full'),
 (19, 4, 'Đà Nẵng', '2026-04-01', 750000.00, 470000.00, 30, 15, 'open'),
 (20, 4, 'Đà Nẵng', '2025-01-25', 650000.00, 400000.00, 30, 22, 'open'),
 (21, 4, 'Đà Nẵng', '2025-03-10', 650000.00, 400000.00, 30, 15, 'open'),
 (22, 5, 'Huế', '2026-02-18', 600000.00, 380000.00, 20, 14, 'open'),
 (23, 5, 'Huế', '2026-03-25', 650000.00, 400000.00, 20, 0, 'full'),
 (24, 5, 'Huế', '2025-02-10', 550000.00, 350000.00, 20, 15, 'open'),
 (25, 5, 'Huế', '2025-03-28', 550000.00, 350000.00, 20, 10, 'open'),
 (26, 6, 'Đà Lạt', '2026-02-20', 500000.00, 320000.00, 25, 19, 'open'),
 (27, 6, 'Đà Lạt', '2026-04-15', 500000.00, 320000.00, 25, 8, 'open'),
 (28, 6, 'Đà Lạt', '2025-02-25', 450000.00, 280000.00, 25, 20, 'open'),
 (29, 6, 'Đà Lạt', '2025-03-30', 450000.00, 280000.00, 25, 15, 'open'),
 (30, 7, 'Nha Trang', '2026-02-25', 650000.00, 380000.00, 35, 22, 'open'),
 (31, 7, 'Nha Trang', '2026-03-28', 700000.00, 400000.00, 35, 0, 'full'),
 (32, 7, 'Nha Trang', '2025-02-15', 600000.00, 350000.00, 35, 25, 'open'),
 (33, 7, 'Nha Trang', '2025-04-05', 600000.00, 350000.00, 35, 20, 'open'),
 (34, 8, 'Phú Quốc', '2026-02-28', 950000.00, 600000.00, 20, 12, 'open'),
 (35, 8, 'Phú Quốc', '2026-03-20', 980000.00, 620000.00, 20, 6, 'open'),
 (36, 8, 'Phú Quốc', '2026-04-10', 1000000.00, 650000.00, 20, 0, 'full'),
 (37, 8, 'Phú Quốc', '2025-01-20', 900000.00, 550000.00, 20, 15, 'open'),
 (38, 8, 'Phú Quốc', '2025-03-25', 900000.00, 550000.00, 20, 10, 'open');

-- =====================
-- INSERT: TOUR_SERVICES (31 liên kết)
-- =====================
INSERT INTO tour_services (id, tour_id, service_id) VALUES
 (1, 1, 2), (2, 1, 4), (3, 1, 5), (4, 1, 7),
 (5, 2, 1), (6, 2, 4), (7, 2, 5), (8, 2, 8),
 (9, 3, 1), (10,3, 4), (11,3, 7),
 (12,4, 2), (13,4, 4), (14,4, 5), (15,4, 7),
 (16,5, 2), (17,5, 4), (18,5, 5), (19,5, 8),
 (20,6, 1), (21,6, 4), (22,6, 7),
 (23,7, 2), (24,7, 4), (25,7, 5), (26,7, 7),
 (27,8, 3), (28,8, 4), (29,8, 6), (30,8, 7), (31,8, 8);

-- =====================
-- INSERT: BOOKINGS (50 đơn đặt - 34 năm 2026 + 16 năm 2025)
-- =====================
INSERT INTO bookings (id, user_id, departure_id, adults, children, total_price, payment_status, status, contact_name, contact_phone, contact_email, note, created_at) VALUES
 (1, 1, 1, 2, 1, 9500000.00, 'paid', 'confirmed', 'Nguyễn Văn An', '0901000001', 'an.nguyen@example.com', 'Yêu cầu phòng 3 người, gần cửa sổ.', '2026-01-10'),
 (2, 2, 1, 1, 0, 4300000.00, 'paid', 'confirmed', 'Trần Thị Bình', '0901000002', 'binh.tran@example.com', 'Đã thanh toán, xác nhận đặt chỗ.', '2026-01-10'),
 (3, 3, 2, 3, 0, 10800000.00, 'paid', 'confirmed', 'Lê Hoàng Nam', '0901000003', 'nam.le@example.com', 'Nhóm bạn 3 người.', '2026-01-09'),
 (4, 4, 8, 2, 2, 15200000.00, 'paid', 'pending_cancellation', 'Phạm Thu Hà', '0901000004', 'ha.pham@example.com', 'Gia đình có trẻ nhỏ.', '2026-01-08'),
 (5, 5, 8, 1, 0, 5200000.00, 'paid', 'confirmed', 'Đỗ Minh Quân', '0901000005', 'quan.do@example.com', 'Đã thanh toán. Cần hóa đơn công ty.', '2026-01-07'),
 (6, 6, 9, 2, 0, 10400000.00, 'refunded', 'cancelled', 'Hoàng Yến Nhi', '0901000006', 'nhi.hoang@example.com', 'Khách hủy do công tác đột xuất.', '2026-01-06'),
 (7, 7, 13, 2, 0, 3800000.00, 'paid', 'pending_cancellation', 'Vũ Thành Long', '0901000007', 'long.vu@example.com', 'Đi nghỉ cuối tuần.', '2026-01-05'),
 (8, 8, 17, 2, 1, 11800000.00, 'paid', 'confirmed', 'Bùi Khánh Linh', '0901000008', 'linh.bui@example.com', 'Phòng có view biển nếu được.', '2026-01-04'),
 (9, 1, 19, 1, 1, 7800000.00, 'paid', 'confirmed', 'Nguyễn Văn An', '0901000001', 'an.nguyen@example.com', 'Đã xác nhận, đã thanh toán.', '2026-01-03'),
 (10, 2, 22, 2, 0, 8400000.00, 'paid', 'confirmed', 'Trần Thị Bình', '0901000002', 'binh.tran@example.com', 'Muốn ở phòng giường đôi.', '2026-01-02'),
 (11, 3, 26, 2, 0, 6600000.00, 'paid', 'confirmed', 'Lê Hoàng Nam', '0901000003', 'nam.le@example.com', 'Trăng mật.', '2026-01-01'),
 (12, 4, 26, 1, 1, 5200000.00, 'paid', 'confirmed', 'Phạm Thu Hà', '0901000004', 'ha.pham@example.com', 'Đã xác nhận, cần phòng có nôi em bé.', '2025-12-31'),
 (13, 5, 30, 3, 1, 16800000.00, 'paid', 'confirmed', 'Đỗ Minh Quân', '0901000005', 'quan.do@example.com', 'Team building công ty.', '2025-12-30'),
 (14, 6, 34, 2, 0, 14400000.00, 'paid', 'confirmed', 'Hoàng Yến Nhi', '0901000006', 'nhi.hoang@example.com', 'Kỷ niệm ngày cưới.', '2025-12-29'),
 (15, 7, 34, 2, 2, 19600000.00, 'paid', 'confirmed', 'Vũ Thành Long', '0901000007', 'long.vu@example.com', 'Đã xác nhận và thanh toán.', '2025-12-28'),
 (16, 1, 14, 2, 0, 3800000.00, 'paid', 'confirmed', 'Nguyễn Văn An', '0901000001', 'an.nguyen@example.com', 'Đặt trực tiếp tại văn phòng.', '2025-12-27'),
 (17, 2, 27, 1, 1, 5200000.00, 'paid', 'confirmed', 'Trần Thị Bình', '0901000002', 'binh.tran@example.com', 'Đặt online, đã thanh toán.', '2025-12-26'),
 (18, 3, 36, 4, 0, 28800000.00, 'paid', 'confirmed', 'Lê Hoàng Nam', '0901000003', 'nam.le@example.com', 'Đoàn incentive 4 người.', '2025-12-25'),
 (19, 4, 18, 2, 1, 11000000.00, 'paid', 'cancelled', 'Phạm Thu Hà', '0901000004', 'ha.pham@example.com', 'Đã thanh toán nhưng khách yêu cầu hủy.', '2025-12-24'),
 (20, 11, 4, 2, 1, 8750000.00, 'paid', 'confirmed', 'Ngô Thị Ích', '0901000009', 'ich.ngo@example.com', 'Yêu cầu phòng gần cửa sổ.', '2025-12-23'),
 (21, 12, 4, 2, 0, 6500000.00, 'paid', 'confirmed', 'Kiều Văn Khoa', '0901000010', 'khoa.kieu@example.com', 'Đã thanh toán.', '2025-12-22'),
 (22, 13, 5, 3, 0, 10500000.00, 'paid', 'confirmed', 'Mạc Thị Linh', '0901000011', 'linh.mac@example.com', 'Nhóm bạn 3 người.', '2025-12-21'),
 (23, 14, 5, 2, 2, 9700000.00, 'refunded', 'cancelled', 'Nhân Công Minh', '0901000012', 'minh.nhan@example.com', 'Khách yêu cầu hủy.', '2025-12-20'),
 (24, 15, 11, 2, 0, 10400000.00, 'paid', 'confirmed', 'Ông Thị Ngọc', '0901000013', 'ngoc.ong@example.com', 'Đã thanh toán.', '2025-12-19'),
 (25, 16, 11, 1, 0, 5200000.00, 'paid', 'confirmed', 'Phó Văn Phúc', '0901000014', 'phuc.pho@example.com', 'Đặt online.', '2025-12-18'),
 (26, 11, 12, 2, 1, 9700000.00, 'paid', 'cancelled', 'Ngô Thị Ích', '0901000009', 'ich.ngo@example.com', 'Khách hủy.', '2025-12-17'),
 (27, 12, 15, 2, 0, 2800000.00, 'paid', 'confirmed', 'Kiều Văn Khoa', '0901000010', 'khoa.kieu@example.com', 'Đi nghỉ cuối tuần.', '2025-12-16'),
 (28, 13, 16, 2, 1, 3850000.00, 'paid', 'confirmed', 'Mạc Thị Linh', '0901000011', 'linh.mac@example.com', 'Gia đình.', '2025-12-15'),
 (29, 14, 20, 2, 1, 11050000.00, 'paid', 'confirmed', 'Nhân Công Minh', '0901000012', 'minh.nhan@example.com', 'Phòng gần biển.', '2025-12-14'),
 (30, 15, 24, 2, 0, 7900000.00, 'paid', 'confirmed', 'Ông Thị Ngọc', '0901000013', 'ngoc.ong@example.com', 'Yêu cầu HDV giỏi.', '2025-12-13'),
 (31, 16, 28, 1, 1, 5400000.00, 'paid', 'confirmed', 'Phó Văn Phúc', '0901000014', 'phuc.pho@example.com', 'Gia đình 2 người.', '2025-12-12'),
 (32, 11, 32, 3, 1, 12850000.00, 'paid', 'confirmed', 'Ngô Thị Ích', '0901000009', 'ich.ngo@example.com', 'Đoàn 4 người.', '2025-12-11'),
 (33, 12, 37, 2, 0, 13400000.00, 'paid', 'confirmed', 'Kiều Văn Khoa', '0901000010', 'khoa.kieu@example.com', 'Kỷ niệm ngày cưới.', '2025-12-10'),
 (34, 13, 38, 2, 2, 16700000.00, 'paid', 'confirmed', 'Mạc Thị Linh', '0901000011', 'linh.mac@example.com', 'Gia đình 4 người.', '2025-12-09'),

 -- BOOKINGS năm 2025 (thêm rõ ràng)
 (35, 1, 4, 2, 1, 8750000.00, 'paid', 'confirmed', 'Nguyễn Văn An', '0901000001', 'an.nguyen@example.com', 'Du lịch năm 2025.', '2025-03-15'),
 (36, 2, 4, 1, 0, 4300000.00, 'paid', 'confirmed', 'Trần Thị Bình', '0901000002', 'binh.tran@example.com', 'Đặt sớm cho năm 2025.', '2025-02-10'),
 (37, 3, 5, 2, 0, 6500000.00, 'paid', 'confirmed', 'Lê Hoàng Nam', '0901000003', 'nam.le@example.com', 'Tháng 2 năm 2025.', '2025-02-15'),
 (38, 4, 11, 2, 1, 9700000.00, 'paid', 'confirmed', 'Phạm Thu Hà', '0901000004', 'ha.pham@example.com', 'Gia đình - năm 2025.', '2025-03-20'),
 (39, 5, 11, 1, 0, 4850000.00, 'paid', 'confirmed', 'Đỗ Minh Quân', '0901000005', 'quan.do@example.com', 'Solo travel 2025.', '2025-03-10'),
 (40, 6, 12, 2, 0, 9700000.00, 'refunded', 'cancelled', 'Hoàng Yến Nhi', '0901000006', 'nhi.hoang@example.com', 'Hủy tour năm 2025.', '2025-04-05'),
 (41, 7, 15, 2, 0, 2800000.00, 'paid', 'confirmed', 'Vũ Thành Long', '0901000007', 'long.vu@example.com', 'Ninh Bình 2025.', '2025-02-20'),
 (42, 8, 20, 2, 1, 11000000.00, 'paid', 'confirmed', 'Bùi Khánh Linh', '0901000008', 'linh.bui@example.com', 'Đà Nẵng 2025.', '2025-03-25'),
 (43, 1, 24, 1, 1, 5900000.00, 'paid', 'confirmed', 'Nguyễn Văn An', '0901000001', 'an.nguyen@example.com', 'Huế 2025.', '2025-02-18'),
 (44, 2, 28, 2, 0, 7800000.00, 'paid', 'confirmed', 'Trần Thị Bình', '0901000002', 'binh.tran@example.com', 'Đà Lạt 2025.', '2025-03-05'),
 (45, 3, 32, 2, 0, 12000000.00, 'paid', 'confirmed', 'Lê Hoàng Nam', '0901000003', 'nam.le@example.com', 'Nha Trang 2025.', '2025-03-28'),
 (46, 4, 37, 1, 1, 9900000.00, 'paid', 'confirmed', 'Phạm Thu Hà', '0901000004', 'ha.pham@example.com', 'Phú Quốc 2025.', '2025-02-08'),
 (47, 11, 6, 2, 0, 6750000.00, 'paid', 'confirmed', 'Ngô Thị Ích', '0901000009', 'ich.ngo@example.com', 'Hạ Long tháng 3 2025.', '2025-03-12'),
 (48, 12, 7, 3, 0, 12000000.00, 'paid', 'confirmed', 'Kiều Văn Khoa', '0901000010', 'khoa.kieu@example.com', 'Ninh Bình nhóm 3.', '2025-02-25'),
 (49, 13, 16, 2, 1, 3850000.00, 'paid', 'confirmed', 'Mạc Thị Linh', '0901000011', 'linh.mac@example.com', 'Gia đình 2025.', '2025-03-30'),
 (50, 14, 21, 2, 1, 11050000.00, 'paid', 'confirmed', 'Nhân Công Minh', '0901000012', 'minh.nhan@example.com', 'Đà Nẵng hè 2025.', '2025-04-10');

-- =====================
-- INSERT: WISHLIST (22 yêu thích)
-- =====================
INSERT INTO wishlist (id, user_id, tour_id) VALUES
 (1, 1, 2), (2, 1, 8),
 (3, 2, 1), (4, 2, 4),
 (5, 3, 6), (6, 3, 7),
 (7, 4, 1), (8, 4, 3),
 (9, 5, 4), (10, 5, 7),
 (11, 6, 6), (12, 6, 8),
 (13, 7, 3), (14, 7, 5),
 (15, 8, 2), (16, 8, 8),
 (17, 11, 1), (18, 12, 2),
 (19, 13, 4), (20, 14, 6),
 (21, 15, 7), (22, 16, 8);

-- =====================
-- INSERT: REVIEWS (15 đánh giá)
-- =====================
INSERT INTO reviews (id, user_id, tour_id, rating, comment) VALUES
 (1, 1, 1, 5, 'Cảnh đẹp, đồ ăn ngon, HDV nhiệt tình. Rất hài lòng.'),
 (2, 3, 2, 5, 'Fansipan rất đẹp, lịch trình hợp lý, thời tiết mát mẻ.'),
 (3, 4, 3, 4, 'Ninh Bình yên bình, phù hợp nghỉ cuối tuần. Khách sạn hơi xa trung tâm.'),
 (4, 8, 4, 5, 'Đà Nẵng - Hội An quá tuyệt, Cầu Vàng đẹp như tranh.'),
 (5, 2, 5, 4, 'Huế cổ kính, HDV kể chuyện lịch sử rất hay.'),
 (6, 3, 6, 5, 'Đà Lạt mát mẻ, nhiều góc sống ảo.'),
 (7, 5, 7, 4, 'Nha Trang biển đẹp, hải sản tươi, hơi đông khách.'),
 (8, 6, 8, 5, 'Phú Quốc nghỉ dưỡng tuyệt vời, resort đẹp, dịch vụ tốt.'),
 (9, 7, 1, 4, 'Hạ Long đẹp, nhưng di chuyển hơi mệt.'),
 (10, 8, 2, 5, 'Sapa mùa này rất đẹp, sẽ quay lại.'),
 (11, 1, 4, 5, 'Hội An về đêm rất lung linh, đồ ăn ngon.'),
 (12, 2, 6, 4, 'Đà Lạt khá đông nhưng vẫn rất chill.'),
 (13, 11, 1, 5, 'Hạ Long tuyệt vời, hài lòng về tất cả.'),
 (14, 12, 2, 4, 'Sapa đẹp, HDV tốt, thời tiết lạnh quá.'),
 (15, 14, 4, 5, 'Đà Nẵng quá tuyệt, Cầu Vàng đẹp.');

-- =====================
-- INSERT: TOUR_IMAGES (Hình ảnh các tour)
-- Dùng NULL trước, sau đó UPDATE với LOAD_FILE()
-- =====================
-- Tour 1: Hà Nội - Hạ Long
INSERT INTO tour_images (tour_id, image) VALUES
 (1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, NULL);

-- Tour 2: Hà Nội - Sapa
INSERT INTO tour_images (tour_id, image) VALUES
 (2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, NULL);

-- Tour 3: Ninh Bình
INSERT INTO tour_images (tour_id, image) VALUES
 (3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, NULL);

-- Tour 4: Đà Nẵng - Hội An
INSERT INTO tour_images (tour_id, image) VALUES
 (4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, NULL);

-- Tour 5: Huế
INSERT INTO tour_images (tour_id, image) VALUES
 (5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, NULL);

-- Tour 6: Đà Lạt
INSERT INTO tour_images (tour_id, image) VALUES
 (6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, NULL);

-- Tour 7: Nha Trang
INSERT INTO tour_images (tour_id, image) VALUES
 (7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, NULL);

-- Tour 8: Phú Quốc
INSERT INTO tour_images (tour_id, image) VALUES
 (8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, NULL);

-- =====================
-- UPDATE IMAGES USING LOAD_FILE (Cách 2)
-- Chạy những lệnh này sau khi INSERT thành công
-- =====================
-- Hà Nội - Hạ Long
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong1.jpg') WHERE tour_id = 1 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 1 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong2.jpg') WHERE tour_id = 1 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 1 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong3.jpg') WHERE tour_id = 1 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 1 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong4.jpg') WHERE tour_id = 1 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 1 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong5.jpg') WHERE tour_id = 1 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 1 LIMIT 4,1) t);

-- Hà Nội - Sapa
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa1.jpg') WHERE tour_id = 2 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 2 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa2.jpeg') WHERE tour_id = 2 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 2 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa3.jpg') WHERE tour_id = 2 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 2 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa4.jpg') WHERE tour_id = 2 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 2 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa5.jpg') WHERE tour_id = 2 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 2 LIMIT 4,1) t);

-- Ninh Bình
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh1.jpg') WHERE tour_id = 3 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 3 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh2.jpg') WHERE tour_id = 3 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 3 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh3.jpg') WHERE tour_id = 3 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 3 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh4.jpg') WHERE tour_id = 3 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 3 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh5.jpg') WHERE tour_id = 3 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 3 LIMIT 4,1) t);

-- Đà Nẵng - Hội An
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian1.jpg') WHERE tour_id = 4 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 4 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian2.jpg') WHERE tour_id = 4 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 4 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian3.jpg') WHERE tour_id = 4 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 4 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian4.jpg') WHERE tour_id = 4 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 4 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian5.jpg') WHERE tour_id = 4 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 4 LIMIT 4,1) t);

-- Huế
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hue\\hue1.jpeg') WHERE tour_id = 5 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 5 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hue\\hue2.jpg') WHERE tour_id = 5 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 5 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hue\\hue3.jpg') WHERE tour_id = 5 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 5 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hue\\hue4.jpg') WHERE tour_id = 5 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 5 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Hue\\hue5.jpg') WHERE tour_id = 5 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 5 LIMIT 4,1) t);

-- Đà Lạt
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat1.jpg') WHERE tour_id = 6 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 6 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat2.jpg') WHERE tour_id = 6 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 6 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat3.jpg') WHERE tour_id = 6 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 6 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat4.jpg') WHERE tour_id = 6 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 6 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat5.jpg') WHERE tour_id = 6 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 6 LIMIT 4,1) t);

-- Nha Trang
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang1.jpg') WHERE tour_id = 7 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 7 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang2.jpg') WHERE tour_id = 7 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 7 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang3.jpg') WHERE tour_id = 7 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 7 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang4.jpg') WHERE tour_id = 7 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 7 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang5.jpg') WHERE tour_id = 7 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 7 LIMIT 4,1) t);

-- Phú Quốc
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc1.jpg') WHERE tour_id = 8 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 8 LIMIT 1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc2.jpg') WHERE tour_id = 8 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 8 LIMIT 1,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc3.jpg') WHERE tour_id = 8 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 8 LIMIT 2,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc4.jpg') WHERE tour_id = 8 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 8 LIMIT 3,1) t);
UPDATE tour_images SET image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc5.jpg') WHERE tour_id = 8 AND id IN (SELECT id FROM (SELECT id FROM tour_images WHERE tour_id = 8 LIMIT 4,1) t);

-- =====================
-- UPDATE: TOUR COVER IMAGES (Ảnh bìa tour)
-- =====================
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\HaLong\\halong1.jpg') WHERE id = 1;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\Sapa\\sapa1.jpg') WHERE id = 2;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh1.jpg') WHERE id = 3;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian1.jpg') WHERE id = 4;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\Hue\\hue1.jpeg') WHERE id = 5;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\DaLat\\dalat1.jpg') WHERE id = 6;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang1.jpg') WHERE id = 7;
UPDATE tours SET cover_image = LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc1.jpg') WHERE id = 8;

-- =====================
-- DATA SUMMARY
-- =====================
-- Users: 16 (gồm 10 khách cũ + 6 khách mới + 2 admin)
-- Services: 8 (khách sạn, vận chuyển, hướng dẫn, ăn uống, bảo hiểm)
-- Tours: 8 (các điểm đến: Hạ Long, Sapa, Ninh Bình, Đà Nẵng, Huế, Đà Lạt, Nha Trang, Phú Quốc)
-- Tour Itineraries: 26 (lịch trình chi tiết cho từng ngày)
-- Tour Departures: 38 (20 năm 2026 + 18 năm 2025)
-- Tour Services: 31 (liên kết dịch vụ với tour)
-- Bookings: 34 (19 năm 2026 + 15 năm 2025)
-- Wishlist: 22 (tour yêu thích của khách)
-- Reviews: 15 (đánh giá từ khách)
-- =====================
