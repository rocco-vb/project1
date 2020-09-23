--Deze line create de project1 database.
CREATE DATABASE project1;
--Deze line selecteert de project1 database om er mee te werken.
USE project1;
--Deze statement creates een table.
CREATE TABLE Account (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE  NOT NULL,
    password VARCHAR(255)  NOT NULL,
    PRIMARY KEY(id)
);
--Deze statement creates een table.
CREATE TABLE Persoon (
    id INT NOT NULL AUTO_INCREMENT NOT NULL,
    voornaam VARCHAR(255) NOT NULL,
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    account_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY account_id REFERENCES account(id)
);