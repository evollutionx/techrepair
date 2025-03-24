<?php
require_once "db.php"; // Inclua o arquivo de conexão com o banco de dados

class Dashboard {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Listar todas as ordens de serviço
    public function listarOS() {
        $query = "SELECT * FROM ordens_servico ORDER BY status ASC, data_abertura DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter quantidade de OS por status mês a mês no ano atual
    public function getOsPorMes() {
        $query = "SELECT 
                    MONTH(data_abertura) AS mes, 
                    status, 
                    COUNT(*) AS quantidade
                  FROM ordens_servico
                  WHERE YEAR(data_abertura) = YEAR(CURDATE())
                  GROUP BY mes, status
                  ORDER BY mes ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPagamentosPorMes() {
        $query = "SELECT 
                    DATE_FORMAT(data_pagamento, '%m') AS mes, 
                    SUM(valor) AS total 
                  FROM pagamentos 
                  WHERE YEAR(data_pagamento) = YEAR(CURDATE()) 
                  GROUP BY mes 
                  ORDER BY mes";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPecasEsgotadas() {
        $query = "SELECT nome, descricao FROM pecas WHERE quantidade = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
}