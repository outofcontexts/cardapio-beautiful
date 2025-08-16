<?php
require_once 'ConnectionFactory.php';
require_once 'PratoDoCardapio.php';

class PratoDAO {
    private $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function listarTodos() {
        // Inclui o campo tipo na consulta
        $stmt = $this->conn->query("SELECT * FROM pratos");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PratoDoCardapio');
    }

    public function salvar(PratoDoCardapio $prato) {
        // Insere também o campo tipo
        $sql = "INSERT INTO pratos (nome, descricao, tempo_preparo, preco, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $prato->nome,
            $prato->descricao,
            $prato->tempo_preparo,
            $prato->preco,
            $prato->tipo
        ]);
    }
}
