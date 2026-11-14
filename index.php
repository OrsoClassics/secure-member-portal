<?php
session_start( );
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="downloads.php">Downloads</a>

            <?php if (isset($_SESSION["usuario_id"])): ?>
                <a href="painel.php">Minha conta</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastro.php" class="botao-menu">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="conteudo-principal">
    <section class="hero">
        <div class="container">
            <p class="etiqueta">Bem-vindo ao Secure Member Portal</p>

            <h1>Conteúdo organizado em um só lugar.</h1>

            <p class="descricao">
                Cadastre-se gratuitamente para acessar a área de conteúdos
                e downloads do site.
            </p>

            <div class="acoes">
                <?php if (isset($_SESSION["usuario_id"])): ?>
                    <a href="downloads.php" class="botao botao-principal">
                        Acessar downloads
                    </a>
                <?php else: ?>
                    <a href="cadastro.php" class="botao botao-principal">
                        Criar cadastro
                    </a>

                    <a href="login.php" class="botao botao-secundario">
                        Já tenho uma conta
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="aviso-acesso">
        <div class="container">
            <h2>Acesso necessário</h2>

            <p>
                Para acessar o conteúdo completo e a área de downloads,
                você deverá criar uma conta ou entrar em uma conta existente.
            </p>
        </div>
    </section>
</main>

<footer class="rodape">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> Secure Member Portal. Todos os direitos reservados.</p>
    </div>
</footer>

<?php if (!isset($_SESSION["usuario_id"] )): ?>

<script>
    window.addEventListener("DOMContentLoaded", function () {
        alert(
            "Para acessar o conteúdo completo, faça seu cadastro ou entre na sua conta."
        );
    });
</script>

<?php endif; ?>

</body>
</html>