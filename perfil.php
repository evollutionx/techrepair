<?php
require_once "classes/db.php";
require_once "classes/perfil.php";
require_once "header.php";

$perfil = new Perfil();

$id_usuario = $_SESSION['user_id']; // Obtém o ID do usuário logado
$usuario = $perfil->getUsuario($id_usuario);

if (!$usuario) {
    echo "Usuário não encontrado!";
    exit();
}

// Função para verificar se a senha e a confirmação de senha coincidem
function verificarSenhas($senha, $confirmacao) {
    if ($senha !== $confirmacao) {
        return "As senhas não coincidem!";
    }
    return null; // Retorna null se as senhas coincidirem
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["atualizar"])) {
        $nome = trim($_POST["nome"]);
        $nova_senha = !empty($_POST["senha"]) ? $_POST["senha"] : null;
        $confirmacao_senha = !empty($_POST["senha_confirmacao"]) ? $_POST["senha_confirmacao"] : null;

        // Verifica se a senha foi fornecida e se ela coincide com a confirmação
        if ($nova_senha && $confirmacao_senha) {
            $erro_senha = verificarSenhas($nova_senha, $confirmacao_senha);
            if ($erro_senha) {
                $erro = $erro_senha;
            } else {
                // Atualiza a senha se as senhas coincidirem
                if ($perfil->atualizarPerfil($id_usuario, $nome, $nova_senha)) {
                    $usuario = $perfil->getUsuario($id_usuario); // Atualiza os dados na tela
                    $mensagem = "Perfil atualizado com sucesso!";
                } else {
                    $erro = "Erro ao atualizar perfil!";
                }
            }
        } else {
            // Atualiza sem alterar a senha
            if ($perfil->atualizarPerfil($id_usuario, $nome, $nova_senha)) {
                $usuario = $perfil->getUsuario($id_usuario); // Atualiza os dados na tela
                $mensagem = "Perfil atualizado com sucesso!";
            } else {
                $erro = "Erro ao atualizar perfil!";
            }
        }
    } elseif (isset($_POST["excluir"])) {
        if ($perfil->excluirConta($id_usuario)) {
            session_destroy();
            header("Location: login.php");
            exit;
        } else {
            $erro = "Erro ao excluir a conta!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Meu Perfil</h2>

    <?php if (isset($mensagem)): ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php elseif (isset($erro)): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
        </div>

        <div class="mb-3">
        <label for="senha" class="form-label">Nova Senha (opcional)</label>
        <input type="password" id="senha" name="senha" class="form-control">
        </div>

        <div class="mb-3">
        <label for="senha_confirmacao" class="form-label">Confirmar Nova Senha</label>
        <input type="password" id="senha_confirmacao" name="senha_confirmacao" class="form-control">
        <div id="erro_senha" class="text-danger" style="display: none;">As senhas não coincidem!</div>
        </div>
        <button type="submit" name="atualizar" class="btn btn-primary">Atualizar Perfil</button>
        <button type="submit" name="excluir" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">Excluir Conta</button>
    </form>
</div>
<script>
    // Função para verificar se as senhas coincidem
    document.getElementById('senha_confirmacao').addEventListener('input', function() {
        const senha = document.getElementById('senha').value;
        const senhaConfirmacao = document.getElementById('senha_confirmacao').value;
        const erroMensagem = document.getElementById('erro_senha');

        if (senha !== senhaConfirmacao) {
            erroMensagem.style.display = 'block'; // Exibe a mensagem de erro
        } else {
            erroMensagem.style.display = 'none'; // Esconde a mensagem de erro
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include "footer.php"; ?>
