> [!NOTE]
> Thanks to everyone involved in the recruitment process! I really appreciate your time and the opportunity.



## Project Overview
- **PHP 8.3**,
- **Symfony**,
- **PHPUnit**,
- **Docker**,
- **PgSQL**

## Goal
A simple **Products CRUD**, with a emphasis on DDD, Events and Unit Tests.


### Startup (with Docker)


```sh
docker network create indahash-crud
```


```sh
docker-compose up -d
```

### Access container:
```sh
docker-compose exec php-fpm bash
```

Or:

```sh
docker-compose exec php-fpm php bin/console
```

### Run migrations:

```sh
docker-compose exec php-fpm php bin/console doctrine:migrations:migrate
```

### Run tests:

```sh
docker-compose exec php-fpm php bin/phpunit
```

> [!WARNING]
> For the sake of convenience, testing db is by default the same as the main one.


##  Examples of requests

Paginated list:
```sh
curl --location 'localhost/api/products?sortDirection=asc&sortBy=grossPrice.value&page=2&limit=1'
```

Create product:
```sh
curl --location 'localhost/api/products' --header 'x-api-key: secret1337w23' --header 'Content-Type: application/json' --data '{"name":"Deathstar 15","description":"RIP Aldeeran","grossPrice":{"value":9900,"currency":"PLN"}}'
```

Update product:
```sh
curl --location --request PATCH 'localhost/api/products/0193e6b0-509e-7035-9aba-1e7c2be8006f' --header 'Content-Type: application/json' --data '{"name":"Deathstar 15","description":"2525"}'
```

See details:
```sh
curl --location 'localhost/api/products/0193e6c5-78dc-7857-b319-f71cce9f7906'
```

Delete product:
```sh
curl --location --request DELETE 'localhost/api/products/0193e6b0-7edb-7dbd-8551-13a3fb033ace' 
```


## Conclusion
I enjoyed working on this project and I hope it showcases my skills. I appreciate the opportunity and I look forward to hearing your feedback. Thank you for your time and consideration.
