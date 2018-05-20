## Deploying Smartbnb test project
Run composer install to install laravel dependencies and create your .env file
```
composer install
```

Run the migrations to create the database tables and seed the countries and admin user
```
php artisan migrate --seed
```
 
Install Passport. It will create api token keys for security.
```
php artisan passport:install
```