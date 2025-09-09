# Script de inicio automatico do projeto
# WORK IN PROGRESS
docker compose down

rm .env

cp .env.example .env

docker compose up -d --build

docker exec -it denuncias-app composer install
docker exec -it denuncias-app npm install && npm run build

docker exec -it denuncias-app php artisan key:generate
docker exec -it denuncias-app artisan migrate