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
4. Import `db_cpaonboard_V6.sql` in your SQL server,

__________________
RUN PHP BUILT-IN WEB SERVER
__________________

5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.

6. Go to `localhost:8000` with your favorite browser.

__________________
RUN APACHE SERVER
__________________
5. Replace your `httpd-vhost.conf` in `C:\xampp\apache\conf\extra` by `Annexes/Config/httpd-vhosts.conf`

6. For Windows OS only :
   Add host in windows host file => `127.0.0.1 cpaonboard.local`
   
7. Go to `http://cpaonboard.local/` with your favorite browser.




## Examples of URLs availables

* Login page at [http://localhost:8000/auth/login](http://localhost:8000/auth/login)
* Home page at [http://localhost:8000/admin/index/](http://localhost:8000/admin/index/)
* Employees list at [localhost:8000/employee/index](localhost:8000/employee/index)
