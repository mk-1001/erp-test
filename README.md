# erp-test

This project is an example ERP System, built with the ```Laravel Framework``` (and Bootstrap 3 framework front-end CSS).
Requires PHP version 7.0 or higher, and all standard PHP extensions required by the ```Laravel Framework```.

# Functionality

- Submit Orders using a public API ```(POST to /api/orders)```. Automatically creates any ```Item```s/```Product```s in 
the order that do not exist, and informs the administrator when a new ```Product``` has been automatically created
(see below for more information on how to use the ```Order```s API).
- View a list of ```Order```s in the ERP system.
- View a list of ```Product```s in the ERP system. A ```Product``` contains an sku, and optional colour.
- View a list of ```Item```s in the ERP system, and edit them (and their statuses) as appropriate. An ```Item``` is 
an actual instance of a product, and can have an Order assigned.
- Once a ```Item``` is assigned to an ```Order```, it can be marked as ```delivered```. When all ```Item```s in an 
```Order``` have been delivered, then the Order will be marked as ```delivered``` by a background job.
- Feature tests to show correct usage of the public ```Order```s API.


# Installation

- Clone the repository (```git clone```).
- Install Composer dependencies ```composer install```.
- Generate the app key (```php artisan key:generate```).
- Copy the file ```.env.example``` to ```.env```. Update the database details to your desired database connection. It is
suggested that you set ```MAIL_FROM_ADDRESS``` and ```MAIL_FROM_NAME``` (the administrator email address).
```QUEUE_DRIVER``` may be set to ```database``` for this application.

# Running the application

- Enter the command: ```php artisan serve``` to run the application.
- Run the command: ```php artisan queue:work``` to allow the background jobs/queue to run (e.g. to send emails to the
administrator, and check whether ```Order```s have been fully delivered).

# Orders API
Send a POST request to ```/api/orders```, containing items in the following structure:
```json
    {
        order:
        {
            customer: 'Customer Name Here',
            address: 'Address',
            total: 100.0,
            items: [
                { sku: 'SKU111', quantity: 5 },
                { sku: 'SKU112', quantity: 3 },
                { sku: 'SKU111', quantity: 2 }
            ]
        }
    }
```
Note: the ```sku``` field should be unique, however if it is repeated in multiple items (as in the above example), the
quantities will be summed (e.g. SKU111 will have a quantity of 7).

See ```app/tests/Feature/CreateOrderAPITest.php``` for more examples.


# Additional Packages

- [laravelcollective/html](https://github.com/LaravelCollective/html)

## License
[MIT](https://s3-ap-southeast-2.amazonaws.com/ashleymenhennett/LICENSE)