## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
4. Import `simple-mvc.sql` in your SQL server, //en attente, BDD pas encore terminée
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.



## URLs availables

* Home page at [localhost:8000/](localhost:8000/)
* Products list at [localhost:8000/product/index](localhost:8000/product/index)
* Product details [localhost:8000/product/show/:id](localhost:8000/product/show/2)
* Product edit [localhost:8000/product/edit/:id](localhost:8000/product/edit/2)
* Product add [localhost:8000/product/add](localhost:8000/product/add)
* Product deletion [localhost:8000/product/delete/:id](localhost:8000/product/delete/2)