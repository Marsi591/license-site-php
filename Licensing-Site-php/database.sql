-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    license_key VARCHAR(255) NOT NULL
);

-- Create the license_keys table
CREATE TABLE license_keys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_value VARCHAR(255) NOT NULL,
    is_used BOOLEAN NOT NULL DEFAULT 0
);

-- First Key
INSERT INTO license_keys (key_value, is_used) VALUES ('admin', 0);
