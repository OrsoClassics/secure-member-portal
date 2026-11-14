# Secure Member Portal

Este é um projeto pessoal que estou desenvolvendo em PHP,
MySQL, cadastro de usuários, login, recuperação de senha por e-mail
e área protegida de downloads.

Após 10 anos longe do ramo, estou estudando e me inteirando
para voltar ao trabalho.

O projeto foi criado de forma simples, para que outras pessoas também
possam estudar o código e adaptar a aplicação para seus próprios projetos.

## Guia de instalação

A explicação completa para baixar, configurar e executar o projeto está em:

[Guia completo de instalação](docs/INSTALACAO.md)

## Funcionalidades atuais

- Cadastro de usuários
- Login por nickname ou e-mail
- Senhas protegidas com `password_hash`
- Sessões PHP
- Logout
- Recuperação de senha por e-mail
- Tokens temporários para redefinição de senha
- Área protegida para usuários
- Área de downloads

## Funcionalidades planejadas

Estas funcionalidades serão desenvolvidas em versões futuras:

- Aviso automático de novos cadastros
- Área administrativa
- Gerenciamento administrativo de downloads
- Controle completo de usuários administradores

## Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- PHPMailer
- SMTP

## Requisitos

Para executar o projeto localmente, será necessário instalar:

- XAMPP
- PHP
- MySQL
- Apache
- Git, caso queira baixar e acompanhar o projeto pelo GitHub

O projeto foi desenvolvido e testado no Windows usando o XAMPP.

## Como baixar o projeto

Existem duas formas de baixar o projeto.

### Usando Git

Abra o Git Bash e entre na pasta `htdocs` do XAMPP:

```bash
cd /c/xampp/htdocs

```

Clone o repositório:

```bash
git clone https://github.com/OrsoClassics/secure-member-portal.git
```

### Baixando pelo formato ZIP

1. Abra este repositório no GitHub.
2. Clique no botão `Code`.
3. Clique em `Download ZIP`.
4. Extraia o arquivo baixado.
5. Coloque a pasta extraída dentro de:

```text
C:\xampp\htdocs
```

O caminho final deverá ser:

```text
C:\xampp\htdocs\secure-member-portal
```

## Onde encontrar a instalação completa

O passo a passo detalhado em português está em:

[docs/INSTALACAO.md](docs/INSTALACAO.md)

A versão em inglês será criada depois que a documentação em português estiver finalizada.

## Segurança

Nunca publique:

- `config/banco.php`;
- `config/email.php`;
- senhas;
- senhas de aplicativo;
- tokens;
- bancos SQL com dados reais;
- backups;
- credenciais de servidor;
- dados reais de usuários.

Os arquivos públicos de configuração são apenas:

```text
config/banco.example.php
config/email.example.php
```

Eles servem como modelos para criar os arquivos reais durante a instalação.

## Estado do projeto

Este projeto está em desenvolvimento. As funções listadas em
“Funcionalidades planejadas” ainda não estão implementadas.

## Licença

A licença do projeto ainda será definida.

O PHPMailer possui sua própria licença. Os arquivos de licença
que acompanham a biblioteca devem ser mantidos.
