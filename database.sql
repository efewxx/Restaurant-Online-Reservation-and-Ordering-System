-- Bu dosyayı phpMyAdmin üzerinden "Import" (İçe Aktar) diyerek çalıştırabilirsiniz.

CREATE DATABASE IF NOT EXISTS restaurant_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE restaurant_db;

-- 1. users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. categories table
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL 
);

-- 3. menu table
CREATE TABLE IF NOT EXISTS menu (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    description TEXT,
    category_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

--4. reservation table
CREATE TABLE IF NOT EXISTS reservation(
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    number_of_people INT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


-- Varsayılan bir Admin hesabı (Şifre: admin123)
-- Not: Şifreleme (password_hash) PHP tarafında yapılacaktır.
INSERT INTO users (name, email, password, role) VALUES 
('Sistem Yöneticisi', 'admin@tracker.com', '$2y$10$YGo9LpxZ7f1Fp.v0G7aE2u2F1uW1u1u1u1u1u1u1u1u1u1u1', 'admin');
