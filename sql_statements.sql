--Deze line dropped de project1 database als die al bestaat.
DROP DATABASE project1;
--Deze line create de project1 database.
CREATE DATABASE project1;
--Deze line selecteert de project1 database om er mee te werken.
USE project1;
--Deze statement creates een table.
CREATE TABLE Account (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    PRIMARY KEY(id)
);
--Deze statement creates een table.
CREATE TABLE Persoon (
    id INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(255),
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255),
    username VARCHAR(255),
    account_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY account_id REFERENCES account(id)
);