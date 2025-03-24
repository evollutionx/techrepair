<?php
require_once "OS.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ordem = $_POST['id_ordem'];
    $id_peca = $_POST['id_peca'];
    $quantidade_utilizada = $_POST['quantidade_utilizada'];

    $os = new OS();
    $resultado = $os->adicionarPecaOS($id_ordem, $id_peca, $quantidade_utilizada);

    if ($resultado) {
        echo "Peça adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar peça!";
    }
}
?>
