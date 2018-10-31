# News Aggregator
Open source news aggregator that prioritizes news based on "tags" created by a logged in user.


# Requirements
## Crawler + User scripts
1. Python3
2. Install pymysql, bs4, arrow, python-dotenv via pip

## Website
1. MYSQL
2. PHP 7.1.8
3. Apache

# How to install via Docker (First time install)
## Back-end
1. Set up all the config variables. The dotenv file needs to have the correct MySQL credentials. Here's an example of what it should look like:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=root
```
2. Install composer dependencies using ```composer install```
3. Build the docker environment ```docker-compose up --build```
4. Log into your server, and use ```php artisan migrate && php artisan db:seed``` to migrate your database


## Front-end
1. Run ```npm install``` inside the root