

## Postman collection

API documentation can be found on [https://documenter.getpostman.com/view/30711/SVYovLeb](https://documenter.getpostman.com/view/30711/SVYovLeb) 

## API Preview link

The preview for this api is hosted on heroku on [https://t-shirtshop-api.herokuapp.com/](https://t-shirtshop-api.herokuapp.com/)

## Module structure

It follows a standard folder conventions by [Laravel 5.8](https://laravel.com/docs/5.8) and see example below: 

```
.
├── composer.json
└── src
    ├── CustomerServiceProvider.php
    ├── Http
    │   ├── Controllers
    │   │   └── CustomerController.php
    │   ├── Requests
    │   │   ├── GetCustomerRequest.php
    │   │   ├── PostCustomerFacebookRequest.php
    │   │   ├── PostCustomerLoginRequest.php
    │   │   ├── PostCustomerRegisterRequest.php
    │   │   ├── PostProductReviewRequest.php
    │   │   ├── PutCustomerAddressRequest.php
    │   │   ├── PutCustomerCreditCardRequest.php
    │   │   └── PutCustomerRequest.php
    │   └── Resources
    │       └── CustomerResource.php
    ├── Model
    │   └── Customer.php
    ├── Repository
    │   └── CustomerRepository.php
    └── routes
        └── api.php

```

# Environment requirements

- PHP 7
- MySQL
- Composer

## PHP Requirements

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Environment Configuration

At the root of this project there's a sample env config `.env.example` should be renamed `.env` and 
then update variable to match you environment settings

## To get dependency 

Simply run `composer install` on the root of the project to retrieve all required dependencies

## To run the app

Run `php artisan serve` and your dev server should be running on `http://127.0.0.1:8000` this is the url you will on your
client side to consume this api i.e base url to set  `http://127.0.0.1:8000/api`

