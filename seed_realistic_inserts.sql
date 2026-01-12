USE db_web_du_lich;

-- =====================
-- USERS
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
 (10,'Admin Hệ Thống',    '0901999002', 'admin2@example.com',         '123456', 'admin',    1);

-- =====================
-- SERVICES
-- =====================
-- service_code được trigger sinh tự động
INSERT INTO services (id, name, slug, description, icon, status) VALUES
 (1, 'Khách sạn 3 sao',             'khach-san-3-sao',     'Lưu trú khách sạn tiêu chuẩn 3 sao.',         NULL, 1),
 (2, 'Khách sạn 4 sao',             'khach-san-4-sao',     'Lưu trú khách sạn tiêu chuẩn 4 sao.',         NULL, 1),
 (3, 'Khách sạn 5 sao',             'khach-san-5-sao',     'Resort/khách sạn cao cấp 5 sao.',            NULL, 1),
 (4, 'Xe đưa đón sân bay/bến xe',   'xe-dua-don',          'Xe đưa đón tại điểm hẹn, xe đời mới.',       NULL, 1),
 (5, 'Hướng dẫn viên tiếng Việt',   'hdv-tieng-viet',      'HDV tiếng Việt theo suốt chương trình.',     NULL, 1),
 (6, 'Hướng dẫn viên tiếng Anh',    'hdv-tieng-anh',       'HDV tiếng Anh cho khách quốc tế.',           NULL, 1),
 (7, 'Ăn uống theo chương trình',   'an-uong',             'Bao gồm bữa sáng/trưa/tối theo chương trình.',NULL,1),
 (8, 'Bảo hiểm du lịch',            'bao-hiem-du-lich',    'Bảo hiểm du lịch trọn gói.',                  NULL, 1);

