CREATE TABLE users (
    id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM ('user','admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Houses (
    id SERIAL PRIMARY KEY,
    user_id int NOT NULL,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    pdf BLOB,
    status ENUM ('Accepted','Declined','Waiting') NOT NULL DEFAULT 'Waiting',
    FOREIGN KEY (user_id) REFERENCES users(id)
);