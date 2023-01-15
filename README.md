# zeaL-app

ENVIRONMENT:
- sudo apt install mysql server
- sudo apt install apache2
- sudo apt install php8.1

- composer install
- sudo chmod -R 755 app/Logs
- touch .env, and compare with .env.example
- setup .env
- create schema `zeaL`, and import zeaL.sql file
- run seeder.php file to seed students into students table
- sudo apt install redis-server

# With cron
- systemctl restart apache2/nginx
- - crontab -e
- //set time you need in crontab
- * * * * * php /path-to-your-project/kernel.php >/dev/null 2>&1
- systemctl start redis
- systemctl start cron

# Without cron
- just start /kernel.php to execute cron script object
- if you visit student/id route, that will do same script like kernel.php, but for only specified student
 

# Routes
- php -S localhost:8000
- '/' all students list

# Recommended testing for app status
- before start and check route, open a terminal,
execute commands 
-redis-cli 
-FLUSHALL
- after that go to routes and check network F12, you will see request response in miliseconds for student route,
second time after you checked response, now you will see so much lower time response, because in second http request we get response from redis cache...

# ENJOY



