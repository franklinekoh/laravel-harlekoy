## 3rd party service worker
A worker that updates users information on a 3rd party application

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

run `php artisan app:post-updated-users-data` to post the updated data over the network

The `post-update...` command would run once every hour to make the batch API call and update the `update_users` 
subsequently  The `pos-update` cron job can be set to run more frequently (say once every 10mins) 
to reduce data redundancy on the 3rd party service at the cost of using more memory on the server. 

However, what is ideal in this situation depends on what the 3rd party service does and how often user data
is updated on our end. Leading me to ask questions like:

- What is the user data used for on the 3rd party platform?
- What does the post endpoints return? This is for both batch and individual endpoints
- 



Lastly, depending on the feedback from above and other factors like time constraint, etc, I may do the following:

- Write Unit Tests for the feature
- Change the frequency of the `post-update...` Cron Job to reduce data redundancy on 3rd party service
- 



