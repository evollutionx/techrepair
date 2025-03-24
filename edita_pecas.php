<?php
require_once "classes/pecas.php";
require_once "header.php";

$pecas = new Pecas();
$id_peca = $_GET['id'];
$peca = $pecas->buscarPeca($id_peca);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pecas->editarPeca($id_peca, $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade'], $_POST['fornecedor']);
    header("Location: lista_pecas.php");
    exit();
}
?>

<div class="container mt-5">
    <h2>Editar Peça</h2>
    <form action="" method="POST">
        <input type="text" name="nome" class="form-control" value="<?= $peca['nome'] ?>" required>
        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
    </form>
</div>

<?php require_once "footer.php"; ?>
