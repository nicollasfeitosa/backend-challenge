
# About the Project
This project is a Backend Challenge.

## Observations about your environment:

If you are using the old version of docker compose cli you can use the command below with the slash `docker-compose` insted of `docker compose`.

If you are using the `Docker Desktop` version instedof `Docker Engine` 
consider remove the following lines of `docker-compose.yml` file (in php service container lines 37 and 38):

```yml
extra_hosts:
    - host.docker.internal:host-gateway
```

We use this option to avoid the problem of docker not being able to resolve the hostname `host.docker.internal` properly. (Generally used to fix all most the problemns with xDebug)

## Getting Starting

### Step 1
Make sure you add correct permissions to storage folder (for allow laravel write logs)
- Run `sudo chmod -R 777 storage/`

### Step 2
- Fill ``docker/database/.env`` file with all database credentials do you want to create 
- Fill ``.env`` file with your previus configurated database credentials

### Step 4
- Run `docker compose up -d`

### Step 5
Inside of php container run composer install, migrate and seeder commands

- Run `docker compose exec php bash -c "composer install && php artisan migrate:fresh --seed"`

## How to run tests
- Run `docker compose exec php bash -c "composer tests"`

## Application

You can use this credentials to access:
- Email: test@example.com
- Password: 123mudar

## API Documentation

Docs are available at:
https://documenter.getpostman.com/view/12699286/Uz5CLHcX

Also you can download the Postman collection in
https://gist.github.com/nicollasfeitosa/5361895678fcf924c4a2c503913fa2f0

# Future Todo

- [] Create unit tests
- [] Create integration tests
- [] Create cache layer for optimize performance
- [] Create a role and permission system for users

# Questions
Contact me at
Discord: Nicollas#0101