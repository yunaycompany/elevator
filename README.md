# Ejercicio práctico para gestionar el uso de ascensores.

cd projects/
git clone ...


 cd elevator/
 Crear .env usando el .env.dist 
 composer install
 php bin/console doctrine:database:create
 php bin/console doctrine:migrations:migrate
 
 yarn install
 yarn encore production
 
 symfony server:start
 
 Nota:
 Teniendo en cuenta que se utiliza la Extensión de control de procesos "Ev" (https://www.php.net/manual/es/book.ev.php)
 es necesario tenerla instalada y habilitada en el archivo php.ini. 
 
 Ver el siguiente link: (https://www.php.net/manual/es/ev.installation.php)
