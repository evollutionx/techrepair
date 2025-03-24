<?php
require_once "classes/os.php";
require_once "header.php";

$os = new OS();
$lista_os = $os->listarOS();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Ordens de Serviço</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Ordens de Serviço</h2>
    <a href="cad_os.php" class="btn btn-primary mb-3 d-block d-sm-inline-block">Cadastrar Nova OS</a>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Produto</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>N° Série</th>
                    <th>Lote</th>
                    <th>Status</th>
                    <th>Data Abertura</th>
                    <th>Data Conclusão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_os as $os_item) { ?>
                    <tr>
                        <td><?= htmlspecialchars($os_item['id_cliente']) ?></td>
                        <td><?= htmlspecialchars($os_item['descricao']) ?></td>
                        <td><?= htmlspecialchars($os_item['produto']) ?></td>
                        <td><?= htmlspecialchars($os_item['marca']) ?></td>
                        <td><?= htmlspecialchars($os_item['modelo']) ?></td>
                        <td><?= htmlspecialchars($os_item['nserie']) ?></td>
                        <td><?= htmlspecialchars($os_item['lote']) ?></td>
                        <td><?= htmlspecialchars($os_item['status']) ?></td>
                        <td><?= htmlspecialchars($os_item['data_abertura']) ?></td>
                        <td><?= htmlspecialchars($os_item['data_conclusao']) ?></td>
                        <td>
                            <?php if ($os_item['status'] == 'aberta') { ?>
                                <a href="edita_os.php?id=<?= $os_item['id_ordem'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="finaliza_os.php?id=<?= $os_item['id_ordem'] ?>" class="btn btn-success btn-sm">Finalizar</a>
                                <a href="cancelar_os.php?id=<?= $os_item['id_ordem'] ?>" class="btn btn-danger btn-sm">Cancelar</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php require_once "footer.php"; ?>
