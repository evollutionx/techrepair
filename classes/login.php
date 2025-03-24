<?php
require_once "db.php";

class Login {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function loginUser($email, $password) {
        $sql = "SELECT id_usuario, nome, email, senha, tipo FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
    
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['senha'])) {
            session_start();
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_tipo'] = $user['tipo']; // 'admin' ou 'tecnico'
            return true;
        }
        return false;
    }
    

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
