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


-- Varsayılan bir Admin hesabı (Şifre: admin123)
-- Not: Şifreleme (password_hash) PHP tarafında yapılacaktır.
INSERT INTO users (name, email, password, role) VALUES 
('Sistem Yöneticisi', 'admin@tracker.com', '$2y$10$YGo9LpxZ7f1Fp.v0G7aE2u2F1uW1u1u1u1u1u1u1u1u1u1u1', 'admin');

INSERT INTO categories (category_name) VALUES ('main courses'), ('Drinks'), ('Desserts');
INSERT INTO menu (product_name, Price, description, category_id, user_id) 
VALUES ('meatbaLLls', 450.00, 'Delicious meatballs with special sauce', 1, (SELECT user_id FROM users WHERE role='admin' LIMIT 1));

-- Önce karmaşayı temizleyelim (Sadece menüyü temizliyoruz)
DELETE FROM menu WHERE product_name != 'meatbaLLls';

-- MAIN COURSES (Otomatik Kategori Bulucu ile)
INSERT INTO menu (product_name, Price, description, category_id, user_id) VALUES 
('Grilled Ribeye Steak', 550.00, 'Served with roasted vegetables and mashed potatoes.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Classic Cheeseburger', 280.00, '100% beef patty, cheddar cheese, and fries.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Fettuccine Alfredo', 310.00, 'Creamy alfredo sauce with grilled chicken breast.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Salmon Fillet', 480.00, 'Pan-seared salmon with lemon butter sauce.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Margherita Pizza', 260.00, 'Fresh mozzarella, tomato sauce, and basil.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Chicken Caesar Salad', 240.00, 'Crispy lettuce, croutons, and grilled chicken.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Lamb Chops', 520.00, 'Grilled lamb chops with herb-roasted potatoes.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Mushroom Risotto', 290.00, 'Arborio rice cooked with wild mushrooms.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Spicy Beef Tacos', 270.00, 'Three soft tacos with spicy beef and lime.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Vegetarian Lasagna', 280.00, 'Layers of pasta with seasonal vegetables.', (SELECT category_id FROM categories WHERE category_name LIKE '%main%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1));

-- DRINKS
INSERT INTO menu (product_name, Price, description, category_id, user_id) VALUES 
('Fresh Orange Juice', 95.00, '100% natural orange juice.', (SELECT category_id FROM categories WHERE category_name LIKE '%Drink%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Iced Caramel Macchiato', 110.00, 'Espresso with cold milk and caramel.', (SELECT category_id FROM categories WHERE category_name LIKE '%Drink%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Sparkling Water', 40.00, '500ml natural mineral water.', (SELECT category_id FROM categories WHERE category_name LIKE '%Drink%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Mint Lemonade', 85.00, 'Homemade lemonade with fresh mint.', (SELECT category_id FROM categories WHERE category_name LIKE '%Drink%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Hot Chocolate', 90.00, 'Rich dark chocolate melted with milk.', (SELECT category_id FROM categories WHERE category_name LIKE '%Drink%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1));

-- DESSERTS
INSERT INTO menu (product_name, Price, description, category_id, user_id) VALUES 
('New York Cheesecake', 180.00, 'Creamy cheesecake with strawberry glaze.', (SELECT category_id FROM categories WHERE category_name LIKE '%Dessert%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Chocolate Lava Cake', 190.00, 'Warm chocolate cake with molten center.', (SELECT category_id FROM categories WHERE category_name LIKE '%Dessert%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Tiramisu', 170.00, 'Italian espresso-soaked ladyfingers.', (SELECT category_id FROM categories WHERE category_name LIKE '%Dessert%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Apple Pie', 150.00, 'Traditional apple pie with ice cream.', (SELECT category_id FROM categories WHERE category_name LIKE '%Dessert%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1)),
('Baklava Selection', 210.00, 'Traditional pastry with pistachios.', (SELECT category_id FROM categories WHERE category_name LIKE '%Dessert%' LIMIT 1), (SELECT user_id FROM users WHERE role='admin' LIMIT 1));

