<?php
require_once "classes/clientes.php";
require_once "header.php";

$clientes = new Clientes();
$lista = $clientes->listarClientes();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Lista de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h2>Lista de Clientes</h2>
    <a href="cad_cliente.php" class="btn btn-primary mb-3">Cadastrar Novo Cliente</a>

    <!-- Tabela Responsiva -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Data de Registro</th>
                    <?php if ($_SESSION['user_tipo'] == 'admin') { ?>
                        <th>Ações</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $cliente) { ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                        <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                        <td><?= date('d/m/Y', strtotime($cliente['data_registro'])) ?></td>
                        <?php if ($_SESSION['user_tipo'] == 'admin') { ?>
                            <td>
                                <a href="edita_cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="excluir_cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

<?php require_once "footer.php"; ?>
