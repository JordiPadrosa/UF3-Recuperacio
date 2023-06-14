CREATE SCHEMA IF NOT EXISTS `uf3`;
CREATE USER IF NOT EXISTS 'uf3'@'%' IDENTIFIED BY 'uf3';
GRANT ALL PRIVILEGES ON uf3.* TO 'uf3'@'%';

use `uf3`;
CREATE TABLE IF NOT EXISTS participants (
	`nom` varchar(100),
	`cognom` varchar(100),
    `email` varchar(100) primary key
);

CREATE TABLE IF NOT EXISTS sectors (
	`nom` varchar(100) primary key
);

CREATE TABLE IF NOT EXISTS vies (
	`nom` varchar(100) primary key,
	`sector` varchar(100),
    `grau` varchar(100),
    FOREIGN KEY (sector) REFERENCES sectors(nom)
);

CREATE TABLE IF NOT EXISTS assoliments (
    `participant` varchar(100),
    `via` varchar(100),
    `intent` int(10),
    `data` date,
    `encadenat` boolean,
    `primer` boolean,
    `assegurador` varchar(100),
    PRIMARY KEY (participant, via, intent),
    FOREIGN KEY (participant) REFERENCES participants(email),
    FOREIGN KEY (assegurador) REFERENCES participants(email),
    FOREIGN KEY (via) REFERENCES vies(nom)
);
