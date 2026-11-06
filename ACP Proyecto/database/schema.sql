-- ACP Proyecto · Base de datos para TP6/TP7/TP8
-- Ejecutar en phpMyAdmin (Importar). No modifica la base 'lunarmc'.
CREATE DATABASE IF NOT EXISTS acp_proyecto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE acp_proyecto;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  rol ENUM('usuario','admin') NOT NULL DEFAULT 'usuario',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_usuarios_rol (rol)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS estados_revision (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(40) NOT NULL UNIQUE
) ENGINE=InnoDB;
INSERT IGNORE INTO estados_revision (id,nombre) VALUES
  (1,'Pendiente'),(2,'Revisado'),(3,'Resuelto');

CREATE TABLE IF NOT EXISTS evaluaciones (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL,
  nombre_apellido VARCHAR(120) NOT NULL,
  correo VARCHAR(190) NOT NULL,
  opinion_funcionamiento TEXT NOT NULL,
  estado_id INT UNSIGNED NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_eval_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_eval_estado FOREIGN KEY (estado_id) REFERENCES estados_revision(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_eval_usuario (usuario_id),
  INDEX idx_eval_estado (estado_id),
  INDEX idx_eval_fecha (created_at)
) ENGINE=InnoDB;
