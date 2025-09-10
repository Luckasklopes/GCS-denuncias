# 📌 GCS-Denúncias

Sistema de **Gerência de Configuração de Software** para registro e acompanhamento de denúncias.
Desenvolvido em **Laravel**, utilizando **MySQL/PostgreSQL** como banco de dados, com suporte a **conteinerização (Docker)** para facilitar gerenciamento, manutenção e escalabilidade.

---

## 🚀 Pré-requisitos

Antes de começar, verifique se possui instalado na sua máquina ou servidor:

* [Git](https://git-scm.com/)
* [Docker](https://docs.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

---

## ⚙️ Instalação

1. Clone o repositório na branch `main`:

   ```bash
   git clone https://github.com/Luckasklopes/GCS-denuncias.git
   ```

2. Dê permissão de execução ao script de inicialização e rode-o:

   ```bash
   sudo chmod +x iniciar.sh
   ./iniciar.sh
   ```

---

### 🛠️ Instalação Manual (sem Docker)

Caso prefira rodar o projeto manualmente, certifique-se de ter:

* [Laravel Herd](https://herd.laravel.com/) (recomendado para Windows/macOS)
* [Composer](https://getcomposer.org/)
* [Node.js 18+](https://nodejs.org/) + [NPM](https://www.npmjs.com/) ou [Yarn](https://yarnpkg.com/)
* [MySQL](https://dev.mysql.com/downloads/) ou [PostgreSQL](https://www.postgresql.org/download/)
* [Git](https://git-scm.com/)

Em seguida, siga os passos:

1. Instalar dependências do PHP:

   ```bash
   composer install
   ```

2. Instalar dependências do Node:

   ```bash
   npm install
   # ou
   yarn install
   ```

3. Configurar variáveis de ambiente:

   ```bash
   cp .env.example .env
   ```

4. Gerar a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

5. Rodar migrations e seeders:

   ```bash
   php artisan migrate --seed
   ```

---

## ▶️ Executando o Frontend

Com o backend no ar (via **Herd** ou `php artisan serve`), rode o frontend:

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

## 📋 Requisitos Funcionais

### 🔐 Cadastro e Autenticação

* **RF01 (Alta):** Cadastro de usuário com CPF, nome, número, senha e aceite de termos.
* **RF02 (Alta):** Login de usuário por CPF e senha.
* **RF03 (Alta):** Cadastro de administrador com matrícula, nome e senha.
* **RF04 (Alta):** Login de administrador por matrícula e senha.
* **RF05 (Média):** Redefinição de senha via mensagem para o número cadastrado.
* **RF06 (Média):** Administradores devem contatar suporte em caso de esquecimento de senha.

### 📢 Denúncias

* **RF07 (Alta):** Registro de denúncia com foto, descrição, classificação, bairro, rua, CEP e opção de anonimato.
* **RF08 (Alta):** CEP é opcional, mas se informado sobrescreve rua e bairro.
* **RF09 (Média):** Denúncias anônimas não permitem contato com o denunciante.
* **RF10 (Média):** Denúncias não anônimas permitem contato com o usuário.

### 👤 Perfil do Usuário

* **RF11 (Alta):** Visualizar nome e CPF no perfil.
* **RF12 (Média):** Alterar número de contato.
* **RF13 (Média):** Alterar senha.

### 📊 Acompanhamento de Denúncias

* **RF14 (Alta):** Usuário pode visualizar lista de denúncias próprias (ID e status).
* **RF15 (Média):** Status pode ser: `Enviado`, `Aceito` ou `Rejeitado`.

---

## 📌 Requisitos Não Funcionais

* **RNF01 (Alta):** Desenvolvido em PHP, com banco MySQL.
* **RNF02 (Alta):** Frontend com Bootstrap e JavaScript.
* **RNF03 (Alta):** Responsivo e acessível em dispositivos móveis.
* **RNF04 (Alta):** Dados sensíveis armazenados com segurança (hash/criptografia).
* **RNF05 (Média):** Tempo de resposta < 2 segundos em operações comuns.
* **RNF06 (Média):** Suporte a pelo menos 100 usuários simultâneos.
* **RNF07 (Baixa):** Interface deve seguir boas práticas de usabilidade e UX.
* **RNF08 (Baixa):** Deve possuir logs de acesso e auditoria para administradores.

---

## 📝 Resumo de Funcionamento

* Usuários se cadastram (CPF, nome, número, senha, termos).
* Administradores se cadastram (matrícula, nome, senha).
* Denúncias podem ser **anônimas ou não**.
* **CEP é opcional**, mas se informado sobrescreve rua e bairro.
* Se denúncia for **anônima**, não há vínculo com usuário.
* Se denúncia não for anônima, usuário pode ser contatado.
* **Admins podem adotar denúncias anônimas**, assumindo responsabilidade.
* Classificação de denúncias:

  * ambientais 🌱
  * civil-criminais ⚖️
  * perturbação da paz 🔊
* Usuários veem apenas **ID e status** das denúncias.
* Admins podem **alterar status** das denúncias.

---

## 🗄️ Modelo de Banco de Dados (DER)

### **Tabela: Usuario**

* `id_usuario` (PK)
* `cpf` (UNIQUE, NOT NULL)
* `nome` (NOT NULL)
* `numero` (telefone, NOT NULL)
* `senha` (hash, NOT NULL)
* `termos_aceitos` (boolean, NOT NULL)

### **Tabela: Admin**

* `id_admin` (PK)
* `matricula` (UNIQUE, NOT NULL)
* `nome` (NOT NULL)
* `senha` (hash, NOT NULL)

### **Tabela: Denuncia**

* `id_denuncia` (PK)
* `id_usuario` (FK → Usuario.id\_usuario, NULL se anônima)
* `id_admin` (FK → Admin.id\_admin, NULL se não adotada)
* `foto` (caminho/URL)
* `descricao` (NOT NULL)
* `classificacao` (ENUM: 'ambiental', 'civil\_criminal', 'perturbacao\_paz')
* `bairro` (NULLABLE)
* `rua` (NULLABLE)
* `cep` (NULLABLE)
* `anonimo` (boolean, DEFAULT false)
* `status` (ENUM: 'enviado', 'aceito', 'rejeitado', DEFAULT 'enviado')
* `data_criacao` (timestamp, DEFAULT now())

---

## 🔗 Relações

* **Usuário → Denúncia:** um usuário pode registrar várias denúncias (não anônimas).
* **Admin → Denúncia:** um admin pode adotar várias denúncias anônimas.
* Denúncias podem existir sem admin (se não adotadas).

---

## 📄 Licença

Este projeto é distribuído sob a licença **MIT**.