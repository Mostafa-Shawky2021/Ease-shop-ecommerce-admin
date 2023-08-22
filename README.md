# Getting Started

-   Clone the repository

```
git clone https://github.com/Mostafa-Shawky2021/Ecommerce-admin project-app && cd project-app
```

-   install application dependencies

```
composer install
```

-   Config Env variables and database credentials

```
mv .env.example .env
```

-   Generate application key

```
php artisan key:generate
```

-   Create Symbolic link for files storage

```
php artisan storage:link
```

Migrate database , make sure you configure database source and credentials

```
php artisan migrate
```

-   Install node package manager

```
npm install
```

-   Create new admin

```
php artisan make:admin
```

-Serve the application

```
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) with your browser to see the result.

### About ease-shop E-commerce admin main features

-   Manage products, sizes, colors, and brands efficiently
-   Administrator can perform CRUD operations on products.
-   Administrator easily add new products options for size,color and brand or modify existing ones.
-   Includes a search functionality that allows administrators to find specific product.
-   Administrator can view users orders, including details such as order date, customer Information .
-   Administrators can view users orders, including details such as order date, customer Information

### Deployment demo

Open [https://ease-shop.onrender.com](https://ease-shop.onrender.com/)

-   Login Credentials
    -   Email: admin@admin.com
    -   Password: admin
