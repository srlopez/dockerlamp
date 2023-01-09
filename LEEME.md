# A PELO
```
docker run -d --name db  -v %CD%\dump:/dump -e MYSQL_ROOT_PASSWORD=1234 -v mysql_data:/var/lib/mysql mysql:latest
docker exec -it db bash
    cd /dump
    mysql -u root -p1234 -e "CREATE DATABASE dbDATA;"
    mysql -u root -p1234 dbDATA <tableDataInit.sql
    mysql -u root -p1234 dbDATA <tablePetInit.sql
    exit
docker build -t phql .
docker images
docker run -d -v %CD%\www:/var/www/html -p 80:80 --link db phql
```

`Dockerfile` (Una imagen con PHP8 Apache 2.4 y librería de acceso a `mysql` )
```
FROM php:8.2-apache
ARG DEBIAN_FRONTEND=noninteractive
RUN docker-php-ext-install mysqli
RUN apt-get update \
    && apt-get install -y libzip-dev \
    && apt-get install -y zlib1g-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip
``` 

# DOCKER LAMP

Creamos tres servicios

1. Un motor MySQL
- base de datos: dbDATA (root/1234)
- se inicializa con: dump\\*.sql
- crea dos tablas: Data, pet
- la persistimos en un Volume: mysql_data

1. Un frontend con Apache 2.4 y php habilitado
- Tiene un index.php como único script en ./www:/var/www/html 
- explorer "http://localhost"

1. Un frontend administrador de la DB
- phpMyAdmin
- explorer "http://localhost:8000"


En dump se encuentran los script para inicializar la base de datos
base de Datos: dbData
tablas: Data, pet
root/1234

En www se encuentra Index.php que hace una lectura de Data y muestra los registros
La veremos en http://localhost?table=pet

En conf se han puesto valores de configuracion de mysql que sobreescribimos
lo podemos comprobar ejecutando
show variables like 'max_connections'
Esto da un error y se ignora. Parecen ser problemas de permisos


para hacer pruebas -->
docker-compose up -d
explorer "http://localhost?table=pet"
explorer "http://localhost:8000"
docker-compose down && docker volume prune -f && docker volume ls

Se ha puesto dos servicios de adm de BDATOS
http://localhost:8000 phpMyadmin
http://localhost:8080 adminer




# BACKUP

## Con comandos de la BD
### Backup
docker compose exec -it db mysql -u root -p1234 dbDATA -e "select * from pet;"
docker compose exec -it db mysqldump -u root -p1234 --databases dbDATA > backup/dbData.sql
### Restore
(desde el bash de git!!!!)
docker compose exec -it db mysql -u root -p1234 < backup/dbData.sql

## Con comandos de unix
(hay que parar la base de datos y dejar el container exited para poder acceder --volumes-from )
docker compose exec -it db mysql -u root -p1234 -e "shutdown;"
docker run -it -v %CD%\backup:/backup --volumes-from db ubuntu tar cvf /backup/backup.tar /var/lib/mysql
dir backup
docker run -it -v %CD%\backup:/backup --volumes-from db ubuntu tar xvf /backup/backup.tar
docker compose up -d db


## Commit de la imagen
(si los datos están en un volumen)
docker commit db  srlopez/mysql:8
docker images
docker image save -o backup/image.tar srlopez/mysql:8
docker rmi srlopez/mysql:8
docker image load -i backup/image.tar 
docker images

