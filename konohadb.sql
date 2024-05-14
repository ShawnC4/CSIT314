-- If haven't already, drop the schema and create the schema again
-- DROP SCHEMA `konohadb`;
-- CREATE SCHEMA `konohadb`;
-- USE `konohadb`;

-- Create user_profile table
CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    activeStatus BOOLEAN NOT NULL,
    description VARCHAR(100)
);

-- Populate user_profile with profile descriptions
INSERT INTO user_profiles (name, activeStatus, Description)
VALUES
('Buyer', true, 'I am a buyer'), ('Seller', true, 'I am a seller'), ('Agent', true, 'I am a agent'), ('Admin', true, 'I am a admin');

-- Create user_accounts table
CREATE TABLE user_accounts (
    username VARCHAR(50) PRIMARY KEY,
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

-- Create ratings table
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT NOT NULL,
    customer_id VARCHAR(50) NOT NULL,
    agent_id VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES user_accounts(username),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(username)
);

-- Populate ratings table with 100 rows 
INSERT INTO ratings (rating, customer_id, agent_id)
SELECT
    ROUND(1 + (RAND() * 4)), -- Generates random ratings from 1 to 5
    CASE WHEN n <= 5 THEN CONCAT('buyer_', CEIL(RAND() * 10)) ELSE CONCAT('seller_', CEIL(RAND() * 10)) END, -- Randomly selects a buyer or seller
    CONCAT('agent_', CEIL(n / 10.0)) -- Assigns an agent ID based on n, ensures each agent gets 10 entries
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM information_schema.tables -- Generates rows; ensure this query provides at least 100 rows
    LIMIT 100
) t;


-- Create reviews table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review TEXT NOT NULL,
    customer_id VARCHAR(50) NOT NULL,
    agent_id VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES user_accounts(username),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(username)
);

-- Populate reviews table with 10o rows 
INSERT INTO reviews (review, customer_id, agent_id)
SELECT
    -- Randomly selects a review from the given set
    CASE FLOOR(RAND() * 10)
        WHEN 0 THEN 'Great experience, highly recommended!'
        WHEN 1 THEN 'Good service overall, could improve communication.'
        WHEN 2 THEN 'Excellent professionalism and timely delivery.'
        WHEN 3 THEN 'Average service, needs improvement in quality.'
        WHEN 4 THEN 'Satisfactory performance, would use again.'
        WHEN 5 THEN 'Terrible experience, very poor communication.'
        WHEN 6 THEN 'Impressed with the quality of work.'
        WHEN 7 THEN 'Fair service, met expectations.'
        WHEN 8 THEN 'Outstanding service, exceeded expectations!'
        WHEN 9 THEN 'Good job, but room for improvement.'
    END AS review,
    
    -- Randomly selects a buyer or seller
    CASE
        WHEN n % 2 = 0 THEN CONCAT('buyer_', FLOOR(1 + (RAND() * 10)))
        ELSE CONCAT('seller_', FLOOR(1 + (RAND() * 10)))
    END AS customer_id,
    
    -- Assigns an agent ID based on n, ensures each agent gets 10 entries
    CONCAT('agent_', FLOOR((n - 1) / 10) + 1) AS agent_id
    
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM information_schema.tables
    LIMIT 100 -- Ensures only 100 rows are generated
) t;


-- Create property table
CREATE TABLE property (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    size INT NOT NULL,
    rooms INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    location VARCHAR(100) NOT NULL,
    status ENUM('sold', 'available') NOT NULL,
    image VARCHAR(255) NOT NULL,
    views INT NOT NULL,
    seller_id VARCHAR(50),
    agent_id VARCHAR(50),
    FOREIGN KEY (seller_id) REFERENCES user_accounts(username),
    FOREIGN KEY (agent_id) REFERENCES user_accounts(username)
);

