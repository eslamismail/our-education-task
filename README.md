## About Task 
- import json files to our database
- make parent email as forgin key 
- filter on transaction relation and return data 
- build service pattern 
- build app on with docker



## Notes 
- phpmyadmin image I added only to show database schema and changes on database
- if you reset database by wrong you can get run docker  <code>docker exec -it task_app php artisan migrate:fresh --seed</code>
- if want to run any command in container just run <code>docker exec -it ${container_name}  ${your command}</code> for example I want to run composer dump-autoload in task app container <code>docker exec -it task_app  composer dump-autoload</code>

## Run 
- <code> git clone git@github.com:eslamismail/our-education-task.git </code>
- <code> cd our-education-task</code>
- <code> cp .env.example .env </code>
- make sure you have docker in your machine and run <code> docker-compose up --build -d </code> -d if you want to run in background 
 - run migration and db seeder <code>docker exec -it task_app php artisan migrate --seed</code>
