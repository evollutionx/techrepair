<?php
require_once "db.php";

class Clientes {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Criar cliente
    public function cadastrarCliente($nome, $telefone, $email, $endereco) {
        $sql = "INSERT INTO clientes (nome, telefone, email, endereco, data_registro) VALUES (:nome, :telefone, :email, :endereco, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $endereco, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Listar todos os clientes
    public function listarClientes() {
        $sql = "SELECT * FROM clientes ORDER BY nome ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar cliente por ID
    public function buscarCliente($id_cliente) {
        $sql = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar cliente
    public function editarCliente($id_cliente, $nome, $telefone, $email, $endereco) {
        $sql = "UPDATE clientes SET nome = :nome, telefone = :telefone, email = :email, endereco = :endereco WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $endereco, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Excluir cliente
    public function excluirCliente($id_cliente) {
        $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
