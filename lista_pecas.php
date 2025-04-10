<?php
require_once "classes/pecas.php";
require_once "header.php";

$pecas = new Pecas();
$lista = $pecas->listarPecas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Lista de Peças</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h2>Lista de Peças</h2>
    <a href="cad_pecas.php" class="btn btn-primary mb-3">Cadastrar Nova Peça</a>

    <!-- Tabela Responsiva -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Fornecedor</th>
                    <?php if ($_SESSION['user_tipo'] == 'admin') { ?>
                        <th>Ações</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $peca) { ?>
                    <tr>
                        <td><?= htmlspecialchars($peca['nome']) ?></td>
                        <td><?= htmlspecialchars($peca['descricao']) ?></td>
                        <td>R$ <?= number_format($peca['preco'], 2, ',', '.') ?></td>
                        <td><?= $peca['quantidade'] ?></td>
                        <td><?= htmlspecialchars($peca['fornecedor']) ?></td>
                        <?php if ($_SESSION['user_tipo'] == 'admin') { ?>
                            <td>
                                <a href="edita_pecas.php?id=<?= $peca['id_peca'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="excluir_peca.php?id=<?= $peca['id_peca'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta peça?');">Excluir</a>
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
