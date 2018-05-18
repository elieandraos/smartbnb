## Deploying Laravel
Run composer install to install laravel dependencies and create your .env file
```
composer install
```

Run the migrations to create the database tables
```
php artisan migrate
```
 
Install Passport. It will create api token keys for security.
```
php artisan passport:install
```