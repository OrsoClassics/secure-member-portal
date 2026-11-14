<?php

ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
session_start();

require_once "config/banco.php";

$mensagem = "";
$tipo_mensagem = "";
$email_digitado = "";
$link_teste = "";

if (isset($_SESSION["usuario_id"])) {
    header("Location: painel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email_digitado = trim($_POST["email"] ?? "");

    if (empty($email_digitado)) {
        $mensagem = "Digite o e-mail da sua conta.";
        $tipo_mensagem = "erro";
    } elseif (!filter_var($email_digitado, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Digite um e-mail válido.";
        $tipo_mensagem = "erro";
    } else {
        $consulta = $conexao->prepare(
            "SELECT id, nome
             FROM usuarios
             WHERE email = ?
             LIMIT 1"
        );

        $consulta->bind_param("s", $email_digitado);
        $consulta->execute();

        $resultado = $consulta->get_result();
        $usuario = $resultado->fetch_assoc();

        $consulta->close();

        /*
         * A mensagem será a mesma mesmo quando o e-mail
         * não estiver cadastrado. Isso evita revelar quais
         * e-mails possuem conta no site.
         */
        $mensagem =
            "Se o e-mail estiver cadastrado, você receberá "
            . "um link para redefinir a senha.";
        $tipo_mensagem = "sucesso";

        if ($usuario) {
            /*
             * Remove tokens antigos desse usuário.
             */
            $limpar = $conexao->prepare(
                "DELETE FROM tokens_recuperacao
                 WHERE usuario_id = ?"
            );

            $limpar->bind_param("i", $usuario["id"]);
            $limpar->execute();
            $limpar->close();

            /*
             * Cria um token aleatório de uso único.
             */
            $token_original = bin2hex(random_bytes(32));
            $token_banco = hash("sha256", $token_original);

            /*
             * O token valerá por uma hora.
             */
            $expira_em = date(
                "Y-m-d H:i:s",
                time() + 3600
            );

            $insercao = $conexao->prepare(
                "INSERT INTO tokens_recuperacao
                (usuario_id, token, expira_em)
                VALUES (?, ?, ?)"
            );

            $insercao->bind_param(
                "iss",
                $usuario["id"],
                $token_banco,
                $expira_em
            );

            $insercao->execute();
            $insercao->close();

            $protocolo = (
                isset($_SERVER["HTTPS"])
                && $_SERVER["HTTPS"] !== "off"
            ) ? "https" : "http";

            $endereco_base =
                $protocolo
                . "://"
                . $_SERVER["HTTP_HOST"]
                . dirname($_SERVER["PHP_SELF"] );

            $link_recuperacao =
                rtrim($endereco_base, "/")
                . "/redefinir-senha.php?token="
                . urlencode($token_original);

            $assunto = "Recuperação de senha - Secure Member Portal";

            $mensagem_email =
                "Olá, "
                . $usuario["nome"]
                . "!\n\n"
                . "Recebemos uma solicitação para redefinir "
                . "a senha da sua conta no Secure Member Portal.\n\n"
                . "Acesse o link abaixo para criar uma nova senha:\n"
                . $link_recuperacao
                . "\n\n"
                . "Esse link expira em uma hora.\n\n"
                . "Se você não solicitou essa alteração, ignore "
                . "esta mensagem.";

            require_once __DIR__ . "/includes/enviar-email.php";

            $enviado = enviarEmail(
                $email_digitado,
                $usuario["nome"],
                $assunto,
                $mensagem_email
            );

            /*
             * Link temporário apenas para teste local.
             * Ele será removido antes da publicação.
             */
            
        }
    }
}

$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recuperar senha - Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="login.php">Entrar</a>
            <a href="cadastro.php">Criar cadastro</a>
        </nav>
    </div>
</header>

<main class="pagina-formulario">
    <div class="container">

        <section class="cartao-formulario">
            <p class="etiqueta-formulario">Acesso à conta</p>

            <h1>Recuperar senha</h1>

            <p class="texto-formulario">
                Informe o e-mail usado no cadastro. Enviaremos
                instruções para criar uma nova senha.
            </p>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem <?php echo $tipo_mensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="recuperar-senha.php">

                <div class="campo">
                    <label for="email">E-mail da conta</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($email_digitado); ?>"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="botao botao-principal botao-formulario"
                >
                    Enviar instruções
                </button>
            </form>

            <p class="rodape-formulario">
                Lembrou a senha?
                <a href="login.php">Voltar para o login</a>
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