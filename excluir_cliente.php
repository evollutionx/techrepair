<?php
require_once "classes/clientes.php";

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $clientes = new Clientes();
    $clientes->excluirCliente($id_cliente);
    header("Location: lista_clientes.php");
    exit();
}
?>
