<?php
require_once "classes/os.php";
require_once "classes/clientes.php"; // Para buscar os clientes
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
?>

<form action="cad_os.php" method="POST">
    <div class="container mt-4">
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

        <!-- Campo do ID do usuário oculto -->
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
            <!-- Marca -->
            <div class="col-12 col-md-3 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" name="marca" id="marca">
            </div>

            <!-- Modelo -->
            <div class="col-12 col-md-3 mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" name="modelo" id="modelo">
            </div>

            <!-- Nº Série -->
            <div class="col-12 col-md-3 mb-3">
                <label for="nserie" class="form-label">N° Série</label>
                <input type="text" class="form-control" name="nserie" id="nserie">
            </div>

            <!-- Lote -->
            <div class="col-12 col-md-3 mb-3">
                <label for="lote" class="form-label">Lote</label>
                <input type="text" class="form-control" name="lote" id="lote">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar OS</button>
    </div>
</form>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php require_once "footer.php"; ?>
