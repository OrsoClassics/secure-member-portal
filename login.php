<?php

session_start();

require_once "config/banco.php";

$mensagem = "";
$tipo_mensagem = "";
$identificador = "";

if (isset($_SESSION["usuario_id"])) {
    header("Location: painel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identificador = trim($_POST["identificador"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (empty($identificador) || empty($senha)) {
        $mensagem = "Preencha o nickname ou e-mail e a senha.";
        $tipo_mensagem = "erro";
    } else {
        $consulta = $conexao->prepare(
            "SELECT id, nome, nickname, email, senha
             FROM usuarios
             WHERE nickname = ? OR email = ?
             LIMIT 1"
        );

        $consulta->bind_param(
            "ss",
            $identificador,
            $identificador
        );

        $consulta->execute();

        $resultado = $consulta->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario && password_verify($senha, $usuario["senha"])) {
            session_regenerate_id(true);

            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            $_SESSION["usuario_nickname"] = $usuario["nickname"];
            $_SESSION["usuario_email"] = $usuario["email"];

            header("Location: painel.php");
            exit;
        } else {
            $mensagem = "Nickname/e-mail ou senha incorretos.";
            $tipo_mensagem = "erro";
        }

        $consulta->close();
    }
}

$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entrar - Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="cadastro.php">Criar cadastro</a>
        </nav>
    </div>
</header>

<main class="pagina-formulario">
    <div class="container">

        <section class="cartao-formulario">
            <p class="etiqueta-formulario">Área restrita</p>

            <h1>Entrar</h1>

            <p class="texto-formulario">
                Entre com seu nickname ou e-mail para acessar o site.
            </p>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem <?php echo $tipo_mensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="campo">
                    <label for="identificador">
                        Nickname ou e-mail
                    </label>

                    <input
                        type="text"
                        id="identificador"
                        name="identificador"
                        value="<?php echo htmlspecialchars($identificador); ?>"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="botao botao-principal botao-formulario"
                >
                    Entrar
                </button>
            </form>

            <p class="link-recuperacao">
                <a href="recuperar-senha.php">
                    Esqueci minha senha
                </a>
            </p>

            <p class="rodape-formulario">
                Ainda não possui uma conta?
                <a href="cadastro.php">Criar cadastro</a>
            </p>
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