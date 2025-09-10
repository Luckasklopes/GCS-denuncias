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

# Espera o MySQL estar pronto
until docker exec denuncias-banco mysqladmin ping -h "127.0.0.1" --silent; do
  echo "⏳ Aguardando o banco ficar pronto..."
  sleep 2
done

# Agora roda as migrations
docker exec denuncias-app php artisan migrate


docker exec denuncias-app php artisan key:generate
docker exec denuncias-app php artisan migrate

echo "FUNCIONOU"