# COMMANDS TO EXECUTE TO INIT PROJECT
- composer install
- php artisan migrate
- php artisan db:seed

# CRENDENTIAL TO ACCESS
user: demo@demo.com
pass: password

# FILE TO SEE CRAWLER ADS CODE
/app/Http/Services/WebScrapingService.php function getProductsBySlug

# ENDPOINT TO GET ADS
http://51.222.9.47:8000/api/advertisements?api_key=6gHm58vpXYa

. api_key param is required with value example

- other optional params
category -> category id
title -> ad title 
description -> ad description
example:
http://51.222.9.47:8000/api/advertisements?api_key=6gHm58vpXYa&category=1&title=BMW&description=dependiendo

#DATABASE SCHEMA
./DATABASE_SCHEMA.png