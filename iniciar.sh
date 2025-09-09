# Script de inicio automatico do projeto
# WORK IN PROGRESS
docker compose down

rm .env

cp .env.example .env

docker-compose up -d --build

docker exec -it gcs-denuncias-app composer install
docker exec -it gcs-denuncias-app npm install && npm run build

docker exec -it gcs-denuncias-app php artisan key:generate
docker exec -it gcs-denuncias-app artisan migrate