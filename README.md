# Filament spa global search multi tenancy issue

## Issue
When we search for a global search term in the Filament SPA mode and switch the tenant, the search query is not scoped to new tenant and it still shows the results from the previous tenant.
This does not happen in the non SPA mode.

## Steps to reproduce
1. Clone the repo
2. `composer install`
3. `php artisan migrate --seed`
4. Log in to the app on `/` route with the credentials: email - `test@example.com`, password - `password`
5. Type `post` in the global search bar
6. Observe that `This post is on Team 1` is visible
7. Switch the tenant to `Team 2`
8. Type `post` in the global search bar
9. Observe that `This post is on Team 1` is still visible
   
