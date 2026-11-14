GUIA DE INSTALAÇÃO — SECURE MEMBER PORTAL
==========================================

Este guia explica como baixar, configurar e executar o Secure Member Portal em um computador com Windows, usando XAMPP.

O projeto utiliza PHP, MySQL, Apache e PHPMailer para envio de e-mails por SMTP.

IMPORTANTE
----------

Este projeto foi preparado para ser usado como modelo. Os arquivos públicos não contêm as credenciais do autor.

Cada pessoa que instalar o projeto deverá criar os próprios arquivos de configuração:

    config/banco.php
    config/email.php

Esses arquivos são criados a partir dos modelos:

    config/banco.example.php
    config/email.example.php

Nunca publique no GitHub os arquivos reais de configuração, senhas, senhas de aplicativo, tokens, backups SQL ou dados reais de usuários.


1. REQUISITOS
-------------

Antes de começar, instale os seguintes programas no Windows:

- XAMPP;
- Git, caso queira clonar o projeto pelo terminal;
- um navegador, como Chrome, Edge ou Firefox;
- um editor de código, como Visual Studio Code.

O XAMPP fornece os dois serviços principais utilizados pela aplicação:

- Apache: executa os arquivos PHP;
- MySQL: armazena os dados do site.

O XAMPP também fornece o phpMyAdmin, que será usado para criar e administrar o banco de dados.


2. BAIXAR O PROJETO
-------------------

Existem duas formas de baixar o projeto.

2.1. Baixar usando Git

Se o Git estiver instalado, abra o Git Bash.

Entre na pasta de sites do XAMPP com:

    cd /c/xampp/htdocs

Clone o repositório com:

    git clone https://github.com/OrsoClassics/secure-member-portal.git

Depois entre na pasta criada:

    cd secure-member-portal

O caminho final do projeto deverá ser:

    C:\xampp\htdocs\secure-member-portal

O comando git clone cria automaticamente a pasta secure-member-portal. Por isso, não é necessário criar essa pasta manualmente antes de executar o comando.

2.2. Baixar usando Download ZIP

Também é possível baixar o projeto sem utilizar comandos Git.

1. Abra este repositório no GitHub.
2. Clique no botão Code.
3. Clique em Download ZIP.
4. Aguarde o download.
5. Extraia o arquivo ZIP.
6. Renomeie a pasta extraída para secure-member-portal, se necessário.
7. Coloque a pasta dentro de:

       C:\xampp\htdocs

O caminho final deverá ser:

    C:\xampp\htdocs\secure-member-portal


3. INICIAR O XAMPP
------------------

1. Abra o XAMPP Control Panel.
2. Clique em Start ao lado de Apache.
3. Clique em Start ao lado de MySQL.

Os dois serviços deverão aparecer como ativos, normalmente destacados em verde.

Se o Apache não iniciar, verifique se as portas 80 ou 443 estão sendo utilizadas por outro programa.

Se o MySQL não iniciar, verifique se a porta 3306 está sendo utilizada por outra instalação do MySQL.


4. CRIAR O BANCO DE DADOS
-------------------------

1. Abra o navegador.
2. Acesse:

       http://localhost/phpmyadmin

3. No menu lateral do phpMyAdmin, clique em Novo.
4. Crie um banco de dados chamado:

       secure_member_portal

5. Se houver uma opção de agrupamento ou collation, escolha:

       utf8mb4_unicode_ci

6. Clique em Criar.
7. Selecione o banco secure_member_portal no menu lateral.
8. Clique na aba Importar.
9. Clique em Escolher arquivo.
10. Selecione o arquivo do projeto:

       database/schema.sql

11. Clique em Continuar, Executar ou Go, conforme o idioma do phpMyAdmin.

Depois da importação, o banco deverá conter tabelas semelhantes a:

- usuarios;
- tokens_recuperacao;
- downloads.

O arquivo database/schema.sql contém somente a estrutura do banco. Ele não deve conter usuários, e-mails, senhas, tokens ou outros dados pessoais.


5. CONFIGURAR A CONEXÃO COM O BANCO
------------------------------------

