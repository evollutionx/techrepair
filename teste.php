<?php
require_once "classes/db.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "Conexão bem-sucedida!";
} else {
    echo "Falha na conexão.";
}
?>
