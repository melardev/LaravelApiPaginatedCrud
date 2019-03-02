# Introduction
A crud Api built with Laravel. Other implementations I made:
- [Spring Boot + Spring Data]()
- [Go with Gin Gonic]()
- [Go with Mux]()
- [AspNet Core]()
- [AspNet Web Api 2]()
- [Laravel]()
- [Laravel + Fractal]()
- [Laravel + ApiResources]()
- [Rails + JBuilder]()
- [Rails]()
- [NodeJs Express + Sequelize]()
- [NodeJs Express + Bookshelf]()
- [NodeJs Express + Mongoose]()
- [NodeJs Express + Knex]()
- [Python Django]()
- [Python Django + Rest Framework]()
- [Python Flask]()
- [Python Flask + Flask-Restful]()

# Steps used to create this project
```shell
php artisan make:controller TodoController --resource
php artisan make:migration create_todos_table
Change DB_CONNECTION to sqlite
comment DB_DATABASE
touch ./database/database.sqlite
php artisan migrate
php artisan make:seeder TodosTableSeeder
# Write migrations
composer dump-autload
php artisan db:seed
#or
php artisan db:seed --class=TodosTableSeeder
composer dump-autoload
php 
```