Dentro da pasta do projeto existe o arquivo de exemplo:

    config/banco.example.php

Esse arquivo é público e não contém as credenciais reais de uma instalação.

Faça uma cópia dele na mesma pasta:

    config/banco.example.php

Renomeie a cópia para:

    config/banco.php

Depois dessa operação, a pasta config deverá conter, entre outros, estes arquivos:

    banco.example.php
    banco.php
    email.example.php
    email.php

Abra o arquivo:

    config/banco.php

Em uma instalação padrão do XAMPP, o conteúdo poderá ser semelhante a este:

    <?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "secure_member_portal";
    $porta = 3306;

    mysqli_report(MYSQLI_REPORT_OFF);

    $conexao = new mysqli(
        $servidor,
        $usuario,
        $senha,
        $banco,
        $porta
    );

    if ($conexao->connect_errno) {
        die("Não foi possível conectar ao banco de dados.");
    }

    $conexao->set_charset("utf8mb4");

Se o MySQL do computador usar outro usuário, senha, nome de banco ou porta, altere os valores correspondentes.

O arquivo config/banco.php deve permanecer somente no computador ou no servidor da instalação. Ele não deve ser enviado ao GitHub.


6. CONFIGURAR O ENVIO DE E-MAILS
--------------------------------

O projeto usa PHPMailer e SMTP para enviar mensagens de recuperação de senha e avisos administrativos.

Dentro da pasta config existe o arquivo:

    config/email.example.php

Faça uma cópia dele na mesma pasta e renomeie a cópia para:

    config/email.php

Abra o arquivo config/email.php e preencha os dados da sua própria conta de envio.

O formato será semelhante a este:

    <?php

    return [
        "host" => "smtp.gmail.com",
        "porta" => 587,
        "usuario" => "SEU_EMAIL_DE_ENVIO",
        "senha" => "SUA_SENHA_DE_APLICATIVO",
        "remetente" => "SEU_EMAIL_DE_ENVIO",
        "nome_remetente" => "Secure Member Portal",
        "email_administrador" => "EMAIL_QUE_RECEBERA_AVISOS"
    ];

Substitua os textos de exemplo pelos dados da sua própria configuração.

Para usar uma conta do Gmail, normalmente será necessário:

1. Ativar a verificação em duas etapas na conta Google.
2. Criar uma senha de aplicativo.
3. Usar a senha de aplicativo no campo senha.
4. Não utilizar a senha normal da conta Google.

O arquivo config/email.php contém informações privadas e não deve ser enviado ao GitHub.


7. CONFERIR O PHPMailer
-----------------------

O projeto utiliza a biblioteca PHPMailer para conectar ao servidor SMTP.

A pasta deverá existir dentro do projeto, por exemplo:

    PHPMailer/
    ├── language/
    └── src/

Dentro de src deverão existir arquivos como:

    Exception.php
    PHPMailer.php
    SMTP.php

Não altere os arquivos da biblioteca sem necessidade. Mantenha também os arquivos de licença e documentação que acompanham o PHPMailer.


8. ABRIR O PROJETO NO NAVEGADOR
-------------------------------

Depois de iniciar o Apache e configurar o banco, abra:

    http://localhost/secure-member-portal

O PHP precisa ser executado pelo Apache. Por isso, não abra os arquivos PHP com dois cliques diretamente no Explorador de Arquivos.

O endereço correto utiliza localhost.

Para abrir páginas específicas, os endereços terão este formato:

    http://localhost/secure-member-portal/cadastro.php
    http://localhost/secure-member-portal/login.php
    http://localhost/secure-member-portal/recuperar-senha.php


9. CRIAR A PRIMEIRA CONTA
-------------------------

1. Abra:

       http://localhost/secure-member-portal/cadastro.php

2. Preencha o formulário de cadastro.
3. Use um e-mail que possa ser consultado, caso queira testar a recuperação de senha.
4. Envie o cadastro.
5. Confira se o usuário foi salvo no banco pela tabela usuarios do phpMyAdmin.

