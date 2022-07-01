# News Board API
(Hillel Test Task 3)

## Deployed app links
- **[News Board API website](https://s0fcat.xyz)**
- **[Postman collection](https://documenter.getpostman.com/view/21715446/UzBvFiJN#3f64a0e4-2a45-4f38-a87a-a030ca9fef25)**

### Test deployed API

- Make **POST** request to `https://s0fcat.xyz/api/users` providing `username` and `password` in JSON-string.
- After the successful request you will get an authorization token. Use it in any of protected routes to identify yourself including `Authorization: Bearer *token*` header to each request.

## Installation
### Install dependencies
```
docker run --rm --interactive --tty --volume $(pwd):/app composer install
```

### Configure environment
Copy `.env.example` to `.env` and set settings according to your preferences.

### Install SSL certificates (if needed)
Copy `cerificate.crt` and `ca_bundle.crt` to `.docker/php/8.1-apache/etc/ssl`
and `private.key` to `.docker/php/8.1-apache/etc/ssl/private`

### Run docker containers
```
docker-compose up -d --build
```

### Run database migrations

```
docker-compose exec server php artisan migrate
```

OR inside the `server` container run
```
php artisan migrate
```


## Run code sniffer
E.g. to check `app` folder against the `PSR-12` coding standard
```
docker run --rm -v $(pwd):/data cytopia/phpcs --standard=PSR12 app
```
