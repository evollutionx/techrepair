<?php
require_once "classes/pecas.php";
require_once "header.php";

$pecas = new Pecas();
$id_peca = $_GET['id'];
$peca = $pecas->buscarPeca($id_peca);

// Verifica se o formulário foi enviado e atualiza a peça
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pecas->editarPeca($id_peca, $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade'], $_POST['fornecedor']);
    header("Location: lista_pecas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Editar Peça</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Peça</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($peca['nome']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" required><?= htmlspecialchars($peca['descricao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="text" name="preco" id="preco" class="form-control" value="<?= number_format($peca['preco'], 2, ',', '.') ?>" required>
        </div>

        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" value="<?= $peca['quantidade'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="fornecedor" class="form-label">Fornecedor</label>
            <input type="text" name="fornecedor" id="fornecedor" class="form-control" value="<?= htmlspecialchars($peca['fornecedor']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

<?php require_once "footer.php"; ?>
