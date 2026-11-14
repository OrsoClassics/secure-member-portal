<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . "/../PHPMailer/src/Exception.php";
require_once __DIR__ . "/../PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer/src/SMTP.php";

function enviarEmail(
    string $destinatario,
    string $nome_destinatario,
    string $assunto,
    string $mensagem
): bool {
    $configuracao = require __DIR__ . "/../config/email.php";

    $email = new PHPMailer(true);

    try {
        $email->isSMTP();

        $email->Host = $configuracao["host"];
        $email->SMTPAuth = true;
        $email->Username = $configuracao["usuario"];
        $email->Password = $configuracao["senha"];

        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $email->Port = $configuracao["porta"];
        $email->CharSet = "UTF-8";

        $email->setFrom(
            $configuracao["remetente"],
            $configuracao["nome_remetente"]
        );

        $email->addAddress(
            $destinatario,
            $nome_destinatario
        );

        $email->isHTML(false);
        $email->Subject = $assunto;
        $email->Body = $mensagem;

        $email->send();

        return true;
    } catch (Exception $erro) {
        error_log(
            "Erro ao enviar e-mail: " . $email->ErrorInfo
        );

        return false;
    }
}