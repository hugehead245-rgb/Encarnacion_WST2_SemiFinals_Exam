# Taskly

**Project Code:** WST21-PM-2026-SF  
**Student Name:** Encarnacion, Lanz Jeremy B
**Course & Year:** BSIT-2  
**Database Used:** SQLite by default; MySQL is also supported  

## Overview

A Laravel personal task manager called Taskly, built with the Routes -> Controller -> Model -> Database -> Blade workflow. Each task has a name, description, status, and optional due date.

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status between `Pending` and `Completed`

## Technology

- Laravel 13
- PHP 8.3+
- Blade views with Tailwind CSS
- Eloquent ORM and database migrations

## Run Locally

From the repository root:

```bash
cd laravel
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Open `http://localhost:8000` in a browser. To use MySQL instead, set `DB_CONNECTION=mysql` and the MySQL connection values in `.env` before running the migration.

## Tests

The feature tests use an in-memory SQLite database:

```bash
cd laravel
php artisan test
```