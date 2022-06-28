# Steps to setup hr-infra

- Copy the repository.
- Run command `sh build.sh dev` in the console for dev deployment.
- The `www` folder should be created then clone `hr-service` projects from their respective repositories inside it.

### Steps to setup hr-service

- Run build script in `dev`/`prod` mode  to start the docker containers.
- Open a new tab in the terminal and run command `docker exec -it hr-webserver /bin/bash` to enter the hr-webserver container.
- Navigate to the hr-service directory inside the container.
- Run command `composer install`.
- Go the `phpmyadmin` and create db with name `hr_db`.
- From your code editor navigate to `www/hr-service/storage/logs` and create `laravel.log` file if not exists.
- Create a .env file inside `www/hr-service` and copy the contents of .env.example in it.
- Make the following changes inside the .env
    `DB_HOST=hr-mysql`
    `DB_DATABASE=hr_db`
    `DB_PASSWORD=password`
- Go back to the terminal(where composer install ran) and run command `php artisan migrate`.
- Then run the following commands for giving permission to the laravel.log file in the exact order they are written
    1.`chmod -R gu+w storage` 
    2.`chmod -R guo+w storage`
    3.`php artisan cache:clear`
    4.`php artisan key:generate`
- Go to the url http://localhost/service where hr-service is running.
