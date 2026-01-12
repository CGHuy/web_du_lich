CREATE DATABASE IF NOT EXISTS db_web_du_lich
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_web_du_lich;

-- 1. users
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
user_code VARCHAR(20) UNIQUE,
fullname VARCHAR(255) NOT NULL,
phone VARCHAR(20) NOT NULL UNIQUE,
email VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
status TINYINT(1) NOT NULL DEFAULT 1 CHECK (status IN (0,1))
);

-- 2. tours
CREATE TABLE tours (
id INT AUTO_INCREMENT PRIMARY KEY,
tour_code VARCHAR(20) UNIQUE,
name VARCHAR(255) NOT NULL,
slug VARCHAR(255) DEFAULT NULL UNIQUE,
description TEXT DEFAULT NULL,
location VARCHAR(100) NOT NULL,
region VARCHAR(100) NOT NULL,
duration VARCHAR(100) NOT NULL,
price_default DECIMAL(12,2) NOT NULL DEFAULT 0.00,
price_child DECIMAL(12,2) NOT NULL DEFAULT 0.00,
cover_image LONGBLOB NOT NULL
);

-- 3. tour_images
CREATE TABLE tour_images (
id INT AUTO_INCREMENT PRIMARY KEY,
tour_id INT NOT NULL,
image LONGBLOB NOT NULL,

     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE

);

-- 4. tour_itineraries
CREATE TABLE tour_itineraries (
id INT AUTO_INCREMENT PRIMARY KEY,
tour_id INT NOT NULL,
day_number INT NOT NULL CHECK(day_number > 0),
description TEXT DEFAULT NULL,

     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
     UNIQUE KEY uk_tour_day (tour_id, day_number)

);

-- 5. tour_departures
CREATE TABLE tour_departures (
id INT AUTO_INCREMENT PRIMARY KEY,
departure_code VARCHAR(20) UNIQUE,
tour_id INT NOT NULL,
departure_location VARCHAR(100) NOT NULL,
departure_date DATE NOT NULL,

price_moving DECIMAL(12,2) NOT NULL DEFAULT 0.00,
price_moving_child DECIMAL(12,2) NOT NULL DEFAULT 0.00,

seats_total INT NOT NULL DEFAULT 1,
seats_available INT NOT NULL DEFAULT 1,
status ENUM('open','closed','full') DEFAULT 'open',

     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
     UNIQUE KEY uk_tour_date (tour_id, departure_date)

);

-- 6. services
CREATE TABLE services (
id INT AUTO_INCREMENT PRIMARY KEY,
service_code VARCHAR(20) UNIQUE,
name VARCHAR(255) NOT NULL,
slug VARCHAR(255) DEFAULT NULL UNIQUE,
description TEXT DEFAULT NULL,
icon LONGBLOB DEFAULT NULL,
status TINYINT(1) DEFAULT 1 CHECK(status IN (0,1))
);

-- 7. tour_services
CREATE TABLE tour_services (
id INT AUTO_INCREMENT PRIMARY KEY,
tour_id INT NOT NULL,
service_id INT NOT NULL,

     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
     FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
     UNIQUE KEY uk_tour_service (tour_id, service_id)

);

-- 8. bookings (TÁCH NGƯỜI LỚN / TRẺ EM)
CREATE TABLE bookings (
id INT AUTO_INCREMENT PRIMARY KEY,
booking_code VARCHAR(20) UNIQUE,
user_id INT NULL,
departure_id INT NOT NULL,

adults INT NOT NULL DEFAULT 1 CHECK(adults > 0),
children INT NOT NULL DEFAULT 0 CHECK(children >= 0),

total_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,

payment_status ENUM('paid','refunded') NOT NULL DEFAULT 'paid',
status ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',

contact_name VARCHAR(255) NOT NULL,
contact_phone VARCHAR(20) NOT NULL,
contact_email VARCHAR(255) NOT NULL,
note TEXT DEFAULT NULL,

created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
     FOREIGN KEY (departure_id) REFERENCES tour_departures(id) ON DELETE RESTRICT

);

-- 9. reviews
CREATE TABLE reviews (
id INT AUTO_INCREMENT PRIMARY KEY,
review_code VARCHAR(20) UNIQUE,
user_id INT NOT NULL,
tour_id INT NOT NULL,
rating TINYINT UNSIGNED NOT NULL CHECK(rating BETWEEN 1 AND 5),
comment TEXT DEFAULT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
     UNIQUE KEY uk_user_tour_review (user_id, tour_id)

);

-- 10. wishlist
CREATE TABLE wishlist (
id INT AUTO_INCREMENT PRIMARY KEY,
wish_code VARCHAR(20) UNIQUE,
user_id INT NOT NULL,
tour_id INT NOT NULL,

     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
     FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
     UNIQUE KEY uk_wishlist (user_id, tour_id)

);

-- =====================
-- TRIGGERS SINH CODE (an toàn cho MySQL/MariaDB)
-- =====================
DELIMITER //

CREATE TRIGGER trg_users_code_bi
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
SET NEW.user_code = CONCAT('USR', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM users), 5, '0'));
END;//

CREATE TRIGGER trg_tours_code_bi
BEFORE INSERT ON tours
FOR EACH ROW
BEGIN
SET NEW.tour_code = CONCAT('TOUR', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM tours), 5, '0'));
END;//

CREATE TRIGGER trg_departures_code_bi
BEFORE INSERT ON tour_departures
FOR EACH ROW
BEGIN
SET NEW.departure_code = CONCAT('DEP', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM tour_departures), 5, '0'));
END;//

CREATE TRIGGER trg_services_code_bi
BEFORE INSERT ON services
FOR EACH ROW
BEGIN
SET NEW.service_code = CONCAT('SRV', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM services), 5, '0'));
END;//

CREATE TRIGGER trg_bookings_code_bi
BEFORE INSERT ON bookings
FOR EACH ROW
BEGIN
SET NEW.booking_code = CONCAT('BOK', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM bookings), 5, '0'));
END;//

CREATE TRIGGER trg_reviews_code_bi
BEFORE INSERT ON reviews
FOR EACH ROW
BEGIN
SET NEW.review_code = CONCAT('RVS', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM reviews), 5, '0'));
END;//

CREATE TRIGGER trg_wishlist_code_bi
BEFORE INSERT ON wishlist
FOR EACH ROW
BEGIN
SET NEW.wish_code = CONCAT('WISH', LPAD((SELECT IFNULL(MAX(id),0)+1 FROM wishlist), 5, '0'));
END;//

DELIMITER ;
