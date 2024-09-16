
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<!--
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
-->
MoneyTracker: a simple app to track all your expenses and earnings.

## Demo1:

![Demo1](/readmeFiles/moneytracker_gif_1.gif)

## Demo2:

![Demo2](/readmeFiles/moneytracker_gif_2.gif)


## Requirements

- [PHP](https://www.php.net/manual/en/install.php) (8.4 or higher)
- [Composer](https://getcomposer.org/) (for PHP dependency management)
- [MySQL](https://www.mysql.com/) or [PostgreSQL](https://www.postgresql.org/) (or another supported database)
- [Node.js](https://nodejs.org/) and [NPM](https://www.npmjs.com/) (for managing frontend assets, if necessary)


## Setup Steps

1. **Clone the Repository**

```shell
   git clone https://github.com/lucaDomo/moneyTracker.git
```

2. **Navigate to the Project Folder**

```bash
   cd moneyTracker
```

3. **Install PHP Dependencies**
Make sure you have Composer installed.

```bash
   composer install
```

4. **Set Up the Environment**
Create an .env file based on the provided example file.

```bash
cp .env.example .env
```

Edit the .env file with your specific environment configurations, such as the database and API keys.

5. **Run Database Migrations**
Make sure your database is properly configured in the .env file, then run the migrations.

```bash
php artisan migrate
```

6. **Install Frontend Dependencies**

```bash
npm install
```

```bash
npm run dev
```

7. **Start the Development Server**
You have several options for running the application:

#### Option 1: Using the Built-In Laravel Server

```bash
php artisan serve
```

The application will be accessible at http://localhost:8000.

#### Other options:
If you're on macOS you can use <a href="https://laravel.com/docs/11.x/valet">Laravel Valet</a> (i use this solution).

There are also other methods (such as <a href="https://laravel.com/docs/11.x/homestead">Homestead</a>) that you can find in the Laravel documentation in the Packages section.

## Icons:
Icons by <a href="https://icons8.it/">icons8</a>
