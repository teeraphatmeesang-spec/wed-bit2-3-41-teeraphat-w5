CREATE DATABASE IF NOT EXISTS ben 10;
USE ben 10;

CREATE TABLE IF NOT EXISTS planet (
  planet_ID int(11) NOT NULL AUTO_INCREMENT,
  planet_Name varchar(100) NOT NULL,
  climate varchar(100) NOT NULL,
  PRIMARY KEY (planet_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO planet (planet_ID, planet_Name, climate) VALUES
(1, 'Khoros', 'Arid Desert');

CREATE TABLE IF NOT EXISTS character (
  character_id int(11) NOT NULL AUTO_INCREMENT,
  planet_ID int(11) NOT NULL,
  Alien_Name varchar(100) NOT NULL,
  age int(11) NOT NULL,
  power varchar(255) NOT NULL,
  Weakness varchar(255) NOT NULL,
  PRIMARY KEY (character_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO character (character_id, planet_ID, Alien_Name, age, power, Weakness) VALUES
(1, 1, 'Four Arms', 16, 'Super strength', 'Slow movement');