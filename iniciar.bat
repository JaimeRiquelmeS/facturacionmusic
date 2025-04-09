@echo off
echo Limpiando cachés...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo Iniciando servidor en el puerto 8080...
php artisan serve --port=8080

pause
