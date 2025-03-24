<?php
require_once "classes/os.php";
require_once "header.php";

$os = new OS();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ordem = $_POST['id_ordem'];
    $motivo_cancelamento = $_POST['motivo_cancelamento'];

    // Cancelar a ordem de serviço
    if ($os->cancelarOS($id_ordem, $motivo_cancelamento)) {
        echo "<script>alert('Ordem de serviço cancelada com sucesso!'); window.location.href='lista_os.php';</script>";
    } else {
        echo "<script>alert('Erro ao cancelar a ordem de serviço.'); window.location.href='lista_os.php';</script>";
    }
} else {
    $id_ordem = $_GET['id'];
    $ordem = $os->buscarOS($id_ordem);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar Ordem de Serviço</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Cancelar Ordem de Serviço</h2>

    <form method="POST" action="cancelar_os.php">
        <input type="hidden" name="id_ordem" value="<?= htmlspecialchars($ordem['id_ordem']) ?>">

        <div class="mb-3">
            <label for="motivo_cancelamento" class="form-label">Motivo do Cancelamento</label>
            <textarea class="form-control" id="motivo_cancelamento" name="motivo_cancelamento" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Cancelar Ordem de Serviço</button>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php require_once "footer.php"; ?>
