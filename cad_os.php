<?php
require_once "classes/os.php";
require_once "classes/clientes.php"; // Para buscar os clientes
require_once "classes/pecas.php"; // Para buscar as peças
require_once "header.php";

// Verifica se o usuário está logado e pega o ID do usuário
$id_usuario = $_SESSION['user_id'] ?? null; // Obtém o ID do usuário logado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $descricao = $_POST['descricao'];
    $produto = $_POST['produto'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $nserie = $_POST['nserie'];
    $lote = $_POST['lote'];

    $os = new OS();
    if ($os->cadastrarOS($id_cliente, $id_usuario, $descricao, $produto, $marca, $modelo, $nserie, $lote)) {
        echo "<div class='alert alert-success'>Ordem de Serviço cadastrada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao cadastrar Ordem de Serviço.</div>";
    }
}

// Busca os clientes para preencher o combobox
$cliente = new Clientes();
$clientes = $cliente->listarClientes(); // Função para listar todos os clientes

// Busca as peças para preencher o combobox no card lateral
$peca = new Pecas();
$pecas = $peca->listarPecas(); // Função para listar todas as peças disponíveis
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Ordem de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <!-- Card para Cadastro da OS -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        Cadastro da Ordem de Serviço
                    </div>
                    <div class="card-body">
                        <form action="cad_os.php" method="POST">
                            <div class="mb-3">
                                <label for="id_cliente" class="form-label">Cliente</label>
                                <select class="form-control" name="id_cliente" id="id_cliente" required>
                                    <option value="">Selecione um Cliente</option>
                                    <?php foreach ($clientes as $cliente) { ?>
                                        <option value="<?php echo $cliente['id_cliente']; ?>">
                                            <?php echo $cliente['nome']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="produto" class="form-label">Produto</label>
                                <input type="text" class="form-control" name="produto" id="produto" required>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" name="marca" id="marca">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" id="modelo">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="nserie" class="form-label">N° Série</label>
                                    <input type="text" class="form-control" name="nserie" id="nserie">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="lote" class="form-label">Lote</label>
                                    <input type="text" class="form-control" name="lote" id="lote">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cadastrar OS</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card para Adicionar Peças -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        Adicionar Peças à OS
                    </div>
                    <div class="card-body">
                        <form action="processar_os.php" method="POST" id="formAdicionarPeca">
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
                                <input type="number" name="quantidade_utilizada" id="quantidade" class="form-control" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar Peça</button>
                        </form>
                        <h5>Peças Adicionadas:</h5>
                        <ul id="listaPecas" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const listaPecas = document.getElementById('listaPecas');
        const formAdicionarPeca = document.getElementById('formAdicionarPeca');
        const pecasSelect = document.getElementById('peca');
        const quantidadeInput = document.getElementById('quantidade');

        formAdicionarPeca.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const idPeca = pecasSelect.value;
            const quantidade = quantidadeInput.value;
            const nomePeca = pecasSelect.options[pecasSelect.selectedIndex].text;
            
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
</body>
</html>

<?php require_once "footer.php"; ?>
