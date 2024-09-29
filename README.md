## 3rd party service worker
A worker that users information on a 3rd party application through batch API call intermediately

#### use PHP ^8.2


#### Installation
Clone project

Switch to branch `update-thirdparty-provider`

copy .env.example to .env with `cp .env.example .env`

update database credentials at the connection variable with prefix of `DB_`, e.g `DB_DATABASE`, `DB_USERNAME`

run `composer install`

### running project

run `php artisan serve`

run `php artisan app:update-user-details` to update user details 

