# FabCoders Code Challenge

## Local development environment setup with docker

1. Install docker and docker-compose. Both docker and docker-compose commands should be available from cli  

    **Windows**  
    https://docs.docker.com/docker-for-windows/install/ 

    **Ubuntu**  
    https://docs.docker.com/engine/install/ubuntu/  
    https://docs.docker.com/compose/install/

2. Create a .env file and make sure that the DB has a user other than root and also has a password set (This is usually a problem with Windows WSL installation of docker). DB_HOST should be set to db as the service name for the mysql container is db.

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=appointnow
DB_USERNAME=rage13
DB_PASSWORD=rage13

DOCKER_APP_PORT=8080
DOCKER_DB_PORT=3306

```
3. Run ```./develop start```
4. Run ```./develop composer install```

The application server will now be running at http://127.0.0.1:8080/

You can access adminer at http://127.0.0.1:9090/


## Development environment additional commands

### Starting the Nginx, MySQL and Redis servers
```console
./develop start
```

### Stopping the Nginx, MySQL and Redis servers
```console
./develop stop
```

### Running composer commands
```console
./develop composer install
```

### Running artisan commands
```console
./develop artisan make:seeder BoringSeederName
```

### Importing a database dump
```console
./develop importdb ./db_dump.sql
```

### Opening a container in IT mode
```console
docker exec -it container_name /bin/bash -l
```


## Installation Guide with out Docker

### Clone the repo and use the excat `.env.example` file

### Run the following commands

```
php artisan migrate
php artisan storage:link
```

### You can access the application VIA localhost.
