**IMS Service**

# Development Setup:

## 1. Create a new MySQL database and user. For example:

    CREATE DATABASE ims;
    GRANT ALL PRIVILEGES ON ims.* TO 'ims'@'%' IDENTIFIED BY 'password';

    This will create a new database named ims and a MySQL user named ims with a password of password.

## 2. Install dependencies:
    
    composer install

    Add database connection parameters to .env file.
    
    NOTE: Create a copy of .env.example for reasonable development defaults.
    
    NOTE: If your .env file does not have an APP_KEY value, run
        php artisan key:generate 
        to create one.

## 3. Seed database data:

    php artisan migrate --seed

    This will create the required database tables and seed default application.

License
Private
