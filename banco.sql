CREATE DATABASE IF NOT EXISTS restaurante;
USE restaurante;

CREATE TABLE pratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    tempo_preparo INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
	tipo VARCHAR(20)
);
