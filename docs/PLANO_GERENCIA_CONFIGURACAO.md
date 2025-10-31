# Plano de Gerência de Configuração (PGC)

**Projeto:** Sistema de Denúncias
**Versão do Documento:** 1.0
**Data:** 29 de outubro de 2025

---

## 1. Introdução

### 1.1 Propósito
Este plano define as atividades e métodos para a Gerência de Configuração de Software (GCS) do "Sistema de Denúncias". O objetivo é estabelecer e manter a integridade de todos os artefatos do projeto (código-fonte, documentos, scripts) ao longo do seu ciclo de vida.

### 1.2 Escopo
Este PGC se aplica a todos os artefatos desenvolvidos e utilizados pelo projeto, incluindo:
* Documentação de Requisitos e Modelagem (em arquivos `.md`);
* Código-fonte (PHP, JavaScript, Bootstrap);
* Scripts de Banco de Dados (MySQL).

### 1.3 Definições e Siglas
* **IC (Item de Configuração):** Artefato do projeto que será versionado e controlado.
* **Baseline (Linha de Base):** Versão estável e aprovada de um ou mais ICs, que serve como ponto de partida para novos desenvolvimentos.
* **GC (Gerente de Configuração):** Responsável por aprovar mudanças e gerenciar o repositório.
* **PR (Pull Request):** Solicitação formal para integrar uma mudança no código.

### 1.4 Referências
* IEEE 828 – *Standard for Configuration Management in Systems and Software Engineering*.
* Documentação oficial do GitHub – *Branches e Pull Requests*.

---

## 2. Gerência e Responsabilidades

* **Equipe de Desenvolvimento (Alunos):**
    * Desenvolver novas funcionalidades e corrigir bugs;
    * Seguir o processo de controle de mudanças (criar *branches* e *Pull Requests*);
    * Rotular *commits* de forma clara e padronizada.

* **Gerente de Configuração (GC):**
    * Manter a integridade do repositório principal (`main`);
    * Revisar e aprovar (fazer *merge*) os *Pull Requests*;
    * Definir e criar as *Baselines* (usando *tags* do Git);
    * Registrar as alterações relevantes em um *log de configuração* (`CONFIG_LOG.md`).

---

## 3. Atividades de Gerência de Configuração

### 3.1 Identificação dos Itens de Configuração (ICs)
Os ICs serão identificados pela sua localização e tipo no repositório.

| Prefixo | Tipo de IC | Exemplo de Localização/Nome |
| :--- | :--- | :--- |
| `DOC-` | Documentação Raiz | `README.md`, `CasosUML.pdf` |
| `COD-` | Código-Fonte | `/src/login.php`, `/app/Models/Usuario.php` |
| `DB-` | Banco de Dados | `/database/schema.sql`, `/database/migrations/...` |
| `WEB-` | Arquivos Web/Views | `/public/css/style.css`, `/resources/views/login.blade.php` |

> **Nota:** Todos os arquivos devem seguir convenções padronizadas de nomes (*kebab-case* ou *snake_case*).

### 3.2 Controle de Mudanças
Nenhum código será enviado (*push*) diretamente para a *branch* `main`.
O controle será feito via **GitHub Flow simplificado**:

1.  **Criação da Branch:**
    * Para cada nova funcionalidade ou correção, criar uma nova *branch* a partir da `main`.
    * Padrão de Nome: `feature/RF07-registro-denuncia` ou `fix/login-invalido`.
2.  **Desenvolvimento:**
    * O desenvolvedor trabalha na *branch* local e realiza *commits* claros e descritivos.
3.  **Pull Request (PR):**
    * Quando a funcionalidade estiver pronta, o desenvolvedor abre um PR da sua *branch* para a `main`.
4.  **Revisão e Aprovação:**
    * O GC revisa o PR. Se aprovado, realiza o *merge* e deleta a *branch*.
    * Se rejeitado, solicita correções e o processo recomeça.
    * Em equipes com mais de dois desenvolvedores, recomenda-se *revisão cruzada* (code review entre colegas) antes do *merge*.

### 3.3 Contabilidade do Estado dos ICs
O estado do projeto será rastreado com as ferramentas do Git e GitHub:
* **Histórico de Commits:** `git log` exibirá o histórico completo das mudanças;
* **Tags (Rótulos):** O GC usará *tags* do Git para marcar *Baselines* (ex: `v1.0-final`);
* **Issues do GitHub:** Usadas para rastrear o status de bugs, melhorias e requisitos;
* **Relatórios Semanais (opcional):** O GC pode gerar relatórios automáticos via GitHub Insights.

### 3.4 Auditorias e Revisões
* **Auditoria da Baseline:** Antes de uma entrega (ex: `v1.0-final`), o GC verificará se todos os requisitos planejados estão refletidos nos PRs aprovados.
* **Revisão de PRs:** Cada revisão de PR constitui uma microauditoria contínua.
* **Verificação de Consistência:** Confirmar a coerência entre código, documentação e scripts de banco de dados.

---

## 4. Ferramentas e Infraestrutura

| Categoria | Ferramenta |
| :--- | :--- |
| Controle de Versão | Git (repositório no GitHub) |
| Ambiente de Desenvolvimento | PHP (Laravel Framework), MySQL, VS Code |
| Ferramentas Complementares | Git Bash, GitHub Desktop (opcional), Postman |
| Gerenciamento de Tarefas | Issues e Projects do GitHub |

---

## 5. Definição de Baselines (Linhas de Base)

| Nome da Baseline | Conteúdo | Gatilho |
| :--- | :--- | :--- |
| `v0.1-analise` | `README.md` atualizado com Requisitos (RF/RNF), Casos de Uso e DER. | Aprovação da modelagem. |
| `v0.5-funcional` | Funções de Login (RF01–RF06) e Registro de Denúncia (RF07–RF10) implementadas. | Testes internos de funcionalidade básica. |
| `v1.0-final` | Todos os requisitos implementados (RF01–RF15). | Versão final apresentada para a disciplina. |