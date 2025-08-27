# Script de inicio automatico do projeto
# Só deve ser executado quando o arquivo .env estiver criado e configurado corretamente

# WORK IN PROGRESS

docker-compose up -d --build

docker exec -it laravel_php composer install
docker exec -it laravel_php npm install && npm run build

cp .env.example .env

docker exec -it laravel_php php artisan key:generate

docker exec -it laravel_php php artisan migrate