-- Create Database
CREATE DATABASE IF NOT EXISTS nwp_engineering_portal;
USE nwp_engineering_portal;

-- 1. Users Table (For Login)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'user', 'staff') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Officers Table
CREATE TABLE IF NOT EXISTS officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100),
    phone VARCHAR(20),
    category ENUM('executive', 'admin', 'technical', 'div', 'hq') NOT NULL,
    division VARCHAR(50),
    email VARCHAR(100) DEFAULT NULL,
    photo_url VARCHAR(255) DEFAULT NULL
);

-- 3. Downloads Table
CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    file_url VARCHAR(255),
    icon_class VARCHAR(50) DEFAULT 'fa-file-alt'
);

-- 4. Achievements Table
CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_en VARCHAR(255) NOT NULL,
    title_si VARCHAR(255),
    title_ta VARCHAR(255),
    description_en TEXT,
    description_si TEXT,
    description_ta TEXT,
    icon_class VARCHAR(50) DEFAULT 'fa-trophy',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Divisions Table
CREATE TABLE IF NOT EXISTS division_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) UNIQUE NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    name_si VARCHAR(100),
    name_ta VARCHAR(100),
    location_en VARCHAR(100),
    location_si VARCHAR(100),
    location_ta VARCHAR(100),
    address_en TEXT,
    address_si TEXT,
    address_ta TEXT,
    phone VARCHAR(50),
    fax VARCHAR(50),
    email VARCHAR(100),
    banner_url VARCHAR(255) DEFAULT NULL,
    logo_url VARCHAR(255) DEFAULT NULL
);


-- Insert Default Admin (Password is 'admin123' - you should change this later)
INSERT INTO users (username, password, full_name, role) 
VALUES ('admin', 'admin123', 'System Administrator', 'admin');

-- Insert Initial Sample Data
INSERT INTO officers (name, title, phone, category, division, email) VALUES 
('Eng. A. Kumara', 'Provincial Director', '+94 37 222 4501', 'executive', 'Head Office', 'provincialdir@nwpeng.gov.lk'),
('Mr. S. Perera', 'Chief Assistant', '+94 37 222 4505', 'admin', 'Head Office', 'chiefassistant@nwpeng.gov.lk');
