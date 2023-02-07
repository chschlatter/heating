# Heating Statistics

## PHP dependencies / composer

Install PHP dependencies based on composer.lock/composer.json.

```
$ php composer.phar install
```

## Docker

Build docker image: 

```
$ docker build . -t heating-app
```

Run container for development (bind mount PHP sources):

```
$ docker run -v "$(pwd)":/var/www/html -v data:/data -p 80:80 heating-app
```

Run container for production, with docker compose:

```
$ docker compose up
```

## fly.io - create application

Create `.env` based on `.env.example` with `APP_ADMIN_PWD` and S3 access key.

Export `.env` into fly secrets: 

```
$ fly secrets import < .env
```

Create fly volume `heating_db` and change ownership once app is deployed:

```
$ fly ssh console -C "chown www-data /data"
```

Create certificate for custom domain name and A/AAAA (IPv6 is required!) DNS records.

## fly.io - deploy application

```
$ fly deploy
```

ssh into VM:

```
$ fly ssh console
