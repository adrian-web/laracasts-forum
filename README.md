<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## ONGOING

## About a project

Forum with Laravel 8, Livewire, Alpine.js & Tailwind CSS.

Features list
- filter threads (ex. most replies, unanswered, author, channel)
- create/edit/delete replies to a thread (AJAX)
- like/unlike a reply (AJAX)
- activity feed for a user (ex. created a thread, replied to a thread, liked/unliked a reply)
- thread subscription (creating a reply notifies subscribers) (AJAX)
- notification bell lists only unique links
- visiting a thread creates cache key to show updated threads to user
- spam detection on user inputs
- user cannot create replies or threads too frequently
- delete button with confirm action (Livewire & Alpine.js)
- state-button component (for ex. liking/disliking, subscribing)
- mention '@' users in messages (creates notification) (w/o autocompleting)
- thread visits count
- trending threads sidebar (Redis)
- create thread w/ modal (AJAX)
- responsive design (Tailwind CSS)

To-do list
- subscription to other models (ex. user, channel)
- best reply functionality
- sanitizing user inputs
- forum roles (ex. admin, moderator)
- username autocomplete in messages
- upvote/downvote thread
- thread can be locked
- search bar
- real-time validation on inputs

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
