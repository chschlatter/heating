# heating

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
$ docker run -v "$(pwd)":/var/www/html -v data:/data -p 8000:80 heating-app
```

Run container for production:

```
$ docker run -v data:/data -p 8000:80 heating-app
