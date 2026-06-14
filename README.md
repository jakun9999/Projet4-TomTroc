# Projet4-TomTroc

Repository project 4 - Openclassrooms Full stack developper training.
Project is based on below FIGMA prototypes:

https://www.figma.com/design/igDdidGb6uJ7ykjROaAB8z/P6-PHP-Symfony---Tom-Troc?node-id=0-1&p=f&t=2q5uvlKBbnqRr1tV-0

https://www.figma.com/proto/igDdidGb6uJ7ykjROaAB8z/P6-PHP-Symfony---Tom-Troc?type=design&node-id=227-682&t=Q3DAu7kM6duopFNZ-1&scaling=min-zoom&page-id=0%3A1&starting-point-node-id=227%3A618

Project is a ready to use Docker compose containers with following services:
- APACHE/PHP 8 container
- MYSQL container
- PHPMYADMIN container for tests only (sql init file is included to create
required database at first start).

Before using the project download Docker Desktop and NodeJS.
- https://www.docker.com/
- https://nodejs.org/en

## IMPORTANT:
A set of users, book and messages is available in sql init file.
Demo user login : demo@demo.com
Demo user password : Azerty$1

Other existing users use the same password.

Before starting containers make sure to copy both configuration files and 
define configuration credentials.

```
cp .env.example .env
```
MYSQL_ROOT_PASSWORD and MYSQL_PASSWORD needs to be defined in your new .env.

```
cp ./www/config/conf.example.php ./www/config/conf.php
```
DB_PASS needs to be defined using MYSQL_ROOT_PASSWORD you defined in .env.

## Technologies

- HTML/CSS/JS
- TAILWINDCSS 4.3
- DOCKER
- PHP 8 ON APACHE
- MYSQL 8
- COMPOSER (autoloader)
- MYSQL

## Composer requires to read composer configuration and files.
Use the following command in VS Code while in root folder, open a terminal :

```
composer install
```

## How to install tailwind in the project.
In VS Code open a terminal when you are in root folder of the project and
run following command.

```
npm install tailwindcss @tailwindcss/cli @tailwindcss/oxide-linux-x64-gnu
```

## Always start tailwindcss watcher before modifying any template css classes !

```
npx tailwindcss -i ./www/public/assets/css/input.css -o ./www/public/assets/css/styles.css --watch
```

## How to start dev mode.

```
docker compose up --build -d
```

## How to stop docker containers without losing data.

```
docker compose down
```
## How to stop docker containers with database removal.

```
docker compose down -v
```

## Remarks

Image upload forms and subscription form may take a few seconds to be processed.
This is mainly due in development environment to security measures (password)
encryption and image treatment against embedded code.

## Author

- Matthieu LUCAS [email](mailto:matthieulucas457@outlook.fr)
