#!/bin/bash
# Script de início automático do projeto Laravel + NPM

# ===== Funções auxiliares =====
log_info() {
  echo -e "\n🔵 [INFO] $1\n"
}

log_success() {
  echo -e "\n✅ [SUCESSO] $1\n"
}

log_error() {
  echo -e "\n❌ [ERRO] $1\n"
  exit 1
}

# ===== Passos do processo =====
derrubar_containers() {
  log_info "Derrubando containers existentes..."
  docker compose down || log_error "Falha ao derrubar containers."
  log_success "Containers derrubados."
}

resetar_env() {
  log_info "Resetando arquivo .env..."
  rm -f .env || log_error "Falha ao remover .env antigo."
  cp .env.example .env || log_error "Falha ao copiar .env.example."
  log_success "Arquivo .env preparado."
}

subir_containers() {
  log_info "Subindo containers e buildando imagens..."
  docker compose up -d --build || log_error "Falha ao subir containers."
  log_success "Containers ativos e imagens buildadas."
}

instalar_dependencias() {
  log_info "Instalando dependências PHP (composer)..."
  docker exec denuncias-app composer install || log_error "Falha ao instalar dependências PHP."
  log_success "Dependências PHP instaladas."

  log_info "Instalando dependências JS (npm)..."
  docker exec denuncias-app npm install || log_error "Falha ao instalar dependências JS."
  log_success "Dependências JS instaladas."

  log_info "Buildando frontend (npm run build)..."
  docker exec denuncias-app npm run build || log_error "Falha ao buildar frontend."
  log_success "Frontend buildado."
}

aguardar_banco() {
  log_info "Aguardando banco de dados ficar pronto..."
  until docker exec denuncias-banco mysqladmin ping -h "127.0.0.1" --silent; do
    echo "⏳ Banco ainda não está pronto, aguardando..."
    sleep 2
  done
  log_success "Banco de dados disponível."
}

migrar_banco() {
  log_info "Rodando migrations..."
  docker exec denuncias-app php artisan migrate || log_error "Falha ao rodar migrations."
  log_success "Migrations aplicadas."
}

gerar_key() {
  log_info "Gerando chave da aplicação..."
  docker exec denuncias-app php artisan key:generate || log_error "Falha ao gerar chave."
  log_success "Chave da aplicação gerada."
}

# ===== Execução em ordem =====
derrubar_containers
resetar_env
subir_containers
instalar_dependencias
aguardar_banco
migrar_banco
gerar_key
migrar_banco

log_success "🚀 Projeto iniciado com sucesso!"
