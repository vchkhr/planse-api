# [Planse API(http://planse.vchkhr.com/)
API for online calendar application.

## Features
[List of features](https://github.com/users/vchkhr/projects/2).


## Installation
Install needed dependencies:
1. `brew install php mysql composer`.
2. `composer global require laravel/installer`.

Go to project's folder and run:
1. `composer install`.
2. Set up your environment in `.env` file from the `.env.example`.
3. `php artisan migrate` (you should have an empty `planse` database).
4. To run the server enter: `php artisan serve`.
5. Open `http://127.0.0.1:8000` in your browser.
