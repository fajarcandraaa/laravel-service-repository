<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<!-- ABOUT THE PROJECT -->
## About The Project

This is a simple project to implement Service-Repository Design Pattern using Laravel. To be known :
* `The repository` is a layer between the domain and data layers of your application with an interface to perform create, read, update and delete CRUD operations. By using repositories in your application, you allow CRUD operations for an object to be handled by one class which can then be injected into other areas of your code.
* `Services` is a layer for the business logic of your application. It simply performs the a set task (e.g. calculating a loan, updating a user) using the information provided, using any repositories or other classes you have created outside of the service.

The idea of the Repository and Service pattern are to keep the business logic (services) and the data access logic (repositories) of your app contained in their own sections. So, it's making code more readable, expandable and maintenaceable.

### Built With

This section should list any major frameworks that you built your project using. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.
* [PHP](https://www.php.net)
* [Laravel](https://laravel.com)
* [PostgreSQL](http://www.postgresql.org)

And supporting tools to easy testing like :
* [Postman](https://www.postman.com)

<!-- GETTING STARTED -->
## Getting Started
So, let start it.
1. After clone this repository, just run `composer update`.
2. Setup your `.env` file such as database connection depend on you existing device.
3. To make sure that all dependency is run well, than run `php artisan migrate` to doing migration and migrate all databse that we provide in this project.
4. Than you can run `php artisan db:seed` if you need seeder for user, or you can manualy register user with register endpoint.
4. Finally, you can run your project with command: `php artisan serve`.
5. Go to postman and set url like `http://localhost:8000/api/`, for information that port to run this project depend on configuratin on `.env`

## Afterword
Hopefully, it can be easily understood and useful. Thank you~

