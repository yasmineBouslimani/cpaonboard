## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user');
define('APP_DB_PWD', 'your_db_password');
```
4. Import `db_cpaonboard_V3.sql` in your SQL server,
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser. 



## URLs availables

* Login page at [http://localhost:8000/auth/login](http://localhost:8000/auth/login)
* Home page at [http://localhost:8000/admin/index/](http://localhost:8000/admin/index/)
* Employees list at [localhost:8000/employee/index](localhost:8000/employee/index)
* Employee details [localhost:8000/employee/show/:id/read](localhost:8000/employee/show/1/read)
* Employee edit [localhost:8000/employee/edit/:id](localhost:8000/employee/edit/1)
* Employee add [localhost:8000/employee/add](localhost:8000/employee/add)
* Employee deletion [localhost:8000/employee/delete/:id](localhost:8000/employee/delete/2)