A senha não deve aparecer em texto normal no banco. Ela deve ser armazenada como um hash.


10. TRANSFORMAR UM USUÁRIO EM ADMINISTRADOR
-------------------------------------------

O primeiro usuário normalmente é criado como usuário comum. Para transformar uma conta em administradora:

1. Abra:

       http://localhost/phpmyadmin

2. Selecione o banco:

       secure_member_portal

3. Clique na aba SQL.
4. Execute o comando abaixo, substituindo o e-mail pelo e-mail da conta desejada:

       UPDATE usuarios
       SET administrador = 1
       WHERE email = 'SEU_EMAIL_DE_LOGIN';

5. Para conferir o resultado, execute:

       SELECT id, nome, nickname, email, administrador
       FROM usuarios
       WHERE email = 'SEU_EMAIL_DE_LOGIN';

O campo administrador deverá apresentar o valor:

    1

Os valores desse campo significam:

    0 = usuário comum
    1 = administrador


11. TESTES RECOMENDADOS
-----------------------

Depois de configurar o projeto, teste as funções principais:

1. Abrir a página inicial.
2. Criar uma conta.
3. Conferir o novo registro na tabela usuarios.
4. Entrar pela página de login.
5. Sair da conta.
6. Acessar uma página protegida sem estar logado.
7. Solicitar recuperação de senha.
8. Conferir o e-mail recebido.
9. Abrir o link de redefinição.
10. Definir uma nova senha.
11. Entrar usando a nova senha.
12. Acessar a área de downloads.
13. Se o painel administrativo estiver disponível, entrar com a conta administradora.


12. ARQUIVOS QUE NÃO DEVEM SER PUBLICADOS
-----------------------------------------

Nunca envie ao GitHub:

    config/banco.php
    config/email.php

Também não envie:

- senhas;
- senhas de aplicativo;
- tokens de recuperação;
- arquivos SQL com dados reais;
- backups do banco;
- arquivos com credenciais do servidor;
- dados reais de usuários;
- logs que contenham informações privadas;
- arquivos de diagnóstico com informações do servidor.

Os arquivos públicos de exemplo são:

    config/banco.example.php
    config/email.example.php

Eles servem apenas como modelos para criar os arquivos reais na instalação local.


13. PROBLEMAS COMUNS
--------------------

13.1. Erro de conexão com o banco

Confira:

- se o MySQL está iniciado no XAMPP;
- se o banco secure_member_portal foi criado;
- se o arquivo config/banco.php existe;
- se o nome do banco está correto;
- se o usuário e a senha estão corretos;
- se a porta do MySQL está correta.

13.2. A página não abre ou mostra código PHP

Confira:

- se o Apache está iniciado;
- se a pasta está dentro de C:\xampp\htdocs;
- se o endereço começa com http://localhost;
- se o arquivo possui a extensão .php correta.

Não abra arquivos PHP diretamente com dois cliques.

13.3. O e-mail não é enviado

Confira:

- se config/email.php existe;
- se o host SMTP está correto;
- se a porta SMTP está correta;
- se o e-mail de envio está correto;
- se foi usada uma senha de aplicativo;
- se o e-mail recebido foi parar na pasta de spam;
- se a pasta PHPMailer está completa.

13.4. O arquivo banco.php ou email.php não existe

Copie o arquivo de exemplo correspondente e renomeie a cópia:

    config/banco.example.php  ->  config/banco.php
    config/email.example.php  ->  config/email.php

Não renomeie os arquivos de exemplo definitivamente. Eles devem permanecer no projeto para orientar outras instalações.


14. SOBRE O GIT E O GITHUB
---------------------------

O projeto possui um arquivo .gitignore para impedir o envio acidental de arquivos privados.

Mesmo assim, sempre confira os arquivos antes de executar um commit.

Os arquivos de configuração reais são específicos de cada instalação e não fazem parte do código público.


15. LICENÇA
-----------

A licença do projeto deverá ser consultada no arquivo LICENSE, quando ele estiver disponível.

O PHPMailer possui sua própria licença e seus arquivos de licença devem ser mantidos junto da biblioteca.
