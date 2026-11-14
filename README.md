# Secure Member Portal

This is a personal project that I am developing using PHP, MySQL, user registration, login, password recovery by email, and a protected download area.

After spending 10 years away from the field, I am studying and getting familiar with the technologies again in order to return to professional work.

The project was created in a simple way so that other people can study the code and adapt the application for their own projects.

## Installation guide

Complete instructions for downloading, configuring, and running the project are available in:

[Complete installation guide](docs/INSTALLATION.md)

A Portuguese version is also available:

[Guia completo de instalação](docs/INSTALACAO.md)

## Current features

- User registration
- Login using nickname or email
- Passwords protected with `password_hash`
- PHP sessions
- Logout
- Password recovery by email
- Temporary password reset tokens
- Protected user area
- Download area

## Planned features

The following features are planned for future versions:

- Automatic new user registration notifications
- Administration area
- Administrative download management
- Complete administrator user control

## Technologies

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- PHPMailer
- SMTP

## Requirements

To run the project locally, you will need to install:

- XAMPP
- PHP
- MySQL
- Apache
- Git, if you want to download and follow the project using GitHub

The project was developed and tested on Windows using XAMPP.

## How to download the project

There are two ways to download the project.

### Using Git

Open Git Bash and enter the XAMPP `htdocs` folder:

```bash
cd /c/xampp/htdocs
```

Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/secure-member-portal.git
```

Replace `YOUR_USERNAME` with the actual GitHub account name that owns this repository.

Then enter the folder that was created:

```bash
cd secure-member-portal
```

### Downloading as a ZIP file

1. Open this repository on GitHub.
2. Click the `Code` button.
3. Click `Download ZIP`.
4. Extract the downloaded file.
5. Place the extracted folder inside:

```text
C:\xampp\htdocs
```

The final path should be:

```text
C:\xampp\htdocs\secure-member-portal
```

## Where to find the complete installation guide

The detailed installation guide in English is available at:

[docs/INSTALLATION.md](docs/INSTALLATION.md)

The Portuguese version is available at:

[docs/INSTALACAO.md](docs/INSTALACAO.md)

## Security

Never publish:

- `config/banco.php`;
- `config/email.php`;
- passwords;
- app passwords;
- tokens;
- SQL databases containing real data;
- backups;
- server credentials;
- real user data.

The public configuration files are only:

```text
config/banco.example.php
config/email.example.php
```

They are templates used to create the real files during installation.

## Project status

This project is still under development. The features listed under
“Planned features” have not been implemented yet.

## License

The project license has not been defined yet.

PHPMailer has its own license. The license files that come with the
library must be kept.
