CREATE DATABASE IF NOT EXISTS sistema_visitas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_visitas;

CREATE TABLE IF NOT EXISTS visitas (
   id INT PRIMARY KEY AUTO_INCREMENT,
   nombre_completo VARCHAR(100) NOT NULL,
   persona_visitada VARCHAR(100) NOT NULL,
   fecha DATE NOT NULL,
   hora_entrada TIME NOT NULL,
   hora_salida TIME NULL,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
