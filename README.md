# Laravel Test BE REST API ORDER

### For file `be_part1.php` is question form pdf be_part_1.pdf. For running please enter command:

```
$ php be_part1.php
```

- [Configuration](#configuration)
- [Collection](#collection)
  - [Import](#import)
  - [Environment](#environment)
- [Running](#running)
  - [Api](#api)
- [Test](#test)

## Configuration

Select folder `be_rest_api_order`

```
$ cd be_rest_api_order
```

- Setup .env file
  - DB_DATABASE
  - DB_USERNAME
  - DB_PASSWORD
  - QUEUE_CONNECTION = `database`

- Run command artisan migrate and seeder.

```
$ php artisan migrate --seed
```
- Run command artisan storage

```
$ php artisan storage:link
```

- Run command artisan queue

```
$ php artisan queue:work
```

## Collection
Open the folder `Collection` in this project, And will see two files:
- `thunder-collection_REST_API_ORDER_postman.json` for list API.
- `thunder-environment_order_api_postman.json` for env of API.

### Import

Open the `Postman`.
- Click menu collection then click `import` -> select `files` -> select `thunder-collection_REST_API_ORDER_postman.json`.
- Click menu environment then click `import` -> select `files` -> select `thunder-environment_order_api_postman.json`.
- For the collection select environment `order_api`.

### Environment

In the `order_pi` environment, there are two variables: 
- `base_url`, for set url of project, example after running artisan serve the url that be `http://127.0.0.1:8000/api` because run for api.

## Running

Running command artisan serve

```
$ php artisan serve
```

### Api

Open the `Postman`, setup `base_url` env [Environment](#environment). Inside collection will see 3 folders:

- Product
  - Lists: lists all product per page 10.
  - Detail: see detail of product by :id.
  - Create: create product.
  - Update: update product by :id.
  - Delete: delete product by :id.

- Order
  - Lists: lists all order per page 10.
  - Add Cart: add product to cart.
  - Checkout: checkout profuct from cart.
  - Summary: count product and checkout.

- Export
  - export: export order return link download.

## Test

In this project also set unit test and for running test please running command:

```
$ php artisan test
```

