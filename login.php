<?php
session_start();
require_once "classes/login.php";

$login = new Login();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($login->loginUser($email, $password)) {
        // Redireciona para o dashboard após login bem-sucedido
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechRepair</title>
    <link rel="icon" type="image/png" href="includes/logo.png">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 15px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="login-container">
            <div class="card p-4">
                <div class="text-center">
                    <img src="includes/logo.png" alt="logo TechRepair" class="img-fluid mb-3" style="max-width: 150px;">
                </div>

                <h3 class="card-title text-center mb-4"><i class="bi bi-box-arrow-in-right"></i> TechRepair | Login</h3>
                
                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
                
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="cad_usuario.php" class="btn btn-success btn-custom"><i class="bi bi-person-plus"></i> Cadastrar Usuário</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
