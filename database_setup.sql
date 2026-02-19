-- Sekgwari Primary School Database Setup
-- Create this database in your MySQL environment (e.g., via phpMyAdmin)

CREATE DATABASE IF NOT EXISTS sekgwari_db;
USE sekgwari_db;

-- Table for site settings (Hero section, school info, etc.)
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES 
('hero_title', 'Welcome to Sekgwari Primary School'),
('hero_subtitle', 'Nurturing Excellence in Education in Gamatlala'),
('hero_image', ''),
('school_phone', '+27 XX XXX XXXX'),
('school_email', 'info@sekgwariprimary.co.za'),
('school_address', 'Gamatlala, Limpopo'),
('operating_hours', 'Monday - Friday: 7:30 AM - 2:00 PM');

-- Table for staff members
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    qualification VARCHAR(255),
    grade VARCHAR(50),
    message TEXT,
    image_url VARCHAR(255),
    display_order INT DEFAULT 0
);

-- Table for news and events
CREATE TABLE IF NOT EXISTS news_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    event_date DATE,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for gallery images
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
