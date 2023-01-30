# Prueba Técnica
Repositorio para la prueba tecnica EchoTech

Lenguajes ocupados: PHP(Laravel) y JS

##  Librerias usadas
- Laravel Auth -> Autenticación
- Spatie -> Manejo de roles
- Bootstrap, Nice Admin -> plantilla para las vistas
- DevExpressJS -> componentes JS para el mantenimiento de los usuarios, gratis para usos no comerciales

##  Cómo correr
- Crear BD MySql llamada 'echodb'
- Ejecutar comando 'composer install' dentro de la carpeta raiz del proyecto
- Ejecutar comando 'php artisan migrate:fresh --seed' para crear las tablas y rellenarlas con datos
- Montar servidor usando 'php artisan serve'
- Al iniciar sesion, la contraseña para todos los usuarios es 'password'
