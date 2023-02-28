docker-compose up -d
docker-compose run composer install
docker-compose exec -it php-fpm php bin/console doctrine:database:create
docker-compose exec -it php-fpm php bin/console doctrine:migrations:migrate
docker-compose exec -it php-fpm php bin/console lexik:jwt:generate-keypair
docker-compose exec -it php-fpm php bin/console app:fill-location

