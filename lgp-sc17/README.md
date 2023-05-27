# Viver com DM1

## 1. Installation

This project was developed using the [Laravel Framework](./README-Laravel.md) for the
back-end and the [Vue Framework](https://vuejs.org/) for the front-end. To store information
a [MySQL](https://www.mysql.com/) database was chosen.

Main languages:
- [Laravel Framework](./README-Laravel.md) - PHP
- [Vue Framework](https://vuejs.org/) - JavaScript


### 1.1 Requirements

- [x] [PHP](https://www.php.net/) (v8.0.0 or above) 
- [x] [PHP](https://www.php.net/) additional extensions:
  - pdo_mysql extension
  - mbstring extension
  - exif extension
  - fileinfo extension
  - gd extension

- [x] [Node and npm](https://nodejs.org/en)
- [x] [Composer](https://getcomposer.org/) - Dependency Manager for PHP

### 1.2 Deploy project locally

```shell
# Get git repository
git clone git@github.com:LGP-FEUP-2023/SC17.git
```

```shell
# Enter into the application folder
cd SC17/lgp-sc17/
```

```shell
# Install dependencies
composer install
npm install
```

```shell
# Configure environment variables and generate a laravel key
cp .env.example .env
php artisan key:generate
```

```shell
# Create a symbolic link from public/storage to storage/app/public
php artisan storage:link
```

```shell
# Build the project
npm run build
```

```shell
# Create docker container with database
docker compose up -d
```

```shell
# Run database migrations 
php artisan migrate
```

```shell
# Initialize the server locally
php artisan serve # initialize the server locally
```

## 2. Post Installation Information

After completing all the aforementioned steps, some users were created in order
to easily use the application for the first time.

#### 2.1 User Credentials

| Type    | Email                  | Password         |
|---------|------------------------|------------------|
| Admin   | admin@vivercomdm1.pt   | admin!password   |
| Guest   | guest@vivercomdm1.pt   | guest!password   |
| Patient | patient@vivercomdm1.pt | patient!password |
| Doctor  | doctor@vivercomdm1.pt  | doctor!password  |
