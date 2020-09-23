<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## ONGOING

## About a project

Simple forum thread app, complete with MySQL database, PHP API and HTML form to add and edit entities.

Data structure
1. Thread entity with at least title, text and creation date fields.
2. User entity with at least name field.
3. Threads can have multiple replies.
4. A reply can be liked by users.

API Endpoints
1. Get a thread by some id.
2. Get all threads for given user.
3. Sort threads by most popular (most replies).
4. Get all threads for a given channel.

## How to navigate a project

To visit forum page, manually add '/threads' route or click 'Forum' hyperlink (visible on default '/' page or on '/dashboard' page upon login in to a site).

A guest can freely view and explore threads but to edit/create/delete threads you have to be logged in (registration required).

To login/register, look up to top right corner of a website (visible only to guests) or manually visit '/login' or '/register'. While logged in, profile dropdown menu appears. 

To update a specific thread you have to be authorized (ex. you cannot delete others' people threads).

From a main route '/threads' you can visit specific routes:
- explore all threads,
- visit a specific thread,
- visit users' threads,
- submit edits to a thread or create a new thread or delete a thread,
- see a list of most popular threads (by most replies metric),
- see and add a reply to a given thread.

## How to setup a Laravel project from github repository

1. Download .zip file from a given github repository.
2. Unpack .zip file and move terminal working location to the project folder.
3. Run commands:
- composer install
- npm install && npm run dev
4. Copy .env.example file and rename it to .env file (projects' main folder).
5. Generate an app encryption key:
- php artisan key:generate
- (it should update an APP_KEY value in you .env file) 
6. Create an empty database for a project (recommended coalition: utfmb4_unicode_ci).
7. Add database information in .env file:
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
8. Migrate the database:
- php artisan migrate
- (it will create all necessary tables to run an application)
9. Seed the database:
- php artisan db:seed
- (located in /database/seeders, it will populate the database with test data)
10. [Optional] How to start Laravel development server:
- php artisan serve
- (check created URL with APP_URL value in .env file)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
