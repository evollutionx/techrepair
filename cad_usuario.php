<?php
require_once "classes/cad_usuario.php";

$cadastro = new CadastroUsuario();
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $nivel_acesso = $_POST['nivel_acesso'];

    if ($nome && $email && $senha && $nivel_acesso) {
        $resultado = $cadastro->cadastrarUsuario($nome, $email, $senha, $nivel_acesso);
        if ($resultado === true) {
            header("Location: login.php?cadastro=sucesso");
            exit();
        } else {
            $mensagem = $resultado;
        }
    } else {
        $mensagem = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="icon" type="image/png" href="includes/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cadastro-container {
            max-width: 400px;
            width: 100%;
            padding: 15px;
            margin: 50px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 100%;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="cadastro-container">
            <div class="card p-4">
                <div class="text-center mb-3">
                    <img src="includes/logo.png" alt="logo TechRepair" class="img-fluid mb-3" style="max-width: 150px;">
                </div>
                <h3 class="card-title text-center mb-4"><i class="bi bi-person-plus"></i> Cadastro de Usuário</h3>

                <?php if ($mensagem) { ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $mensagem; ?>
                    </div>
                <?php } ?>

                <form action="cad_usuario.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control" name="senha" required>
                    </div>

                    <div class="mb-3">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso:</label>
                        <select name="nivel_acesso" class="form-select" required>
                            <option value="usuario">Usuário</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-person-plus"></i> Cadastrar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="btn btn-secondary btn-custom"><i class="bi bi-arrow-left"></i> Voltar ao Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
