CREATE DATABASE animal_rescue;

USE animal_rescue;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'volunteer', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('dog', 'cat', 'bird', 'reptile', 'other') NOT NULL,
    age VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    health_status VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    status ENUM('available', 'adopted', 'fostered') DEFAULT 'available',
    created_by INT,
    updated_by INT,
    deleted_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id),
    FOREIGN KEY (deleted_by) REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
);

CREATE TABLE stray_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT,
    type ENUM('dog', 'cat', 'bird', 'reptile', 'other') NOT NULL,
    color VARCHAR(50) NOT NULL,
    location VARCHAR(255) NOT NULL,
    time VARCHAR(50) NOT NULL,
    needs TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    status ENUM('unverified', 'verified') DEFAULT 'unverified',
    verified_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified_at TIMESTAMP NULL,
    FOREIGN KEY (reporter_id) REFERENCES users(id),
    FOREIGN KEY (verified_by) REFERENCES users(id)
);

CREATE TABLE adoptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    animal_id INT,
    feeding_responsibility TEXT,
    allergic_household ENUM('yes', 'no') NOT NULL,
    income_sources TEXT,
    house_picture VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',

    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE volunteers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    reason TEXT,
    agree_to_time ENUM('yes', 'no') NOT NULL,
    skills TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    donation_type ENUM('monetary', 'in-kind') NOT NULL,
    frequency ENUM('one-time', 'weekly', 'monthly') DEFAULT NULL,
    payment_mode ENUM('cash', 'bank_transfer') DEFAULT NULL,
    account_name VARCHAR(255) DEFAULT NULL,
    account_number VARCHAR(255) DEFAULT NULL,
    bank VARCHAR(255) DEFAULT NULL,
    amount DECIMAL(10, 2) DEFAULT NULL,
    `use` TEXT DEFAULT NULL,
    wishlists TEXT DEFAULT NULL,
    details TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE fosters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    animal_id INT,
    start_date DATE,
    end_date DATE,
    feeding_responsibility TEXT,
    allergic_household ENUM('yes', 'no') NOT NULL,
    income_sources TEXT,
    house_picture VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE sponsorships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    animal_id INT,
    entity_type ENUM('individual', 'organization', 'company') NOT NULL,
    sponsorship_type ENUM('financial', 'food', 'health', 'housing') NOT NULL,
    details TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);



-- CREATE TABLE partnerships (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,
--     partnership_type ENUM('event', 'promotional', 'other') NOT NULL,
--     details TEXT,
--     status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
--     approved_by INT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     approved_at TIMESTAMP NULL,
--     FOREIGN KEY (user_id) REFERENCES users(id),
--     FOREIGN KEY (approved_by) REFERENCES users(id)
-- );