-- =====================
-- TOURS
-- =====================
-- tour_code được trigger sinh tự động
INSERT INTO tours (id, name, slug, description, location, region, duration, price_default, price_child, cover_image) VALUES
 (1, 'Hà Nội - Hạ Long 3N2Đ',
   'ha-noi-ha-long-3n2d',
   'Khởi hành từ Hà Nội, tham quan Vịnh Hạ Long, ngủ tàu, khám phá hang động và thưởng thức hải sản.',
   'Hà Nội', 'Miền Bắc', '3 ngày 2 đêm', 3500000.00, 2200000.00, LOAD_FILE('C:\\AnhTour\\HaLong\\halong1.jpg')),
 (2, 'Hà Nội - Sapa - Fansipan 4N3Đ',
   'ha-noi-sapa-fansipan-4n3d',
   'Khám phá Sapa, trekking bản làng, chinh phục đỉnh Fansipan bằng cáp treo.',
   'Hà Nội', 'Miền Bắc', '4 ngày 3 đêm', 5200000.00, 3000000.00, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa1.jpg')),
 (3, 'Ninh Bình - Tràng An - Tam Cốc 2N1Đ',
   'ninh-binh-trang-an-tam-coc',
   'Thuyền trên sông Tràng An, tham quan Tam Cốc - Bích Động và cố đô Hoa Lư.',
   'Ninh Bình', 'Miền Bắc', '2 ngày 1 đêm', 1900000.00, 1200000.00, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh1.jpg')),
 (4, 'Đà Nẵng - Hội An - Bà Nà 4N3Đ',
   'da-nang-hoi-an-ba-na',
   'Tham quan biển Mỹ Khê, phố cổ Hội An, Bà Nà Hills và Cầu Vàng.',
   'Đà Nẵng', 'Miền Trung', '4 ngày 3 đêm', 4500000.00, 2600000.00, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian1.jpg')),
 (5, 'Huế - Động Phong Nha 3N2Đ',
   'hue-dong-phong-nha',
   'Tham quan cố đô Huế, Đại Nội, chùa Thiên Mụ và động Phong Nha.',
   'Huế', 'Miền Trung', '3 ngày 2 đêm', 4200000.00, 2500000.00, LOAD_FILE('C:\\AnhTour\\Hue\\hue1.jpeg')),
 (6, 'Đà Lạt - Thành phố ngàn hoa 3N2Đ',
   'da-lat-thanh-pho-ngan-hoa',
   'Không khí se lạnh, vườn hoa, hồ Tuyền Lâm, nông trại dâu, quán cà phê view đồi núi.',
   'Đà Lạt', 'Miền Nam', '3 ngày 2 đêm', 3300000.00, 2000000.00, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat1.jpg')),
 (7, 'Nha Trang - Biển đảo 3N2Đ',
   'nha-trang-bien-dao',
   'Tắm biển, tham quan đảo, lặn ngắm san hô và thưởng thức hải sản.',
   'Nha Trang', 'Miền Nam', '3 ngày 2 đêm', 3600000.00, 2100000.00, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang1.jpg')),
 (8, 'Phú Quốc - Thiên đường nghỉ dưỡng 4N3Đ',
   'phu-quoc-thien-duong-nghi-duong',
   'Nghỉ dưỡng resort, VinWonders, Safari, câu cá, lặn ngắm san hô.',
   'Phú Quốc', 'Miền Nam', '4 ngày 3 đêm', 7200000.00, 4200000.00, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc1.jpg'));
-- =====================
-- TOUR_ITINERARIES (lịch trình rõ ràng cho từng tour)
-- =====================
INSERT INTO tour_itineraries (id, tour_id, day_number, description) VALUES
 -- Tour 1: Hà Nội - Hạ Long 3N2Đ
 (1, 1, 1, 'Đón khách tại Hà Nội, khởi hành đi Hạ Long, lên du thuyền, ăn trưa và tham quan hang động.'),
 (2, 1, 2, 'Dậy sớm ngắm bình minh trên vịnh, chèo kayak, thăm làng chài nổi.'),
 (3, 1, 3, 'Ăn sáng trên tàu, trả phòng, trở về Hà Nội, kết thúc chương trình.'),

 -- Tour 2: Hà Nội - Sapa - Fansipan 4N3Đ
 (4, 2, 1, 'Đón khách tại Hà Nội, di chuyển lên Sapa, nhận phòng, dạo chơi thị trấn, chợ đêm.'),
 (5, 2, 2, 'Tham quan bản Cát Cát, trekking nhẹ, tìm hiểu văn hóa bản địa.'),
 (6, 2, 3, 'Đi cáp treo lên đỉnh Fansipan, chụp hình, thưởng ngoạn cảnh quan.'),
 (7, 2, 4, 'Tự do mua sắm, trả phòng, về lại Hà Nội.'),

 -- Tour 3: Ninh Bình - Tràng An - Tam Cốc 2N1Đ
 (8, 3, 1, 'Xuất phát từ Hà Nội, tham quan cố đô Hoa Lư, chùa Bái Đính.'),
 (9, 3, 2, 'Đi thuyền Tràng An/Tam Cốc, ngắm cảnh núi đá vôi và đồng lúa, trở về Hà Nội.'),

 -- Tour 4: Đà Nẵng - Hội An - Bà Nà 4N3Đ
 (10, 4, 1, 'Đón tại sân bay/ga Đà Nẵng, check-in khách sạn, tham quan biển Mỹ Khê.'),
 (11, 4, 2, 'Tham quan Bà Nà Hills, Cầu Vàng, vui chơi khu Fantasy Park.'),
 (12, 4, 3, 'Tham quan phố cổ Hội An, chụp ảnh đèn lồng, trải nghiệm ẩm thực.'),
 (13, 4, 4, 'Tự do mua sắm, trả phòng, tiễn khách ra sân bay.'),

 -- Tour 5: Huế - Động Phong Nha 3N2Đ
 (14, 5, 1, 'Đón khách tại Huế, tham quan Đại Nội, chùa Thiên Mụ, thưởng thức ẩm thực Huế.'),
 (15, 5, 2, 'Khởi hành đi Quảng Bình, tham quan động Phong Nha/Thiên Đường.'),
 (16, 5, 3, 'Trả khách về Huế, kết thúc chương trình.'),

 -- Tour 6: Đà Lạt - Thành phố ngàn hoa 3N2Đ
 (17, 6, 1, 'Đón khách tại Đà Lạt, tham quan quảng trường Lâm Viên, chợ đêm Đà Lạt.'),
 (18, 6, 2, 'Thăm hồ Tuyền Lâm, Thiền viện Trúc Lâm, vườn hoa và nông trại dâu.'),
 (19, 6, 3, 'Tự do mua sắm đặc sản, trả phòng, tiễn khách ra sân bay.'),

 -- Tour 7: Nha Trang - Biển đảo 3N2Đ
 (20, 7, 1, 'Đón khách tại Nha Trang, tham quan Tháp Bà Ponagar, tắm bùn khoáng.'),
 (21, 7, 2, 'Lên tàu tham quan đảo, lặn biển ngắm san hô, tắm biển.'),
 (22, 7, 3, 'Tự do mua sắm, trả phòng, kết thúc chương trình.'),

 -- Tour 8: Phú Quốc - Thiên đường nghỉ dưỡng 4N3Đ
 (23, 8, 1, 'Đón khách, nhận phòng resort, nghỉ ngơi, tắm biển.'),
 (24, 8, 2, 'Tham quan VinWonders hoặc Safari, vui chơi giải trí.'),
 (25, 8, 3, 'Tham gia tour câu cá, lặn ngắm san hô.'),
 (26, 8, 4, 'Tự do buổi sáng, trả phòng, tiễn khách ra sân bay.');

-- =====================
-- TOUR_DEPARTURES (nhiều đợt khởi hành, trạng thái rõ ràng)
-- =====================
-- departure_code được trigger sinh tự động
INSERT INTO tour_departures (id, tour_id, departure_location, departure_date,
               price_moving, price_moving_child,
               seats_total, seats_available, status) VALUES
 -- Tour 1
 (1, 1, 'Hà Nội',  '2026-02-10', 800000.00, 500000.00, 30, 24, 'open'),
 (2, 1, 'Hà Nội',  '2026-02-24', 800000.00, 500000.00, 30,  5, 'open'),
 (3, 1, 'Hà Nội',  '2026-03-10', 850000.00, 520000.00, 30,  0, 'full'),

 -- Tour 2
 (4, 2, 'Hà Nội',  '2026-02-18', 900000.00, 550000.00, 25, 18, 'open'),
 (5, 2, 'Hà Nội',  '2026-03-05', 950000.00, 580000.00, 25, 10, 'open'),
 (6, 2, 'Hà Nội',  '2026-03-25', 950000.00, 580000.00, 25,  0, 'full'),

 -- Tour 3
 (7, 3, 'Hà Nội',  '2026-02-15', 400000.00, 250000.00, 40, 32, 'open'),
 (8, 3, 'Hà Nội',  '2026-03-02', 450000.00, 260000.00, 40, 12, 'open'),

 -- Tour 4
 (9, 4, 'Đà Nẵng','2026-02-20', 700000.00, 450000.00, 30, 20, 'open'),
 (10,4, 'Đà Nẵng','2026-03-10', 750000.00, 470000.00, 30,  0, 'full'),
 (11,4, 'Đà Nẵng','2026-03-25', 750000.00, 470000.00, 30, 15, 'open'),

 -- Tour 5
 (12,5, 'Huế',    '2026-02-22', 600000.00, 380000.00, 20, 14, 'open'),
 (13,5, 'Huế',    '2026-03-12', 650000.00, 400000.00, 20,  0, 'full'),

 -- Tour 6
 (14,6, 'Đà Lạt','2026-02-18', 500000.00, 320000.00, 25, 19, 'open'),
 (15,6, 'Đà Lạt','2026-03-08', 500000.00, 320000.00, 25,  8, 'open'),

 -- Tour 7
 (16,7, 'Nha Trang','2026-02-25', 650000.00, 380000.00, 35, 22, 'open'),
 (17,7, 'Nha Trang','2026-03-15', 700000.00, 400000.00, 35,  0, 'full'),

 -- Tour 8
 (18,8, 'Phú Quốc','2026-02-28', 950000.00, 600000.00, 20, 12, 'open'),
 (19,8, 'Phú Quốc','2026-03-20', 980000.00, 620000.00, 20,  6, 'open'),
 (20,8, 'Phú Quốc','2026-04-05',1000000.00, 650000.00, 20,  0, 'full');

-- =====================
-- TOUR_SERVICES (dịch vụ đi kèm từng tour)
-- =====================
INSERT INTO tour_services (id, tour_id, service_id) VALUES
 -- Tour 1: Hạ Long
 (1, 1, 2),  -- KS 4 sao
 (2, 1, 4),  -- Xe đưa đón
 (3, 1, 5),  -- HDV TV
 (4, 1, 7),  -- Ăn uống

 -- Tour 2: Sapa
 (5, 2, 1),  -- KS 3 sao
 (6, 2, 4),
 (7, 2, 5),
 (8, 2, 8),  -- Bảo hiểm

 -- Tour 3: Ninh Bình
 (9, 3, 1),
 (10,3, 4),
 (11,3, 7),

 -- Tour 4: Đà Nẵng - Hội An - Bà Nà
 (12,4, 2),
 (13,4, 4),
 (14,4, 5),
 (15,4, 7),

 -- Tour 5: Huế - Phong Nha
 (16,5, 2),
 (17,5, 4),
 (18,5, 5),
 (19,5, 8),

 -- Tour 6: Đà Lạt
 (20,6, 1),
 (21,6, 4),
 (22,6, 7),

 -- Tour 7: Nha Trang
 (23,7, 2),
 (24,7, 4),
 (25,7, 5),
 (26,7, 7),

 -- Tour 8: Phú Quốc
 (27,8, 3),
 (28,8, 4),
 (29,8, 6),
 (30,8, 7),
 (31,8, 8);

-- =====================
-- BOOKINGS (nhiều trạng thái: pending/confirmed/cancelled/refunded)
-- =====================
-- booking_code được trigger sinh tự động
INSERT INTO bookings (
  id, user_id, departure_id,
  adults, children, total_price,
  payment_status, status,
  contact_name, contact_phone, contact_email, note
) VALUES
 -- Tour 1, departure 1
 (1, 1, 1, 2, 1, 9500000.00, 'paid',    'confirmed', 'Nguyễn Văn An',  '0901000001', 'an.nguyen@example.com',   'Yêu cầu phòng 3 người, gần cửa sổ.'),
 (2, 2, 1, 1, 0, 4300000.00, 'paid',    'confirmed', 'Trần Thị Bình',  '0901000002', 'binh.tran@example.com',   'Đã thanh toán, xác nhận đặt chỗ.'),,

 -- Tour 1, departure 2 (sắp đầy)
 (3, 3, 2, 3, 0, 10800000.00, 'paid',   'confirmed', 'Lê Hoàng Nam',    '0901000003', 'nam.le@example.com',     'Nhóm bạn 3 người.'),

 -- Tour 2, departure 4
 (4, 4, 4, 2, 2, 15200000.00, 'paid',   'confirmed', 'Phạm Thu Hà',     '0901000004', 'ha.pham@example.com',    'Gia đình có trẻ nhỏ.'),
 (5, 5, 4, 1, 0, 5200000.00,  'paid',   'confirmed', 'Đỗ Minh Quân',    '0901000005', 'quan.do@example.com',    'Đã thanh toán. Cần hóa đơn công ty.'),

 -- Tour 2, departure 5 (huỷ, hoàn tiền)
 (6, 6, 5, 2, 0, 10400000.00, 'refunded','cancelled','Hoàng Yến Nhi',   '0901000006', 'nhi.hoang@example.com',  'Khách hủy do công tác đột xuất.'),

 -- Tour 3, departure 7
 (7, 7, 7, 2, 0, 3800000.00,  'paid',   'confirmed', 'Vũ Thành Long',   '0901000007', 'long.vu@example.com',    'Đi nghỉ cuối tuần.'),

 -- Tour 4, departure 9
 (8, 8, 9, 2, 1, 11800000.00, 'paid',   'confirmed', 'Bùi Khánh Linh',  '0901000008', 'linh.bui@example.com',   'Phòng có view biển nếu được.'),

 -- Tour 4, departure 11 (chờ thanh toán)
 (9, 1,11, 1, 1, 7800000.00,  'paid',   'confirmed', 'Nguyễn Văn An',   '0901000001', 'an.nguyen@example.com',  'Đã xác nhận, đã thanh toán.'),

 -- Tour 5, departure 12
 (10,2,12, 2, 0, 8400000.00,  'paid',   'confirmed', 'Trần Thị Bình',   '0901000002', 'binh.tran@example.com',  'Muốn ở phòng giường đôi.'),

 -- Tour 6, departure 14
 (11,3,14, 2, 0, 6600000.00,  'paid',   'confirmed', 'Lê Hoàng Nam',    '0901000003', 'nam.le@example.com',     'Trăng mật.'),
 (12,4,14, 1, 1, 5200000.00,  'paid',   'confirmed', 'Phạm Thu Hà',     '0901000004', 'ha.pham@example.com',    'Đã xác nhận, cần phòng có nôi em bé.'),

 -- Tour 7, departure 16
 (13,5,16, 3, 1, 16800000.00, 'paid',   'confirmed', 'Đỗ Minh Quân',    '0901000005', 'quan.do@example.com',    'Team building công ty.'),

 -- Tour 8, departure 18
 (14,6,18, 2, 0, 14400000.00, 'paid',   'confirmed', 'Hoàng Yến Nhi',   '0901000006', 'nhi.hoang@example.com',  'Kỷ niệm ngày cưới.'),
 (15,7,18, 2, 2, 19600000.00, 'paid',   'confirmed', 'Vũ Thành Long',   '0901000007', 'long.vu@example.com',    'Đã xác nhận và thanh toán.'),

 -- Một số booking khách lẻ (gán vào user có sẵn, contact trùng thông tin user)
 (16,1, 8, 2, 0, 3800000.00, 'paid',    'confirmed', 'Nguyễn Văn An',   '0901000001','an.nguyen@example.com','Đặt trực tiếp tại văn phòng.'),
 (17,2,15, 1, 1, 5200000.00, 'unpaid',  'pending',   'Trần Thị Bình',   '0901000002','binh.tran@example.com','Đặt online, đã thanh toán.');,
 (18,3,19, 4, 0, 28800000.00,'paid',    'confirmed', 'Lê Hoàng Nam',    '0901000003','nam.le@example.com','Đoàn incentive 4 người.');

-- =====================
-- WISHLIST (tour yêu thích của từng user)
-- =====================
-- wish_code được trigger sinh tự động
INSERT INTO wishlist (id, user_id, tour_id) VALUES
 (1, 1, 2),  -- An thích Sapa
 (2, 1, 8),  -- An thích Phú Quốc
 (3, 2, 1),
 (4, 2, 4),
 (5, 3, 6),
 (6, 3, 7),
 (7, 4, 1),
 (8, 4, 3),
 (9, 5, 4),
 (10,5, 7),
 (11,6, 6),
 (12,6, 8),
 (13,7, 3),
 (14,7, 5),
 (15,8, 2),
 (16,8, 8);

-- =====================
-- REVIEWS (đánh giá sau chuyến đi)
-- =====================
-- review_code được trigger sinh tự động
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
 (10,8, 2, 5, 'Sapa mùa này rất đẹp, sẽ quay lại.'),
 (11,1, 4, 5, 'Hội An về đêm rất lung linh, đồ ăn ngon.'),
 (12,2, 6, 4, 'Đà Lạt khá đông nhưng vẫn rất chill.');


-- Tour 1: Hà Nội - Hạ Long (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (1, LOAD_FILE('C:\\AnhTour\\HaLong\\halong1.jpg')),
 (1, LOAD_FILE('C:\\AnhTour\\HaLong\\halong2.jpg')),
 (1, LOAD_FILE('C:\\AnhTour\\HaLong\\halong3.jpg')),
 (1, LOAD_FILE('C:\\AnhTour\\HaLong\\halong4.jpg')),
 (1, LOAD_FILE('C:\\AnhTour\\HaLong\\halong5.jpg'));

-- Tour 2: Hà Nội - Sapa (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (2, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa1.jpg')),
 (2, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa2.jpeg')),
 (2, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa3.jpg')),
 (2, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa4.jpg')),
 (2, LOAD_FILE('C:\\AnhTour\\Sapa\\sapa5.jpg'));

-- Tour 3: Ninh Bình (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (3, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh1.jpg')),
 (3, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh2.jpg')),
 (3, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh3.jpg')),
 (3, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh4.jpg')),
 (3, LOAD_FILE('C:\\AnhTour\\NinhBinh\\ninhbinh5.jpg'));

-- Tour 4: Đà Nẵng - Hội An (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (4, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian1.jpg')),
 (4, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian2.jpg')),
 (4, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian3.jpg')),
 (4, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian4.jpg')),
 (4, LOAD_FILE('C:\\AnhTour\\Hoi An\\hoian5.jpg'));

-- Tour 5: Huế (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (5, LOAD_FILE('C:\\AnhTour\\Hue\\hue1.jpeg')),
 (5, LOAD_FILE('C:\\AnhTour\\Hue\\hue2.jpg')),
 (5, LOAD_FILE('C:\\AnhTour\\Hue\\hue3.jpg')),
 (5, LOAD_FILE('C:\\AnhTour\\Hue\\hue4.jpg')),
 (5, LOAD_FILE('C:\\AnhTour\\Hue\\hue5.jpg'));

-- Tour 6: Đà Lạt (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (6, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat1.jpg')),
 (6, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat2.jpg')),
 (6, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat3.jpg')),
 (6, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat4.jpg')),
 (6, LOAD_FILE('C:\\AnhTour\\DaLat\\dalat5.jpg'));

-- Tour 7: Nha Trang (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (7, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang1.jpg')),
 (7, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang2.jpg')),
 (7, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang3.jpg')),
 (7, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang4.jpg')),
 (7, LOAD_FILE('C:\\AnhTour\\NhaTrang\\NhaTrang5.jpg'));

-- Tour 8: Phú Quốc (LOAD_FILE)
INSERT INTO tour_images (tour_id, image) VALUES
 (8, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc1.jpg')),
 (8, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc2.jpg')),
 (8, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc3.jpg')),
 (8, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc4.jpg')),
 (8, LOAD_FILE('C:\\AnhTour\\Phu Quoc\\phuquoc5.jpg'));