-- Populate property with properties managed by agent_1
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 3', 'GCB', 150, 2, 12000000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_1'),
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_1'),
    ('Property 5', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_1'),
    ('Property 2', 'HDB', 100, 3, 170000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_1'),
    ('Property 4', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_1'),
    ('Property 8', 'GCB', 150, 2, 12000000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_1'),
    ('Property 9', 'HDB', 100, 3, 150000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_1'),
    ('Property 7', 'Condo', 150, 2, 180000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_1'),
    ('Property 6', 'HDB', 100, 3, 170000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_1'),
    ('Property 10', 'Condo', 150, 2, 180000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_1');

-- Populate property with properties managed by agent_2
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 3', 'Condo', 120, 4, 1000000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_2'),
    ('Property 1', 'HDB', 110, 3, 500000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_2'),
    ('Property 5', 'GCB', 200, 5, 15000000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_2'),
    ('Property 2', 'Condo', 130, 4, 1500000.00, 'Location D', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_2'),
    ('Property 4', 'HDB', 120, 3, 600000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_2'),
    ('Property 8', 'Condo', 140, 4, 1800000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_2'),
    ('Property 9', 'GCB', 180, 4, 12000000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_2'),
    ('Property 7', 'HDB', 110, 3, 550000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_2'),
    ('Property 6', 'Condo', 130, 4, 1600000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_2'),
    ('Property 10', 'HDB', 120, 3, 620000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_2');

-- Populate property with properties managed by agent_3
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 3', 'GCB', 150, 2, 12000000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_3'),
    ('Property 1', 'HDB', 100, 3, 150000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_3'),
    ('Property 5', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_3'),
    ('Property 2', 'HDB', 100, 3, 170000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_3'),
    ('Property 4', 'Condo', 150, 2, 180000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_3'),
    ('Property 8', 'GCB', 150, 2, 12000000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_3'),
    ('Property 9', 'HDB', 100, 3, 150000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_3'),
    ('Property 7', 'Condo', 150, 2, 180000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_3'),
    ('Property 6', 'HDB', 100, 3, 170000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_3'),
    ('Property 10', 'Condo', 150, 2, 180000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_3');

-- Populate property with properties managed by agent_4
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 1', 'GCB', 150, 3, 5000000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_4'),
    ('Property 2', 'HDB', 120, 4, 800000.00, 'Location D', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_4'),
    ('Property 3', 'Condo', 150, 5, 1200000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_4'),
    ('Property 4', 'GCB', 180, 2, 10000000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_4'),
    ('Property 5', 'HDB', 100, 3, 600000.00, 'Location E', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_4'),
    ('Property 6', 'Condo', 130, 4, 1500000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_4'),
    ('Property 7', 'GCB', 200, 5, 15000000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_4'),
    ('Property 8', 'HDB', 110, 2, 700000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_4'),
    ('Property 9', 'Condo', 140, 3, 1700000.00, 'Location D', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_4'),
    ('Property 10', 'GCB', 220, 4, 18000000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_4');

-- Populate property with properties managed by agent_5
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 1', 'Condo', 150, 3, 800000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_5'),
    ('Property 4', 'GCB', 150, 4, 12000000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_5'),
    ('Property 2', 'HDB', 100, 5, 170000.00, 'Location E', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_5'),
    ('Property 3', 'Condo', 150, 3, 180000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_5'),
    ('Property 5', 'HDB', 100, 4, 150000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_5'),
    ('Property 6', 'Condo', 150, 5, 180000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_5'),
    ('Property 7', 'GCB', 150, 4, 20000000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_5'),
    ('Property 8', 'Condo', 150, 3, 900000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_5'),
    ('Property 9', 'HDB', 100, 4, 160000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_5'),
    ('Property 10', 'GCB', 150, 5, 15000000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_5');

-- Populate property with properties managed by agent_6
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 8', 'GCB', 150, 5, 16000000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_6'),
    ('Property 10', 'Condo', 200, 3, 1000000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_6'),
    ('Property 5', 'Condo', 180, 4, 7000000.00, 'Location G', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_6'),
    ('Property 1', 'HDB', 120, 2, 500000.00, 'Location F', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_6'),
    ('Property 4', 'Condo', 150, 3, 800000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_6'),
    ('Property 2', 'HDB', 100, 5, 400000.00, 'Location E', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_6'),
    ('Property 9', 'GCB', 200, 4, 19000000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_6'),
    ('Property 6', 'HDB', 150, 3, 1200000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_6'),
    ('Property 7', 'Condo', 180, 2, 9000000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_6'),
    ('Property 3', 'GCB', 250, 4, 15000000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_6');

-- Populate property with properties managed by agent_7
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 8', 'GCB', 150, 3, 12000000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_7'),
    ('Property 2', 'HDB', 100, 4, 150000.00, 'Location B', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_7'),
    ('Property 6', 'Condo', 150, 5, 180000.00, 'Location D', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_7'),
    ('Property 1', 'HDB', 100, 2, 170000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_7'),
    ('Property 7', 'GCB', 150, 3, 180000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_7'),
    ('Property 4', 'Condo', 150, 4, 180000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_7'),
    ('Property 5', 'GCB', 150, 2, 12000000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_7'),
    ('Property 10', 'HDB', 100, 5, 150000.00, 'Location G', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_7'),
    ('Property 9', 'Condo', 150, 3, 180000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_7'),
    ('Property 3', 'HDB', 100, 4, 170000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_7');

-- Populate property with properties managed by agent_8
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 3', 'HDB', 150, 4, 900000.00, 'Location F', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_8'),
    ('Property 1', 'Condo', 100, 5, 1500000.00, 'Location G', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_8'),
    ('Property 5', 'GCB', 200, 3, 1800000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_8'),
    ('Property 2', 'HDB', 120, 2, 500000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_8'),
    ('Property 4', 'Condo', 150, 4, 1200000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_8'),
    ('Property 8', 'HDB', 100, 3, 600000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_8'),
    ('Property 9', 'GCB', 250, 5, 20000000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_8'),
    ('Property 7', 'Condo', 180, 3, 1400000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_8'),
    ('Property 6', 'HDB', 130, 2, 450000.00, 'Location F', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_8'),
    ('Property 10', 'GCB', 220, 4, 15000000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_8');

-- Populate property with properties managed by agent_9
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 4', 'Condo', 150, 3, 180000.00, 'Location A', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_9'),
    ('Property 10', 'HDB', 100, 5, 150000.00, 'Location C', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_9'),
    ('Property 9', 'GCB', 150, 4, 12000000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_9'),
    ('Property 2', 'Condo', 150, 2, 400000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_9'),
    ('Property 1', 'HDB', 100, 3, 170000.00, 'Location D', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_9'),
    ('Property 3', 'GCB', 150, 5, 20000000.00, 'Location F', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_9'),
    ('Property 7', 'HDB', 100, 4, 190000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_9'),
    ('Property 6', 'Condo', 150, 2, 450000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_9'),
    ('Property 5', 'GCB', 150, 3, 16000000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_9'),
    ('Property 8', 'HDB', 100, 2, 250000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_9');

-- Populate property with properties managed by agent_10
INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) 
VALUES
    ('Property 6', 'HDB', 100, 3, 170000.00, 'Location C', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_8', 'agent_10'),
    ('Property 9', 'HDB', 100, 4, 900000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_2', 'agent_10'),
    ('Property 2', 'Condo', 150, 5, 1500000.00, 'Location F', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_5', 'agent_10'),
    ('Property 5', 'GCB', 200, 3, 1800000.00, 'Location G', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_7', 'agent_10'),
    ('Property 1', 'Condo', 120, 2, 600000.00, 'Location H', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_1', 'agent_10'),
    ('Property 7', 'GCB', 250, 4, 20000000.00, 'Location E', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_10', 'agent_10'),
    ('Property 10', 'HDB', 110, 2, 450000.00, 'Location B', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_3', 'agent_10'),
    ('Property 8', 'Condo', 180, 3, 1700000.00, 'Location A', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_9', 'agent_10'),
    ('Property 4', 'HDB', 130, 5, 1200000.00, 'Location H', 'available', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_6', 'agent_10'),
    ('Property 3', 'Condo', 160, 4, 800000.00, 'Location D', 'sold', 'https://i.insider.com/655582f84ca513d8242a5725?width=700', 100, 'seller_4', 'agent_10');

-- Create shortlist table
CREATE TABLE shortlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    buyer_id VARCHAR(50) NOT NULL,
    FOREIGN KEY (property_id) REFERENCES property(id),
    FOREIGN KEY (buyer_id) REFERENCES user_accounts(username),
    UNIQUE KEY(property_id, buyer_id) -- Ensures each property is shortlisted only once by each buyer
);

-- Populate shortlist with buyer shortlists
INSERT INTO shortlist (property_id, buyer_id)
VALUES
    (1, 'buyer_1'), (55, 'buyer_4'), (4, 'buyer_2'), (77, 'buyer_4'), (3, 'buyer_5'), (66, 'buyer_1'), (4, 'buyer_3'), (88, 'buyer_2'), (5, 'buyer_3'), (99, 'buyer_5'),
    (6, 'buyer_1'), (64, 'buyer_4'), (7, 'buyer_2'), (59, 'buyer_4'), (8, 'buyer_5'), (65, 'buyer_1'), (9, 'buyer_3'), (81, 'buyer_2'), (10, 'buyer_3'), (96, 'buyer_5'),
    (12, 'buyer_4'), (18, 'buyer_1'), (16, 'buyer_3'), (13, 'buyer_2'), (14, 'buyer_5'), (19, 'buyer_9'), (23, 'buyer_6'), (34, 'buyer_9'), (18, 'buyer_7'), (44, 'buyer_9'),
    (39, 'buyer_10'), (37, 'buyer_6'), (21, 'buyer_8'), (28, 'buyer_7'), (32, 'buyer_8'), (17, 'buyer_10'), (16, 'buyer_6'), (70, 'buyer_9'), (33, 'buyer_7'), (29, 'buyer_10'),
    (24, 'buyer_6'), (41, 'buyer_8'), (36, 'buyer_7'), (87, 'buyer_8'), (22, 'buyer_10'), (49, 'buyer_9'), (98, 'buyer_6'), (17, 'buyer_8'), (65, 'buyer_7'),(43, 'buyer_10');

INSERT INTO shortlist (property_id, buyer_id)
SELECT p.id, u.username
FROM (
    SELECT id, ROW_NUMBER() OVER() AS rn
    FROM property
    ORDER BY RAND()
    LIMIT 50
) p
JOIN (
    SELECT username, ROW_NUMBER() OVER() AS rn
    FROM user_accounts
    WHERE profile_id= 1
    ORDER BY RAND()
) u 
limit 100;