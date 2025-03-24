<?php
// Inicia a sessão
session_start();

// Destrói a sessão e remove todas as variáveis de sessão
session_unset();
session_destroy();

// Redireciona o usuário para a página de login
header("Location: login.php");
exit();
?>
