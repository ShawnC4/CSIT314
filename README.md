CREATE TABLE SysAdmin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

INSERT INTO SysAdmin (username, password) VALUES
('user1', 'password1'),
('user2', 'password2'),
('user3', 'password3'),
('user4', 'password4'),
('user5', 'password5'),
('user6', 'password6'),
('user7', 'password7'),
('user8', 'password8'),
('user9', 'password9'),
('user10', 'password10');

# Just to test code

CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    create_listing BOOLEAN NOT NULL DEFAULT false,
    read_listing BOOLEAN NOT NULL DEFAULT false,
    update_listing BOOLEAN NOT NULL DEFAULT false,
    delete_listing BOOLEAN NOT NULL DEFAULT false
);

INSERT INTO user_profiles (name, create_listing, read_listing, update_listing, delete_listing)
VALUES
('Buyer', false, true, false, false),
('Seller', false, true, false, false),
('Agent', true, true, true, true);


CREATE TABLE user_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Adding password field
    profile_id INT,
    FOREIGN KEY (profile_id) REFERENCES user_profiles(id)
);

-- Populate user accounts for Buyer profile with password 'buyer_password'
INSERT INTO user_accounts (username, email, password, profile_id) 
SELECT CONCAT('buyer_', t.n), CONCAT('buyer_', t.n, '@example.com'), CONCAT('buyer_password', t.n), 1
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;

-- Populate user accounts for Seller profile with password 'seller_password'
INSERT INTO user_accounts (username, email, password, profile_id) 
SELECT CONCAT('seller_', t.n), CONCAT('seller_', t.n, '@example.com'), CONCAT('seller_password', t.n), 2
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;

-- Populate user accounts for Agent profile with password 'agent_password'
INSERT INTO user_accounts (username, email, password, profile_id) 
SELECT CONCAT('agent_', t.n), CONCAT('agent_', t.n, '@example.com'), CONCAT('agent_password', t.n), 3
FROM (
    SELECT ROW_NUMBER() OVER() AS n
    FROM INFORMATION_SCHEMA.TABLES
    LIMIT 10
) t;