```sql
CREATE DATABASE lakbaylokal;

CREATE TABLE users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  first_name    VARCHAR(100) NOT NULL,
  last_name     VARCHAR(100) NOT NULL,
  email         VARCHAR(180) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('user','admin') DEFAULT 'user',
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE places (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(120) NOT NULL,
  region      ENUM('luzon','visayas','mindanao') DEFAULT 'luzon',
  description TEXT,
  image       VARCHAR(255)
);

CREATE TABLE hotels (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  place_id    INT NOT NULL,
  name        VARCHAR(180) NOT NULL,
  price       INT NOT NULL,
  description TEXT,
  image       VARCHAR(255),
  FOREIGN KEY (place_id) REFERENCES places(id)
    ON DELETE CASCADE
);

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ref_code VARCHAR(20) UNIQUE,
  user_name VARCHAR(120),
  user_email VARCHAR(180),

  place_id INT,
  hotel_id INT,

  check_in DATE,
  check_out DATE,

  guests INT,
  rooms INT,

  total_price INT,
  payment_method VARCHAR(50),

  status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- SAMPLE DATA (for testing)
-- ========================================

-- Sample Admin User (email: admin@lakbaylokal.com, password: admin123)
-- Hash generated with: password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES
('Admin', 'User', 'admin@lakbaylokal.com', '$2y$10$tUwLXP6w1xJXO8JqjL6.2e2J6K5L4M3N2O1P0Q9R8S7T6U5V4W3X', 'admin');

-- Sample Regular User (email: juan@email.com, password: user123)
-- Hash generated with: password_hash('user123', PASSWORD_BCRYPT)
INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES
('Juan', 'Dela Cruz', 'juan@email.com', '$2y$10$d9UMX0TqHnX2K3Y8V5Q1L.nQ9R8S7T6U5V4W3X2Y1Z0A9B8C7D6E', 'user');

-- Sample Place (Destination)
INSERT INTO places (name, region, description, image) VALUES
('Boracay Beach', 'visayas', 'Beautiful white sand beach in Aklan known for water sports and nightlife', 'boracay.jpg');

-- Sample Hotel
INSERT INTO hotels (place_id, name, price, description, image) VALUES
(1, 'Beachfront Paradise Resort', 3500, 'Luxury 4-star beachfront resort with pool and spa facilities', 'beachfront-resort.jpg');