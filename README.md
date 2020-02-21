DUEDATE API
===

Pré-requisitos
---

Os seguintes programas precisam estar instalados no ambiente:

*  php7.2
*  sqlite3
*  mysql5.7
*  redis

1.  Instale o composer globalmente seguindo as instruções em **https://getcomposer.org/download**

1.  Instale o node globalmente seguindo as instruções em **https://nodejs.org/download/**

Passos para iniciar o ambiente
---

Faça os passos abaixo após o clone para ter o projeto funcionando:

1.  Instale as dependências do composer

        composer install

1.  Copie o arquivo `.env.example` para `.env`

        cp .env.example .env

1.  Criar banco de dados

        CREATE DATABASE due_date DEFAULT CHARSET utf8 DEFAULT COLLATE utf8_general_ci;

1.  Altere as configurações de banco de dados para utilizar o seu banco local

        vim .env

1.  Crie uma nova chave para a aplicação

        php artisan key:generate

1.  Execute as migrations

        php artisan migrate

1.  Execute o seed do banco de dados

        php artisan db:seed

Dependências NodeJs
---
1. Instale as dependencias do nodejs:

        npm install
        
1.  Execute gulp

        ./node_modules/gulp/bin/gulp.js --production
        
Documentação
---     
                      
1.  Execute comando para gerar a documentação da API

        npm run doc
        
Testes
---

1. Para executar teste unitários

        vendor/bin/phpunit
