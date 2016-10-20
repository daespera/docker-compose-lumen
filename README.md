# docker-compose-lumen
docker-compose lumen expirement

## Requirements

* [Docker Engine](https://docs.docker.com/installation/)
* [Docker Compose](https://docs.docker.com/compose/)
* [Docker Machine](https://docs.docker.com/machine/) (Mac and Windows only)
 

## Running

Set up a Docker Machine and then run:

```sh
$ docker-compose build
```
```sh
$ docker-compose up
```
```sh
$ docker exec lumen-php composer install -d /app
```

## Data Migration

```sh
sudo docker exec lumen-php php /app/artisan migrate:install
```
```sh
sudo docker exec lumen-php php /app/artisan migrate
```

## Data Seeding

```sh
sudo docker exec lumen-php php /app/artisan db:seed
```