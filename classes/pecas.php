<?php
require_once "db.php";

class Pecas {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Criar peça
    public function cadastrarPeca($nome, $descricao, $preco, $quantidade, $fornecedor) {
        $sql = "INSERT INTO pecas (nome, descricao, preco, quantidade, fornecedor) VALUES (:nome, :descricao, :preco, :quantidade, :fornecedor)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
        $stmt->bindParam(":preco", $preco, PDO::PARAM_STR);
        $stmt->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(":fornecedor", $fornecedor, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Listar todas as peças
    public function listarPecas() {
        $sql = "SELECT * FROM pecas ORDER BY nome ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar peça por ID
    public function buscarPeca($id_peca) {
        $sql = "SELECT * FROM pecas WHERE id_peca = :id_peca";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_peca", $id_peca, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar peça
    public function editarPeca($id_peca, $nome, $descricao, $preco, $quantidade, $fornecedor) {
        $sql = "UPDATE pecas SET nome = :nome, descricao = :descricao, preco = :preco, quantidade = :quantidade, fornecedor = :fornecedor WHERE id_peca = :id_peca";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_peca", $id_peca, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
        $stmt->bindParam(":preco", $preco, PDO::PARAM_STR);
        $stmt->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(":fornecedor", $fornecedor, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Excluir peça
    public function excluirPeca($id_peca) {
        $sql = "DELETE FROM pecas WHERE id_peca = :id_peca";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_peca", $id_peca, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
