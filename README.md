# Symfony UX Turbo Demo Application

Chat application demo on how Symfony UX Turbo can be used to make server-rendered applications more dynamic without
resorting to custom JavaScript code.

Made by mixing these 3 together:

- https://github.com/ocrampete16/symfony-ux-turbo-demo
- https://github.com/dunglas/symfony-docker
- https://github.com/druidfi/stonehenge

## Requirements

- Docker
- [Stonehenge](https://github.com/druidfi/stonehenge)
- PHP 8.0
- Node + Yarn

## Setup

1. Install dependencies: `composer install` & `yarn`
2. Build & start Docker containers: `docker-compose up --build -d`
3. Create the database with the matching schema: `docker-compose exec php bin/console doctrine:schema:update --force`
4. Open up `https://turbo.docker.so/rooms` in 2 different browsers to get chat started!

## Notes

Turbo Frames are given red borders while Turbo Streams are given blue borders to better identify them.
