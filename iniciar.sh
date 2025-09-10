# Script de inicio automatico do projeto
# WORK IN PROGRESS
# AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
docker compose down

rm .env

cp .env.example .env

docker compose up -d --build

docker exec denuncias-app composer install
docker exec denuncias-app npm install
docker exec denuncias-app npm run build

docker exec denuncias-app php artisan key:generate
docker exec denuncias-app php artisan migrate