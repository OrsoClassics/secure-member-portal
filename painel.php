<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$nome_usuario = $_SESSION["usuario_nome"];
$nickname_usuario = $_SESSION["usuario_nickname"];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minha conta - Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="downloads.php">Downloads</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>
</header>

<main class="pagina-painel">
    <div class="container">

        <section class="cabecalho-painel">
            <p class="etiqueta-formulario">Área do usuário</p>

            <h1>
                Olá, <?php echo htmlspecialchars($nome_usuario); ?>!
            </h1>

            <p>
                Você está conectado como
                <strong>
                    <?php echo htmlspecialchars($nickname_usuario); ?>
                </strong>.
            </p>
        </section>

        <section class="grade-painel">

            <a href="downloads.php" class="cartao-painel">
                <span class="icone-painel">↓</span>
                <h2>Downloads</h2>
                <p>
                    Acesse os arquivos disponíveis no site.
                </p>
            </a>

            <a href="index.php" class="cartao-painel">
                <span class="icone-painel">⌂</span>
                <h2>Página inicial</h2>
                <p>
                    Volte para a página inicial do Secure Member Portal.
                </p>
            </a>

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