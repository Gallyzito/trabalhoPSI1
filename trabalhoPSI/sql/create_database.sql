-- create_database.sql
-- Script para criar base de dados e tabelas para o sistema de login

CREATE DATABASE IF NOT EXISTS `trabalhopsi` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `trabalhopsi`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela para formulários gaming
CREATE TABLE IF NOT EXISTS `gaming_forms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `jogo_favorito` VARCHAR(200) NOT NULL,
  `genero` VARCHAR(50) NOT NULL,
  `plataforma` VARCHAR(50) NOT NULL,
  `tempo_jogo` VARCHAR(20),
  `comentarios` TEXT,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Você pode inserir um usuário teste (senha: 123456) com:
-- INSERT INTO users (username,email,password_hash,created_at) VALUES ('test','test@example.com', '$2y$10$xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', NOW());
-- Para tornar um usuário admin (após importar/usar a tabela):
-- UPDATE users SET is_admin = 1 WHERE username = 'seu_usuario';
