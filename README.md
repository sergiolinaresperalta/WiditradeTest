# WiditradeTest

## Installation

- Clone the repository.
- Run `docker-compose build` to build the docker image.
- Run `docker-compose up -d` to start the containers.
- Run `php bin/console doctrine:database:create` inside the docker console to create the database.
- Run the command `php bin/console doctrine:migrations:migrate` inside the docker console to create the tables.