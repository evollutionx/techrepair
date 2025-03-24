<?php
require_once "db.php"; // Conexão com o banco de dados

class Perfil {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Obter os dados do usuário pelo ID
    public function getUsuario($id_usuario) {
        $query = "SELECT id_usuario, nome, email, tipo, data_criacao FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar dados do usuário (exceto email)
// Atualizar dados do usuário (exceto email)
public function atualizarPerfil($id_usuario, $nome, $nova_senha = null) {
    if ($nova_senha) {
        $query = "UPDATE usuarios SET nome = :nome, senha = :senha WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt->bindValue(":senha", $senha_hash); // Usando bindValue
    } else {
        $query = "UPDATE usuarios SET nome = :nome WHERE id_usuario = :id_usuario";  // Removido a vírgula extra
        $stmt = $this->conn->prepare($query);
    }

    // Usando bindValue em vez de bindParam para evitar o erro
    $stmt->bindValue(":nome", $nome);
    $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;  // Sucesso
    } else {
        return false;  // Se falhar, você pode verificar o erro
    }
} 
    

    // Excluir conta do usuário
    public function excluirConta($id_usuario) {
        $query = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
