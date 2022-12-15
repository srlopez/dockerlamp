CREATE TABLE pet (
    name VARCHAR(20), 
    owner VARCHAR(20),
    species VARCHAR(20), 
    sex CHAR(1), 
    birth DATE, 
    death DATE
    )ENGINE=InnoDB;

SET NAMES utf8;

INSERT INTO pet VALUES 
('Puffball','Ana','hamster','f','2021-03-30',NULL),
('Ballpuff','Pedro','ratón','f','2021-07-30',NULL),
('Pinball','Luis','hamster','f','2021-06-30',NULL),
('BallinPin','Aroa','ratón','f','2021-05-30',NULL),
('PinkFull','Iñaki','gato','f','2021-04-30',NULL);