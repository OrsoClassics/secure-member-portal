<?php

session_start();

require_once "config/banco.php";

$mensagem = "";
$tipo_mensagem = "";

$nome = "";
$nickname = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $nickname = trim($_POST["nickname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $confirmar_senha = $_POST["confirmar_senha"] ?? "";

    if (
        empty($nome) ||
        empty($nickname) ||
        empty($email) ||
        empty($senha) ||
        empty($confirmar_senha)
    ) {
        $mensagem = "Preencha todos os campos.";
        $tipo_mensagem = "erro";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Digite um e-mail válido.";
        $tipo_mensagem = "erro";
    } elseif (strlen($nickname) < 3) {
        $mensagem = "O nickname deve ter pelo menos 3 caracteres.";
        $tipo_mensagem = "erro";
    } elseif (strlen($senha) < 6) {
        $mensagem = "A senha deve ter pelo menos 6 caracteres.";
        $tipo_mensagem = "erro";
    } elseif ($senha !== $confirmar_senha) {
        $mensagem = "As senhas não são iguais.";
        $tipo_mensagem = "erro";
    } else {
        $consulta = $conexao->prepare(
            "SELECT id FROM usuarios WHERE nickname = ? OR email = ?"
        );

        $consulta->bind_param("ss", $nickname, $email);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            $mensagem = "Nickname ou e-mail já cadastrado.";
            $tipo_mensagem = "erro";
        } else {
            $senha_protegida = password_hash($senha, PASSWORD_DEFAULT);

            $insercao = $conexao->prepare(
                "INSERT INTO usuarios
                (nome, nickname, email, senha)
                VALUES (?, ?, ?, ?)"
            );

            $insercao->bind_param(
                "ssss",
                $nome,
                $nickname,
                $email,
                $senha_protegida
            );

            if ($insercao->execute()) {
                $mensagem = "Cadastro realizado com sucesso! Você já pode entrar.";
                $tipo_mensagem = "sucesso";

                $nome = "";
                $nickname = "";
                $email = "";
            } else {
                $mensagem = "Não foi possível realizar o cadastro.";
                $tipo_mensagem = "erro";
            }

            $insercao->close();
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

    <title>Criar cadastro - Secure Member Portal</title>

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
            <p class="etiqueta-formulario">Novo usuário</p>

            <h1>Criar cadastro</h1>

            <p class="texto-formulario">
                Preencha os dados abaixo para criar sua conta.
            </p>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem <?php echo $tipo_mensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="cadastro.php">

                <div class="campo">
                    <label for="nome">Nome completo</label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?php echo htmlspecialchars($nome); ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="nickname">Nickname</label>

                    <input
                        type="text"
                        id="nickname"
                        name="nickname"
                        value="<?php echo htmlspecialchars($nickname); ?>"
                        minlength="3"
                        maxlength="50"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="email">E-mail</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        minlength="6"
                        required
                    >

                    <small>A senha deve ter pelo menos 6 caracteres.</small>
                </div>

                <div class="campo">
                    <label for="confirmar_senha">Confirmar senha</label>

                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        minlength="6"
                        required
                    >
                </div>

                <button type="submit" class="botao botao-principal botao-formulario">
                    Criar cadastro
                </button>
            </form>

            <p class="rodape-formulario">
                Já possui uma conta?
                <a href="login.php">Entrar agora</a>
            </p>
        </section>

    </div>
</main>

<footer class="rodape">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> Secure Member Portal. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>