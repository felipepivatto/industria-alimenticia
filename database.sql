CREATE DATABASE IF NOT EXISTS db_industria_alimenticia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_industria_alimenticia;

DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  descricao TEXT NOT NULL,
  setor VARCHAR(100) NOT NULL,
  prioridade ENUM('baixa','media','alta') NOT NULL DEFAULT 'baixa',
  data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('a fazer','fazendo','pronto') NOT NULL DEFAULT 'a fazer',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (nome, email) VALUES
('João Silva','joao@example.com'),
('Maria Souza','maria@example.com');

INSERT INTO tasks (user_id, descricao, setor, prioridade, status) VALUES
(1,'Limpar linha de produção A','Produção','alta','a fazer'),
(2,'Revisar registro de validade','Qualidade','media','fazendo'),
(1,'Atualizar planilha de controle','Administração','baixa','pronto');
