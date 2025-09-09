# Script de inicio automatico do projeto
# WORK IN PROGRESS
docker compose down

rm .env

cp .env.example .env

docker-compose up -d --build

docker exec -it laravel_php composer install
docker exec -it laravel_php npm install && npm run build

docker exec -it laravel_php php artisan key:generate
docker exec -it laravel_php php artisan migrate