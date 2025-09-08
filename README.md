# 📌 GCS-Denúncias

Sistema de Gerência de Configuração de Software para registro e acompanhamento de denúncias.  
Este projeto foi desenvolvido em **Laravel** e utiliza **MySQL/PostgreSQL** como banco de dados.

---

## 🚀 Requisitos

Antes de iniciar, certifique-se de ter instalado em sua máquina:

- [Laravel Herd](https://herd.laravel.com/) (recomendado para Windows/macOS)
- [Composer](https://getcomposer.org/)
- [Node.js 18+](https://nodejs.org/) e [NPM](https://www.npmjs.com/) ou [Yarn](https://yarnpkg.com/)
- [MySQL](https://dev.mysql.com/downloads/) ou [PostgreSQL](https://www.postgresql.org/download/)
- [Git](https://git-scm.com/)

---

## 📥 Instalação

### 🔹 Método Geral (sem Herd)

1. Clone o repositório na branch `develop`:
   ```bash
   git clone -b develop https://github.com/Luckasklopes/GCS-denuncias.git
   cd GCS-denuncias
   ```

   > ⚠️ Atenção: o parâmetro correto é `-b` (um traço só).

2. Instale as dependências do PHP:
   ```bash
   composer install
   ```

3. Instale as dependências do Node:
   ```bash
   npm install
   # ou
   yarn install
   ```

4. Copie o arquivo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```

5. Configure o banco de dados no `.env`:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gcs_denuncias
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

6. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

7. Execute as migrations e seeders:
   ```bash
   php artisan migrate --seed
   ```

---

### 🔹 Método com Laravel Herd (Windows/macOS)

> Se você estiver usando **Laravel Herd**, não precisa rodar `php artisan serve`.  
> O Herd cria automaticamente um servidor local acessível em `http://gcs-denuncias.test`.

1. Clone o projeto para a pasta do Herd (`~/Herd` no macOS ou `C:\Herd` no Windows):
   ```bash
   cd C:\Herd
   git clone -b develop https://github.com/Luckasklopes/GCS-denuncias.git
   cd GCS-denuncias
   ```

2. Instale as dependências do PHP:
   ```bash
   composer install
   ```

3. Instale as dependências do Node:
   ```bash
   npm install
   # ou
   yarn install
   ```

4. Copie o `.env.example`:
   ```bash
   copy .env.example .env   # Windows
   cp .env.example .env     # macOS
   ```

5. Configure o `.env` com os dados do banco (o Herd já fornece MySQL/MariaDB local, se preferir):
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gcs_denuncias
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Gere a chave:
   ```bash
   php artisan key:generate
   ```

7. Rode as migrations e seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Acesse o projeto no navegador:
   ```
   http://gcs-denuncias.test
   ```

---

## ▶️ Executando o Frontend

Com o backend no ar (Herd ou `php artisan serve`), rode o frontend:

```bash
npm run dev
```

---

## 🧪 Testes

Rodar a suíte de testes:

```bash
php artisan test
```

---

## 🛠️ Comandos Úteis

- Criar nova migration:
  ```bash
  php artisan make:migration create_tabela_exemplo
  ```

- Criar novo model:
  ```bash
  php artisan make:model NomeModel
  ```

- Criar novo controller:
  ```bash
  php artisan make:controller NomeController
  ```

---

## 👥 Contribuição

1. Crie uma branch para sua feature:
   ```bash
   git checkout -b minha-feature
   ```

2. Commit suas alterações com uma mensagem clara:
   ```bash
   git commit -m "Minha nova feature"
   ```

3. Envie para o repositório remoto:
   ```bash
   git push origin minha-feature
   ```

4. Abra um **Pull Request** na branch `develop`.

---

## 📄 Licença

Este projeto é distribuído sob a licença **MIT**.  
