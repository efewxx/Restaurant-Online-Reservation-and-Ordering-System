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
    image_url VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

-- 4. reservation table
CREATE TABLE IF NOT EXISTS reservation(
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    number_of_people INT NOT NULL,
    user_name TEXT NOT NULL,
    user_surname TEXT NOT NULL,
    user_phone INT NOT NULL,
    user_description TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 5. orders table
CREATE TABLE IF NOT EXISTS orders(
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    order_status VARCHAR(20) DEFAULT 'preparing',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 6. order items table
CREATE TABLE IF NOT EXISTS order_items(
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

TRUNCATE TABLE menu;

INSERT IGNORE INTO users (name, email, password, role) VALUES 
('Sistem Yöneticisi', 'admin@tracker.com', '$2y$10$YGo9LpxZ7f1Fp.v0G7aE2u2F1uWlulu1u1u1u1u1u1u1u1ul1', 'admin');

INSERT IGNORE INTO categories (category_name) VALUES ('main courses'), ('Drinks'), ('Desserts');

-- Eğer üstteki adımlar işe yaramazsa, sadece bu sorguyu dene kanka:
TRUNCATE TABLE menu;

INSERT INTO menu (product_name, Price, description, category_id, user_id) VALUES

('Meatballs', 450.00, 'Delicious meatballs with special sauce', 1, (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),

('Ayran', 50.00, 'A refreshing, traditional Turkish drink made of chilled yogurt, water, and a pinch of salt.', 2, (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),

('Traditional Baklava', 250.00, 'Crispy, golden layers of phyllo pastry packed with crushed pistachios and drenched in a light, fragrant sweet syrup.', 3, (SELECT user_id FROM users WHERE role='admin' LIMIT 1));