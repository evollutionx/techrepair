<?php
require_once "db.php"; // Inclua o arquivo de conexão com o banco de dados

class OS {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Listar todas as ordens de serviço
    public function listarOS() {
        $query = "SELECT * FROM ordens_servico order by status asc, data_abertura desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cadastrar uma nova ordem de serviço com os novos campos
    public function cadastrarOS($id_cliente, $id_usuario, $descricao, $produto, $marca, $modelo, $nserie, $lote) {
        $query = "INSERT INTO ordens_servico (id_cliente, id_usuario, descricao, produto, marca, modelo, nserie, lote, status, data_abertura)
                  VALUES (:id_cliente, :id_usuario, :descricao, :produto, :marca, :modelo, :nserie, :lote, 'aberta', NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':nserie', $nserie);
        $stmt->bindParam(':lote', $lote);

        return $stmt->execute();
    }

    // Alterar o status da ordem de serviço
    public function alterarStatus($id_ordem, $status) {
        $query = "UPDATE ordens_servico SET status = :status WHERE id_ordem = :id_ordem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_ordem', $id_ordem);
        return $stmt->execute();
    }

    // Atualizar a data de conclusão
    public function concluirOS($id_ordem) {
        $query = "UPDATE ordens_servico SET status = 'concluída', data_conclusao = NOW() WHERE id_ordem = :id_ordem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ordem', $id_ordem);
        return $stmt->execute();
    }

        // Método para buscar uma ordem de serviço pelo ID
        public function buscarOS($id_ordem) {
            $sql = "SELECT * FROM ordens_servico WHERE id_ordem = :id_ordem LIMIT 1"; // Consulta para buscar a ordem de serviço
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ordem', $id_ordem, PDO::PARAM_INT);
            $stmt->execute();
            
            // Retorna o resultado como um array associativo ou falso se não encontrar
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

            // Método para editar a ordem de serviço
    public function editarOS($id_ordem, $id_cliente, $descricao, $produto, $marca, $modelo, $nserie, $lote) {
        $sql = "UPDATE ordens_servico SET 
                    id_cliente = :id_cliente, 
                    descricao = :descricao, 
                    produto = :produto, 
                    marca = :marca, 
                    modelo = :modelo, 
                    nserie = :nserie, 
                    lote = :lote 
                WHERE id_ordem = :id_ordem";
        
        $stmt = $this->conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':id_ordem', $id_ordem, PDO::PARAM_INT);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':produto', $produto, PDO::PARAM_STR);
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
        $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt->bindParam(':nserie', $nserie, PDO::PARAM_STR);
        $stmt->bindParam(':lote', $lote, PDO::PARAM_STR);

        // Executa a consulta
        return $stmt->execute();
    }

// Alterar o status para 'cancelada' e registrar o motivo do cancelamento
public function cancelarOS($id_ordem, $motivo_cancelamento) {
    $query = "UPDATE ordens_servico SET status = 'cancelada', motivo_cancelamento = :motivo_cancelamento WHERE id_ordem = :id_ordem";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':motivo_cancelamento', $motivo_cancelamento);
    $stmt->bindParam(':id_ordem', $id_ordem);
    return $stmt->execute();
}

public function adicionarPecaOS($id_ordem, $id_peca, $quantidade_utilizada) {
    // Iniciar transação para garantir a consistência
    $this->conn->beginTransaction();
    
    try {
        // 1. Inserir a peça utilizada na tabela pecas_utilizadas
        $query = "INSERT INTO pecas_utilizadas (id_ordem, id_peca, quantidade_utilizada) 
                  VALUES (:id_ordem, :id_peca, :quantidade_utilizada)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ordem', $id_ordem);
        $stmt->bindParam(':id_peca', $id_peca);
        $stmt->bindParam(':quantidade_utilizada', $quantidade_utilizada);
        $stmt->execute();

        // 2. Atualizar o estoque de peças na tabela pecas
        $query = "UPDATE pecas SET quantidade = quantidade - :quantidade_utilizada WHERE id_peca = :id_peca";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantidade_utilizada', $quantidade_utilizada);
        $stmt->bindParam(':id_peca', $id_peca);
        $stmt->execute();

        // Se tudo ocorreu bem, confirmar a transação
        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        // Em caso de erro, desfazer a transação
        $this->conn->rollBack();
        return false;
    }
}
    

}
?>
