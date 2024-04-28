# add own mysql password in konohadb.php
# create a config.php file so we don't have to keep changing the password when pulling.
# <?php
# define('DB_SERVER', 'localhost');
# define('DB_USER', 'your_own_username');
# define('DB_PASSWORD', 'your_own_password');
# define('DB_NAME', 'konohadb');
# ?>
# there is alr a gitignore file so the config file will be ignored and wont commit and push to github
# Just to test code
CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    activeStatus BOOLEAN NOT NULL,
    description VARCHAR(100)
);

INSERT INTO user_profiles (name, activeStatus, Description)
VALUES
('Buyer', true, 'I am a buyer'),
('Seller', true, 'I am a seller'),
('Agent', true, 'I am a agent'),
('Admin', true, 'I am a admin');


CREATE TABLE user_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    activeStatus BOOLEAN NOT NULL,
    profile_id INT,
    FOREIGN KEY (profile_id) REFERENCES user_profiles(id)
);

-- Populate user accounts for Buyer profile with password 'buyer_password'
INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) 
SELECT CONCAT('buyer_', t.n), CONCAT('buyer_', t.n, '@example.com'), CONCAT('buyer_pass', t.n), TRUE, '1'
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;

-- Populate user accounts for Seller profile with password 'seller_password'
INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) 
SELECT CONCAT('seller_', t.n), CONCAT('seller_', t.n, '@example.com'), CONCAT('seller_pass', t.n), TRUE, '2'
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;

-- Populate user accounts for Agent profile with password 'agent_password'
INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) 
SELECT CONCAT('agent_', t.n), CONCAT('agent_', t.n, '@example.com'), CONCAT('agent_pass', t.n), TRUE, '3'
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;

-- Populate user accounts for Admin profile with password 'admin_password'
INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) 
SELECT CONCAT('admin_', t.n), CONCAT('admin_', t.n, '@example.com'), CONCAT('admin_pass', t.n), TRUE, '4'
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 5
) t;

-- Create the ratings table
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT NOT NULL,
    seller_id INT NOT NULL,
    agent_id INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES user_accounts(id),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(id)
);

-- Create the reviews table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review TEXT NOT NULL,
    seller_id INT NOT NULL,
    agent_id INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES user_accounts(id),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(id)
);

-- Insert 10 rows into the ratings table
INSERT INTO ratings (rating, seller_id, agent_id)
VALUES
    (5, 19, 31), 
    (4, 22, 40), 
    (5, 23, 36),
    (3, 16, 38),
    (4, 17, 39),
    (1, 17, 40),
    (4, 20, 34),
    (3, 25, 32),
    (5, 18, 35),
    (4, 21, 33),
    (4, 24, 31), 
    (5, 25, 40), 
    (3, 16, 36),
    (4, 17, 38),
    (5, 18, 39),
    (2, 19, 40),
    (3, 20, 34),
    (4, 21, 32),
    (5, 22, 35),
    (3, 23, 33);

-- Insert 10 rows into the reviews table
INSERT INTO reviews (review, seller_id, agent_id)
VALUES
    ('Great experience, highly recommended!', 19, 31), 
    ('Good service overall, could improve communication.', 22, 40), 
    ('Excellent professionalism and timely delivery.', 23, 36),
    ('Average service, needs improvement in quality.', 16, 38),
    ('Satisfactory performance, would use again.', 17, 39),
    ('Terrible experience, very poor communication.', 17, 40),
    ('Impressed with the quality of work.', 20, 34),
    ('Fair service, met expectations.', 25, 32),
    ('Outstanding service, exceeded expectations!', 18, 35),
    ('Good job, but room for improvement.', 21, 33),
    ('Excellent service, highly recommended!', 24, 31), 
    ('Good experience overall, satisfied.', 25, 40), 
    ('Could improve communication, but good otherwise.', 16, 36),
    ('Satisfactory performance, met expectations.', 17, 38),
    ('Outstanding service, exceeded expectations!', 18, 39),
    ('Poor experience, needs improvement.', 19, 40),
    ('Impressed with the quality of work.', 20, 34),
    ('Fair service, could improve.', 21, 32),
    ('Exceptional service, highly recommended!', 22, 35),
    ('Average service, nothing special.', 23, 33);

CREATE TABLE property (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    size INT NOT NULL,
    rooms INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    location VARCHAR(100) NOT NULL,
    status ENUM('sold', 'available') NOT NULL,
    seller_id INT,
    agent_id INT,
    FOREIGN KEY (seller_id) REFERENCES user_accounts(id),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(id)
);

-- Insert properties for Agent 31
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 3', 'GCB', 150, 2, 12000000.00, 'Location C', 'sold', 19, 31),
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 16, 32),
    ('Property 3', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 25, 32);

-- Insert properties for Agent 32
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 16, 32),
    ('Property 3', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 25, 32);

-- Insert properties for Agent 33
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 3', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 18, 33);

-- Insert properties for Agent 34
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 17, 34),
    ('Property 2', 'HDB', 200, 4, 250000.00, 'Location B', 'available', 22, 34),
    ('Property 3', 'HDB', 150, 2, 180000.00, 'Location C', 'sold', 25, 34);

-- Insert properties for Agent 35
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 23, 35);

-- Insert properties for Agent 36
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 23, 36);


-- Insert properties for Agent 37
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 16, 37),
    ('Property 2', 'Condo', 200, 4, 250000.00, 'Location B', 'available', 20, 37),
    ('Property 3', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 24, 37);

-- Insert properties for Agent 38
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 3', 'GCB', 150, 2, 50000000.00, 'Location C', 'sold', 16, 38);

-- Insert properties for Agent 39
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 2', 'HDB', 200, 4, 250000.00, 'Location B', 'available', 18, 39);

-- Insert properties for Agent 40
INSERT INTO property (name, type, size, rooms, price, location, status, seller_id, agent_id) 
VALUES
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 22, 40),
    ('Property 3', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 23, 40);
