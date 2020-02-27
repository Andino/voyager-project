<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Instalation process

-   ###### Execute `composer install` in your command line, to install all the packages used in the project
-   ###### create the `.env` file
-   ###### Use `php artisan key:generate`
-   ###### change the value of `APP_URL` in the `.env` file from `http://localhost` to `http://localhost:8000`
-   ###### execute the migration and the user seed with the follow command: `php artisan migrate --seed`
-   ###### The user credentials are `email: admin@gmail.com` & `password:secret`
-   ###### Assign admin privileges to the existing user with the command: `php artisan voyager:admin
-   ###### Run the voyager seeders: `php artisan db:seed --class=VoyagerDatabaseSeeder`
-   ###### Run `php artisan hook:setup` to install the hooks system.
-   ###### Run `php artisan storage:link` to create the storage symlink to your public folder.
-   ###### Finally, run `composer dump-autoload` to finish your installation!

##### After this last step, you can run the app with the `php artisan serve` command
