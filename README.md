## Requirements
    php: "^8.0.2" 
## Clone project
```bash
git clone https://gitlab.com/bludelego/dashcore.git
```
## Create Env file (Rename file .env.example -> .env )
## Change Data .env for project
```
APP_URL={Your url} | Example: https://domain.com
DB_HOST={Host} Default: 127.0.0.1
DB_CONNECTION={DataBase connection} Default: mysql
DB_PORT={Port} Default: 3306
DB_DATABASE={DataBase}
DDB_USERNAME={username}
DB_PASSWORD={password}
```
## Install laravel 
```bash
cd dashcore
composer i
```

## Instal npm
```bash
npm i
npm run dev
```
## Generate App key 
```bash
php artisan key:generate
```
## Migrate Database
```bash
php artisan migrate:fresh --seed
```
## Optimize 
```bash
php artisan optimize
```
Usename: radu
Password : 1111

<!-- ```html
<ul>
    <li>Service Providers (Need to fix problem, when Service providers hinder for migrations); - By danublueline</li>
    <li>Need to do something for migrations to make sure that all folders inside are used;</li>
    <li>I don't see any resource route, all routes are separate with individual method and name; - By danublueline</li>
    <li>Route /register move us to page with error "Taget class", i think, need to delete this route from project; - By danublueline</li>
    <li>In some folders, there is only the creation of a record “create.blade.php”, that is, in creating a record, there are two conditions at once, creating and editing</li>
    <li>We have CoreAdminOptionRequest, and this request is used in CoreAdminOptionControllerstore, but this request file is empty, without any rules; - By danublueline</li>
    <li>In models we have protected variable “table”, but, without this variable model can see tables;</li>
    <li>In Http\Controllers\Api\Core\CustomerController.php in search function we have unreachable return;</li>
    <li>In CoreMenu model exist function “tree”, with array_fill, but I think this is a bad idea to write “array_fill(0, 100, …)”;  - By danublueline</li>
    <li>In views\core\auth\* in forms we have old variant of csrf token input "csrf_field()", we can change to csrf; - By danublueline</li>
    <li>I don’t understend, why we need stack(‘css’) and stack(‘js’). In each blade file where we have js or css, I’ve seen only one push(‘js’). I think we can use only yield(‘css or js’) and section(‘css or js’);</li>
    <li>If we need to add class by condition, we can use class;</li>
    <li>I don’t know why, but in all project we use tag form but in views\core\menus\create.blade.php we use class Form::open(…) … Form::close();  - By danublueline</li>
</ul>
``` -->