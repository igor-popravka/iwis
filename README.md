# iwis
## Install
1. Run docker containers
```shell
docker compose up -d
```
2. Install vendors
```shell
composer install
```
3. Create DB schema
```shell
php bin/console doctrine:database:create
```
4. Update DB schema
```shell
php bin/console doctrine:schema:update
```

## Run
1. Run messenger consume
```shell
php bin/console messenger:consume async_product_import
```
2. Open http://localhost:15672 
> **User:** admin
>
> **Password:** admin

2.1 Go to **Exchanges** -> **product_import_exchange** and send message
```json
{
  "name": "Cabernet Sauvignon",
  "price": 150.50,
  "category": "Red Wine"
}
```
3. Run console command
```shell
php bin/console app:process-products
```
## Logs

Path `/app/var/log/dev.log`