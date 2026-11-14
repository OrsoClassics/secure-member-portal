<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config/banco.php";

$downloads = [];

$consulta = $conexao->prepare(
    "SELECT id, titulo, descricao, nome_arquivo, caminho_arquivo, criado_em
     FROM downloads
     ORDER BY criado_em DESC"
);

$consulta->execute();

$resultado = $consulta->get_result();

while ($download = $resultado->fetch_assoc()) {
    $downloads[] = $download;
}

$consulta->close();
$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Downloads - Secure Member Portal</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="cabecalho">
    <div class="container cabecalho-conteudo">
        <a href="index.php" class="logo">Secure Member Portal</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="painel.php">Minha conta</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>
</header>

<main class="pagina-downloads">
    <div class="container">

        <section class="cabecalho-pagina">
            <p class="etiqueta-formulario">Área exclusiva</p>

            <h1>Downloads</h1>

            <p>
                Aqui ficarão disponíveis os arquivos e conteúdos do Secure Member Portal.
            </p>
        </section>

        <?php if (count($downloads) === 0): ?>

            <section class="estado-vazio">
                <div class="icone-vazio">↓</div>

                <h2>Nenhum download disponível</h2>

                <p>
                    Os arquivos serão adicionados nesta área futuramente.
                </p>
            </section>

        <?php else: ?>

            <section class="grade-downloads">

                <?php foreach ($downloads as $download): ?>

                    <article class="cartao-download">
                        <div class="icone-download">↓</div>

                        <div class="conteudo-download">
                            <h2>
                                <?php echo htmlspecialchars($download["titulo"]); ?>
                            </h2>

                            <?php if (!empty($download["descricao"])): ?>
                                <p>
                                    <?php
                                    echo nl2br(
                                        htmlspecialchars($download["descricao"])
                                    );
                                    ?>
                                </p>
                            <?php endif; ?>

                            <a
                                href="<?php echo htmlspecialchars(
                                    $download["caminho_arquivo"]
                                ); ?>"
                                class="botao botao-principal"
                                download
                            >
                                Baixar arquivo
                            </a>
                        </div>
                    </article>

                <?php endforeach; ?>

            </section>

        <?php endif; ?>

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