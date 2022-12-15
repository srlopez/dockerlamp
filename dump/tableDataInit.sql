SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8;

CREATE TABLE Data (
  id INT NOT NULL,
  nombre VARCHAR(20) NOT NULL,
  valor DECIMAL(6,2),
  fecha DATE
) ENGINE=InnoDB;
ALTER TABLE Data ADD PRIMARY KEY (id);
ALTER TABLE Data MODIFY id int NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO Data (nombre, valor, fecha) VALUES
('Data1á', 11.21, '2022-12-08'),
('Data2é', 12.22, now()),
('Data3í', 13.23, now()),
('Data4ó', 14.24, now());
COMMIT;

