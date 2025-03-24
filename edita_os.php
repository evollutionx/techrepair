<?php
require_once "classes/os.php";
require_once "classes/clientes.php"; // Para buscar os clientes
require_once "classes/pecas.php"; // Adicionei a classe para carregar as peças
require_once "header.php";

// Verifica se o usuário está logado e pega o ID do usuário
$id_usuario = $_SESSION['user_id'] ?? null; // Obtém o ID do usuário logado

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

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['adicionar_peca'])) {
    $id_cliente = $_POST['id_cliente'];
    $descricao = $_POST['descricao'];
    $produto = $_POST['produto'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $nserie = $_POST['nserie'];
    $lote = $_POST['lote'];

    if ($os->editarOS($id_ordem, $id_cliente, $descricao, $produto, $marca, $modelo, $nserie, $lote)) {
        echo "<div class='alert alert-success'>Ordem de Serviço atualizada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar a Ordem de Serviço.</div>";
    }
}

// Busca os clientes para preencher o combobox
$cliente = new Clientes();
$clientes = $cliente->listarClientes(); // Função para listar todos os clientes

// Busca as peças para preencher o select de peças
$peca = new Pecas();
$pecas = $peca->listarPecas(); // Função para listar todas as peças
?>

<form action="edita_os.php?id=<?= $id_ordem ?>" method="POST">
    <div class="container mt-4">
        <div class="row">
            <!-- Card para Formulário de Edição da Ordem de Serviço -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Editar Ordem de Serviço
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="id_cliente" class="form-label">Cliente</label>
                            <select class="form-control" name="id_cliente" id="id_cliente" required>
                                <option value="">Selecione um Cliente</option>
                                <?php foreach ($clientes as $cliente) { ?>
                                    <option value="<?php echo $cliente['id_cliente']; ?>"
                                        <?php echo $os_data['id_cliente'] == $cliente['id_cliente'] ? 'selected' : ''; ?>>
                                        <?php echo $cliente['nome']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="3" required><?php echo htmlspecialchars($os_data['descricao']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="produto" class="form-label">Produto</label>
                            <input type="text" class="form-control" name="produto" id="produto" value="<?php echo htmlspecialchars($os_data['produto']); ?>">
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-3 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" name="marca" id="marca" value="<?php echo htmlspecialchars($os_data['marca']); ?>">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" name="modelo" id="modelo" value="<?php echo htmlspecialchars($os_data['modelo']); ?>">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nserie" class="form-label">N° Série</label>
                                <input type="text" class="form-control" name="nserie" id="nserie" value="<?php echo htmlspecialchars($os_data['nserie']); ?>">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="lote" class="form-label">Lote</label>
                                <input type="text" class="form-control" name="lote" id="lote" value="<?php echo htmlspecialchars($os_data['lote']); ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar OS</button>
                    </div>
                </div>
            </div>

            <!-- Card para Adicionar Peças -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Adicionar Peças à OS
                    </div>
                    <div class="card-body">
                        <form id="formAdicionarPeca">
                            <div class="form-group">
                                <label for="peca">Peça</label>
                                <select name="id_peca" id="peca" class="form-control">
                                    <?php foreach ($pecas as $peca) { ?>
                                        <option value="<?php echo $peca['id_peca']; ?>" data-estoque="<?php echo $peca['quantidade']; ?>">
                                            <?php echo $peca['nome']; ?> - Estoque: <?php echo $peca['quantidade']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantidade">Quantidade</label>
                                <input type="number" name="quantidade_utilizada" id="quantidade" class="form-control" min="1">
                            </div>
                            <button type="button" id="adicionarPecaBtn" class="btn btn-primary">Adicionar Peça</button>
                        </form>
                        <h5>Peças Adicionadas:</h5>
                        <ul id="listaPecas" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const listaPecas = document.getElementById('listaPecas');
    const formAdicionarPeca = document.getElementById('formAdicionarPeca');
    const pecasSelect = document.getElementById('peca');
    const quantidadeInput = document.getElementById('quantidade');
    const adicionarPecaBtn = document.getElementById('adicionarPecaBtn');

    adicionarPecaBtn.addEventListener('click', function() {
        const idPeca = pecasSelect.value;
        const quantidade = quantidadeInput.value;
        const nomePeca = pecasSelect.options[pecasSelect.selectedIndex].text;

        if (!quantidade || quantidade <= 0) {
            alert("Por favor, insira uma quantidade válida.");
            return;
        }

        const item = document.createElement('li');
        item.classList.add('list-group-item');
        item.textContent = `${nomePeca} - Quantidade: ${quantidade}`;

        listaPecas.appendChild(item);

        // Atualizar o estoque da peça
        const estoque = parseInt(pecasSelect.options[pecasSelect.selectedIndex].getAttribute('data-estoque'));
        const novoEstoque = estoque - parseInt(quantidade);

        // Atualizar o atributo de estoque da opção
        pecasSelect.options[pecasSelect.selectedIndex].setAttribute('data-estoque', novoEstoque);

        // Limpar o campo de quantidade
        quantidadeInput.value = '';
    });
</script>

<?php require_once "footer.php"; ?>
