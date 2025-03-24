<?php
require_once "db.php"; // Inclua o arquivo de conexão com o banco de dados

class Pagamentos {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Cadastrar um pagamento
    public function cadastrarPagamento($id_ordem, $valor, $forma_pagamento) {
        $query = "INSERT INTO pagamentos (id_ordem, valor, forma_pagamento, data_pagamento)
                  VALUES (:id_ordem, :valor, :forma_pagamento, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ordem', $id_ordem);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':forma_pagamento', $forma_pagamento);
        return $stmt->execute();
    }
}
?>
