<?php
require_once "classes/os.php";
require_once "classes/pagamentos.php";
require_once "header.php";

// Verifica se o usuário está logado
$id_usuario = $_SESSION['user_id'] ?? null;
if (!$id_usuario) {
    echo "<div class='alert alert-danger'>Você precisa estar logado para finalizar uma ordem de serviço.</div>";
    exit;
}

// Verifica se um ID de ordem de serviço foi passado
$id_ordem = $_GET['id'] ?? null;
if (!$id_ordem) {
    echo "<div class='alert alert-danger'>Ordem de serviço não encontrada.</div>";
    exit;
}

// Busca os dados da ordem de serviço
$os = new OS();
$os_data = $os->buscarOS($id_ordem);
if (!$os_data) {
    echo "<div class='alert alert-danger'>Erro ao carregar a ordem de serviço.</div>";
    exit;
}

// Processa o formulário de finalização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor = $_POST['valor'];
    $forma_pagamento = $_POST['forma_pagamento'];

    // Atualiza o status da ordem de serviço para "concluída"
    if ($os->concluirOS($id_ordem)) {
        // Registra o pagamento
        $pagamentos = new Pagamentos();
        if ($pagamentos->cadastrarPagamento($id_ordem, $valor, $forma_pagamento)) {
            echo "<div class='alert alert-success'>Ordem de Serviço concluída e pagamento registrado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao registrar o pagamento.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erro ao concluir a ordem de serviço.</div>";
    }
}

?>

<form action="finaliza_os.php?id=<?= $id_ordem ?>" method="POST">
    <div class="container mt-4">
        <h3>Finalizar Ordem de Serviço</h3>
        
        <div class="mb-3">
            <label for="valor" class="form-label">Valor do Serviço</label>
            <input type="number" class="form-control" name="valor" id="valor" required>
        </div>

        <div class="mb-3">
            <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
            <select class="form-control" name="forma_pagamento" id="forma_pagamento" required>
                <option value="">Selecione a forma de pagamento</option>
                <option value="dinheiro">Dinheiro</option>
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
                <option value="pix">PIX</option>
                <option value="boleto">Boleto</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Finalizar OS</button>
    </div>
</form>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php require_once "footer.php"; ?>
