
Nottes backend
==================

[![Build Status](https://travis-ci.org/viher3/nottes-backend.svg?branch=master)](https://travis-ci.org/viher3/nottes-backend)
[![Coverage Status](https://coveralls.io/repos/github/viher3/nottes-backend/badge.svg?branch=master)](https://coveralls.io/github/viher3/nottes-backend?branch=master)

## Screenshots

<img src="https://raw.githubusercontent.com/viher3/nottes-backend/master/screenshots/nottes_1.png" width="150">
<img src="https://raw.githubusercontent.com/viher3/nottes-backend/master/screenshots/nottes_2.png" width="150">
<img src="https://raw.githubusercontent.com/viher3/nottes-backend/master/screenshots/nottes_3.png" width="150">
<img src="https://raw.githubusercontent.com/viher3/nottes-backend/master/screenshots/nottes_4.png" width="150">

## Features

Version 1 features:

- [x] Create a notte entity
- [x] Encrypt / decrypt nottte entities using [php-encryption](https://github.com/defuse/php-encryption) library
- [x] Upload file/s
- [x] Simple search for entities

Comming soon features:

- [ ] User management
- [ ] User roles management
- [ ] Categories management

## Common installation

Install dependencies

    composer install

Create database schema

    php bin/console doctrine:schema:create

Create a new admin user

    php bin/console fos:user:create --super-admin

You can run backend in your favorite web server or run it with the built-in web server

    php bin/console server:start


## Docker installation

You have to copy your SSL certificate files (*fullchain.pem* and *privkey.pem*) in the folder defined in the *docker-compose.yml* file:

    # ./docker/prod/docker-compose.yml
    /var/www/ssl_certs:/var/www/ssl_certs

You can custom the folder path:

    # ./docker/prod/docker-compose.yml
    /your-custom-path:/var/www/ssl_certs

Run the docker container

    cd /your-app-folder/docker/prod
    docker-compose up -d

Now the backend is running

    https://localhost:8083

## API REST documentation

You can view the API REST documentation here:

http://localhost:8000/api/doc
