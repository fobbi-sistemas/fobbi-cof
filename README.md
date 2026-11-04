## Fobbi COF - Backoffice de Gestão

---

### Sobre o Projeto

Este é um projeto de acesso do escritório(backoffice) para realizar gestão de oportunidades/leads e campos de dados.

---

### Tecnologias Utilizadas

O **Fobbi COF** foi construído com as seguintes tecnologias e frameworks:

* **Linguagem:** PHP (Versão 8.2.10)
* **Banco de Dados:** MariaDB (Versão 10.11.11)
* **Estrutura/Modelo/Frameworks:** Bootstrap, jQuery
* **Servidor Web:** Apache

---

### Estrutura e Documentação

* **Document root:** `public/` (o `.htaccess` da raiz direciona todas as requisições para ele; `src/`, `sql-dba/`, `docs/` e arquivos da raiz não são acessíveis por HTTP).
* **Configuração:** `config.php` na raiz (fora do versionamento, modelo em `config.example.php`) com `app_stage`, `db_host`, `db_name`, `db_user` e `db_pass`.
* **Documentação:** [`docs/seguranca_csrf.md`](docs/seguranca_csrf.md) (CSRF e sessão) e [`AGENTS.md`](AGENTS.md) (guia para agentes de IA).

---

### Servidor e Repositório do Projeto

#### Detalhes do Servidor

* **Endereço:** `srv801062.hstgr.cloud` (IP: `168.231.91.97`)
* **Tipo de Servidor:** VPS
* **Provedor:** Hostinger
* **Servidor de Aplicação:** Apache
* **Localização dos Dados:** Tanto o sistema quanto o banco de dados estão implantados no servidor VPS da Hostinger (conta Hostinger: `adm@hsys.dev.br`).

#### Backup do Banco de Dados

* **Frequência:** Diário
* **Horários:** 12:30 e 00:30 (horário de Brasília)
* **Monitoramento:** Realizado com monitoramento contínuo e verificação manual semanal para garantir a integridade e segurança dos dados.

#### Repositório do Projeto

* **Plataforma:** Bitbucket (`bitbucket.org`)
* **E-mail da Conta:** `fobbibr@gmail.com`
* **Nome do Projeto:** `fobbi-cof`

#### Suporte e Manutenção do Servidor

O suporte e a manutenção do servidor são uma parceria entre a **HSYS - Desenvolvimento de Sistemas** e a **IT Tecnologia (Irineu Teza)**. A HSYS mantém um contrato de prestação de serviço com a IT Tecnologia para o suporte e manutenção contínua do ambiente do servidor.

---

### Funcionalidades Principais

O **Fobbi COF** centraliza funcionalidades cruciais para a gestão e operação interna:

#### Gestão de Oportunidades

* **Visualização, Cadastro e Controle:** Gerenciamento completo de oportunidades (leads) recebidas através do formulário de indicação disponível em `https://fobbi.com.br/indicacao`.

---

### Ambiente de Produção e Acesso

* **Link de Acesso:** `https://fobbi.com.br/admin`

---

### Datas e Propriedade

* **Data de Início do Projeto:** 23 de setembro de 2022.
* **Desenvolvedores:** HSYS - Desenvolvimento de Sistemas (`hsys.dev.br`)
* **Propriedade:** Este projeto é de propriedade da **FOBBI SOLUCOES DIGITAIS LTDA**, CNPJ 42.060.009/0001-38.