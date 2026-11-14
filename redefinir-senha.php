<?php

session_start();

require_once "config/banco.php";

$mensagem = "";
$tipo_mensagem = "";
$token_original = $_GET["token"] ?? $_POST["token"] ?? "";
$token_valido = false;
$usuario_id = null;

if (empty($token_original)) {
    $mensagem = "Link de recuperação inválido.";
    $tipo_mensagem = "erro";
} else {
    $token_banco = hash("sha256", $token_original);

    $consulta = $conexao->prepare(
        "SELECT usuario_id
         FROM tokens_recuperacao
         WHERE token = ?
           AND usado = 0
           AND expira_em > NOW()
         LIMIT 1"
    );

    $consulta->bind_param("s", $token_banco);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $token = $resultado->fetch_assoc();

    $consulta->close();

    if ($token) {
        $token_valido = true;
        $usuario_id = $token["usuario_id"];
    } else {
        $mensagem =
            "Este link é inválido, já foi utilizado ou expirou.";
        $tipo_mensagem = "erro";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $token_valido) {
    $senha = $_POST["senha"] ?? "";
    $confirmar_senha = $_POST["confirmar_senha"] ?? "";

    if (strlen($senha) < 6) {
        $mensagem = "A senha deve ter pelo menos 6 caracteres.";
        $tipo_mensagem = "erro";
    } elseif ($senha !== $confirmar_senha) {
        $mensagem = "As senhas não são iguais.";
        $tipo_mensagem = "erro";
    } else {
        $senha_protegida = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        $atualizacao = $conexao->prepare(
            "UPDATE usuarios
             SET senha = ?
             WHERE id = ?"
        );

        $atualizacao->bind_param(
            "si",
            $senha_protegida,
            $usuario_id
        );

        if ($atualizacao->execute()) {
            $marcar_token = $conexao->prepare(
                "UPDATE tokens_recuperacao
                 SET usado = 1
                 WHERE token = ?"
            );

            $marcar_token->bind_param(
                "s",
                $token_banco
            );

            $marcar_token->execute();
            $marcar_token->close();

            $mensagem =
                "Senha alterada com sucesso. "
                . "Você já pode fazer login.";
            $tipo_mensagem = "sucesso";
            $token_valido = false;
        } else {
            $mensagem = "Não foi possível alterar a senha.";
            $tipo_mensagem = "erro";
        }

        $atualizacao->close();
    }
}

$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Redefinir senha - Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="login.php">Entrar</a>
        </nav>
    </div>
</header>

<main class="pagina-formulario">
    <div class="container">

        <section class="cartao-formulario">
            <p class="etiqueta-formulario">Segurança da conta</p>

            <h1>Nova senha</h1>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem <?php echo $tipo_mensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <?php if ($token_valido): ?>

                <p class="texto-formulario">
                    Digite sua nova senha abaixo.
                </p>

                <form method="POST" action="redefinir-senha.php">

                    <input
                        type="hidden"
                        name="token"
                        value="<?php echo htmlspecialchars($token_original); ?>"
                    >

                    <div class="campo">
                        <label for="senha">Nova senha</label>

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            minlength="6"
                            required
                        >

                        <small>
                            A senha deve ter pelo menos 6 caracteres.
                        </small>
                    </div>

                    <div class="campo">
                        <label for="confirmar_senha">
                            Confirmar nova senha
                        </label>

                        <input
                            type="password"
                            id="confirmar_senha"
                            name="confirmar_senha"
                            minlength="6"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="botao botao-principal botao-formulario"
                    >
                        Alterar senha
                    </button>
                </form>

            <?php else: ?>

                <p class="texto-formulario">
                    Solicite uma nova recuperação de senha para receber
                    outro link.
                </p>

                <a
                    href="recuperar-senha.php"
                    class="botao botao-principal botao-formulario"
                >
                    Solicitar novo link
                </a>

            <?php endif; ?>

        </section>

    </div>
</main>

<footer class="rodape">
    <div class="container">
        <p>
            &copy; <?php echo date("Y"); ?> Secure Member Portal.
            Todos os direitos reservados.
        </p>
    </div>
</footer>

</body>
</html>