# tarea042_DWCS Hito 1
Tarea 04.2 Hito 1

1.  ## Crear Proyecto Symfony
composer create-project symfony/skeleton nombre_proyecto

2. ## Prepara la cadena de conexión que acceda a una base de datos en el fichero .env. y crea la DB
En el fichero .env buscamos DATABASE_URL y ponemos
DATABASE_URL="mysql://root@127.0.0.1:3306/db_anovamari?serverVersion=10.4.28-MariaDB&charset=utf8mb4"

3. ## Crear la Base de Datos
php bin/console doctrine:database:create

4. ## Crea un controlador HelloController y anota el comando que has utilizado en el fichero
php bin/console make:controller Hello

5. ## Redirección después de iniciar sesión, fuente: ChatGPT
Después de iniciar sesión con éxito, Symfony redirige por defecto a la página de inicio de sesión (`app_login`).  
Para cambiar esta redirección a la ruta que se crea por defecto en `HelloController`, edité el archivo `config/packages/security.yaml` y agregué:

```yaml
firewalls:
    main:
        form_login:
            login_path: app_login
            check_path: app_login
            default_target_path: /hello

--

# tarea042_DWCS Hito 2
Tarea 04.2 Hito 2

