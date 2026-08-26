# Ecommerce Project

This project is an ecommerce website built with Laravel. It includes products, categories, brands, a shopping cart, orders, and addresses.

## Progress

This project is still in progress.

## Technologies Used

- PHP 8.2+
- Laravel 12
- Filament 5
- Livewire 4
- Tailwind CSS
- Vite
- MySQL or SQLite

## How to Run

1. Install the dependencies:

```bash
composer install
npm install
```

2. Create the environment file, application key and storage link:

```bash
copy .env.example .env
php artisan key:generate
php artisan storage:link
```

3. Configure the database in `.env`, then run the migrations:

```bash
php artisan migrate
```

4. Start the project:

```bash
php artisan serve
composer run dev
```


The application will be available at `http://127.0.0.1:8000`.
Also you can open the admin through this link.  `http://127.0.0.1:8000\admin`
You can create a user for the backend through this command.

```bash
php artisan make:filament-user
```

And add the needed username, email and password.