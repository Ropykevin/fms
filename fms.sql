-- ======================================================
-- DROP EXISTING DATABASE TO START FRESH
-- ======================================================
DROP DATABASE IF EXISTS fms;
CREATE DATABASE fms;
USE fms;

-- ======================================================
-- 1. ADMINISTRATIVE TABLES
-- ======================================================

-- Admin Table
CREATE TABLE IF NOT EXISTS admintb (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admintb` (`username`, `password`) VALUES
('admin', 'admin123');

-- Employee Table
CREATE TABLE IF NOT EXISTS emptb (
    eid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    salary DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ======================================================
-- 2. LIVESTOCK MANAGEMENT SYSTEM
-- ======================================================

-- Livestock Table
CREATE TABLE IF NOT EXISTS livestock (
    animal_id INT AUTO_INCREMENT PRIMARY KEY,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(50),
    gender VARCHAR(10),
    date_of_birth DATE NOT NULL,
    weight DECIMAL(5,2) NOT NULL CHECK (weight > 0), -- Positive weight
    ear_tag VARCHAR(20) UNIQUE NOT NULL,
    notes TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Feeding Report Table
CREATE TABLE IF NOT EXISTS feeding_report (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    feeding_date DATE NOT NULL,
    feed_type VARCHAR(50) NOT NULL,
    quantity DECIMAL(7,2) NOT NULL CHECK (quantity > 0), -- Positive quantity
    remarks TEXT,
    FOREIGN KEY (animal_id) REFERENCES livestock(animal_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Medical Report Table
CREATE TABLE IF NOT EXISTS medical_report (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    report_date DATE NOT NULL,
    diagnosis VARCHAR(100) NOT NULL,
    treatment VARCHAR(100),
    medicine VARCHAR(100),
    cost DECIMAL(10,2) CHECK (cost >= 0), -- Non-negative cost
    vet_name VARCHAR(100),
    remarks TEXT,
    FOREIGN KEY (animal_id) REFERENCES livestock(animal_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Produce Report Table
CREATE TABLE IF NOT EXISTS produce_report (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    report_date DATE NOT NULL,
    produce_type VARCHAR(50) NOT NULL,
    quantity DECIMAL(7,2) NOT NULL CHECK (quantity > 0), -- Positive quantity
    remarks TEXT,
    FOREIGN KEY (animal_id) REFERENCES livestock(animal_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daily Produce Summary Table
CREATE TABLE IF NOT EXISTS daily_produce_summary (
    summary_date DATE NOT NULL,
    species VARCHAR(50) NOT NULL,
    total_quantity DECIMAL(10,2) DEFAULT 0,
    PRIMARY KEY (summary_date, species)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

-- ======================================================
-- 3. ADMIN & EMPLOYEE PERMISSIONS
-- ======================================================

-- Grant admin permissions to manage employees and retrieve reports
GRANT INSERT, SELECT, UPDATE, DELETE ON fms.emptb TO 'admin_user'@'localhost';
GRANT SELECT ON fms.livestock TO 'admin_user'@'localhost';
GRANT SELECT ON fms.feeding_report TO 'admin_user'@'localhost';
GRANT SELECT ON fms.medical_report TO 'admin_user'@'localhost';
GRANT SELECT ON fms.produce_report TO 'admin_user'@'localhost';

-- Grant employee permissions to update stored data
GRANT UPDATE ON fms.livestock TO 'employee_user'@'localhost';
GRANT UPDATE ON fms.feeding_report TO 'employee_user'@'localhost';
GRANT UPDATE ON fms.medical_report TO 'employee_user'@'localhost';
GRANT UPDATE ON fms.produce_report TO 'employee_user'@'localhost';

FLUSH PRIVILEGES;

-- ======================================================
-- 4. TEST DATA INSERTION
-- ======================================================

-- Insert Admin
INSERT INTO admintb (username, password) VALUES ('admin', 'admin123');

-- Insert Employees
INSERT INTO emptb (username, password, email, phone, salary)
VALUES 
('employee1', 'emp123', 'employee1@fms.com', '0712345678', 45000.00),
('employee2', 'emp456', 'employee2@fms.com', '0723456789', 52000.00);

-- Insert Livestock Records
INSERT INTO livestock (species, breed, gender, date_of_birth, weight, ear_tag, notes)
VALUES 
('Cow', 'Holstein', 'Female', '2020-04-15', 450.00, 'EAR12345', 'Healthy dairy cow'),
('Goat', 'Nubian', 'Male', '2019-03-10', 75.20, 'EAR67890', 'Active and healthy');

-- Insert Feeding Report
INSERT INTO feeding_report (animal_id, feeding_date, feed_type, quantity, remarks)
VALUES 
(1, '2025-03-25', 'Hay', 15.5, 'Morning feed'),
(2, '2025-03-26', 'Grain', 8.2, 'Evening feed');

-- Insert Medical Reports
INSERT INTO medical_report (animal_id, report_date, diagnosis, treatment, medicine, cost, vet_name, remarks)
VALUES 
(1, '2025-03-20', 'Mastitis', 'Antibiotics', 'Penicillin', 35.00, 'Dr. Smith', 'Follow-up in two weeks'),
(2, '2025-03-22', 'Parasites', 'Deworming', 'Albendazole', 10.00, 'Dr. Wilson', 'No issues found');

-- Insert Produce Reports
INSERT INTO produce_report (animal_id, report_date, produce_type, quantity, remarks)
VALUES 
(1, '2025-03-25', 'Milk', 30.5, 'Morning milking session'),
(1, '2025-03-26', 'Milk', 28.0, 'Evening milking session');