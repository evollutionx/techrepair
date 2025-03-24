<?php
session_start();
require_once "classes/login.php";

$login = new Login();

// Verifica se o usuário está logado
if (!$login->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Obtém o tipo de usuário armazenado na sessão
$nivel_usuario = $_SESSION['user_tipo'] ?? 'tecnico'; // Padrão "tecnico" se não definido
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair</title>
    <link rel="icon" type="image/png" href="includes/logo.png"> 

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<!-- Navbar Responsiva -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
        <img src="includes/logo.png" alt="logo TechRepair" class="img-fluid mb-3" style="max-width: 50px;"> TechRepair
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php"><i class="bi bi-person"></i> Meu Perfil</a>
                </li>

                <?php if ($nivel_usuario == 'admin') { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuPecas" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-box-seam"></i> Peças
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="lista_pecas.php"><i class="bi bi-list-ul"></i> Listagem de Peças</a></li>
                        <li><a class="dropdown-item" href="cad_pecas.php"><i class="bi bi-plus-circle"></i> Cadastrar Peça</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
