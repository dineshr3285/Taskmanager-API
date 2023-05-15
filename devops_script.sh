#Composer
composer install -n
composer dump-autoload

#Laravel commands
php artisan config:clear
php artisan view:clear
php artisan optimize:clear

#DB Migration
#php artisan migrate --force
#php artisan migrate --seed
#php artisan db:seed --force
#php artisan db:seed --class=PermissionSeeder
