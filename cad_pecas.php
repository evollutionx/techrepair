<?php
require_once "classes/pecas.php";
require_once "header.php";

$pecas = new Pecas();
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $fornecedor = $_POST['fornecedor'];

    if ($pecas->cadastrarPeca($nome, $descricao, $preco, $quantidade, $fornecedor)) {
        $mensagem = "Peça cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar peça.";
    }
}
?>

<div class="container mt-5">
    <h2>Cadastrar Peça</h2>
    <form action="" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" class="form-control" required>

        <label>Descrição:</label>
        <textarea name="descricao" class="form-control" required></textarea>

        <label>Preço:</label>
        <input type="text" name="preco" class="form-control" required>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" class="form-control" required>

        <label>Fornecedor:</label>
        <input type="text" name="fornecedor" class="form-control" required>

        <button type="submit" class="btn btn-success mt-3">Cadastrar</button>
    </form>
    <p class="text-success"><?= $mensagem ?></p>
</div>

<?php require_once "footer.php"; ?>
