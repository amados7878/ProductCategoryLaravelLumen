# docker-compose-Lumen
## Usage


- docker-compose up -d --build 
- docker-compose run php artisan migrate



APIs

Users
/Auth/register
/Auth/login
/Auth/me
/Auth/logout


Categories
/Api/categories       
/Api/categories/{id}
post:    /categories  --create new category
delete:  /categories/{id}
put:     /categories/{id}


Products
post:    /products  --create new category
delete:  /products/{id}
put:     /products/{id}