# userManagement

Backend [Laravel PHP Framework](https://laravel.com/)

- Enter in backend folder
- You need to install composer (Dependency manager for php) : https://getcomposer.org/doc/00-intro.md
- Write composer install in terminal
- Go to ```/userManagement/backend/database/database.sql```, here you will find database dump. 
- Run that sql to create new DB
- in ```/userManagement/backend/config/database.php``` - write all config for database connection [username, password, db name, host...]
- In ```/userManagement/backend/config/api.php``` find this prefix line [78. row] and copy this ```'prefix' => env('API_PREFIX', 'api'),```
- After that go to terminal and navigate to userManagement/backend - when you get here just type 
```php artisan serve``` - that command will start Laravel development server on host :8000

Frontend [Angular](https://angular.io/)

- Go to frontend folder and then in user-mng
- In terminal type ```npm install``` to install all dependencies
- After that, type ```ng serve```, this will start Angular live development server on host :4200

