<?php
require_once "db.php";

class CadastroUsuario {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function cadastrarUsuario($nome, $email, $senha, $nivel_acesso) {
        // Verifica se o e-mail já está cadastrado
        $sql = "SELECT id_usuario FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "E-mail já cadastrado!";
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Data de criação
        $data_criacao = date("Y-m-d H:i:s");

        // Insere o usuário no banco
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, data_criacao) 
                VALUES (:nome, :email, :senha, :nivel_acesso, :data_criacao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":senha", $senhaHash, PDO::PARAM_STR);
        $stmt->bindParam(":nivel_acesso", $nivel_acesso, PDO::PARAM_STR);
        $stmt->bindParam(":data_criacao", $data_criacao, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao cadastrar usuário!";
        }
    }
}
?>
