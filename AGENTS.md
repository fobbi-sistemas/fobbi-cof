# AGENTS.md

Backoffice da Fobbi (PHP puro, sem Composer, sem framework, sem testes automatizados): gestão de oportunidades/leads e campos de dados. MVC com Repository. Interface e documentação em português (pt-br).

## Estrutura

- `public/` é o document root (o `.htaccess` da raiz manda tudo para ele). Telas em `public/pages/<modulo>/<submodulo>/{lista,cadastro}/index.php`.
- `src/{Controller,Model,Repository,Exception,Util}`: namespace `Src\`, autoload em `autoload.php`.
- `src/bootstrap-page.php` (páginas autenticadas e downloads), `bootstrap-api.php` (JSON), `bootstrap-public.php` (login/logout).
- `config.php` na raiz, fora do git (`app_stage`, `db_host`, `db_name`, `db_user`, `db_pass`), lido por `AppConfig::get()`. Modelo em `config.example.php`.
- `sql-dba/`: scripts SQL numerados, aplicados à mão no banco (fora do document root).

## Fluxo de uma tela

A página faz `require_once '../../../header.php'`, que carrega o `bootstrap-page.php` (sessão, login, CSRF), e depois o `menu.php` do módulo. Em seguida vêm Controller e Repository (PDO). O POST volta para a própria página (`if (isset($_POST['save']))`). Endpoints AJAX ficam ao lado da tela (ex.: `campo-dados/dados/cadastro/crudCampoOpcao.php`) e usam `bootstrap-api.php` quando respondem JSON.

## Regras obrigatórias

1. Queries com `prepare` + `bindValue`/`bindParam`.
2. Todo `<form method="post">` leva `<?= csrf_field() ?>` logo após a tag. `fetch`/XHR/`jQuery.ajax` recebem o header sozinhos via `csrf-setup.js`. Detalhes em `docs/seguranca_csrf.md`.
3. Não chame `session_start()` nem `setcookie()` da sessão: use `SessionConfig::start()` (os bootstraps já fazem isso).
4. Escape toda saída HTML com `htmlspecialchars`.
5. Os arquivos usam CRLF: preserve, não converta para LF.
6. Não versione `config.php`, `backup.sql` nem nada sensível dentro de `public/`.
7. Toda página nova inclui `header.php` (ou um `bootstrap-*`); sem isso fica sem login e sem CSRF. Partials (`menu.php`, abas, modais) incluem `includes/partial-guard.php`, que responde 403 se `APP_BOOTSTRAPPED` não estiver definido.
8. GET nunca altera estado: o CSRF só valida métodos diferentes de GET.
9. URLs e redirects são relativos (`../../../../assets/...`, `Location: ../lista`) e o `.htaccess` da raiz depende disso. Não troque por caminhos absolutos. Caminhos de filesystem (upload, unlink) usam `APP_ROOT`, nunca relativos ao cwd.
10. Ao documentar (README, `docs/`), confira o código e descreva só o que o sistema faz hoje.

## Front-end (UI)

- Bootstrap 5.3 + Bootstrap Icons e jQuery 3.7 via CDN no `header.php`. Sem npm nem build.
- Estilo legado em `public/assets/css/style.css` (telas antigas, via `header.php`). JS de tela em `js/` ao lado do `index.php`.
- Telas novas usam `pages/layout/head.php` + `foot.php` e CSS modular em `public/assets/css/`: `tokens.css` (variáveis), `base.css`, `components/*.css` e `pages/<tela>.css`, com prefixo `fb-`. Não carregam o `style.css`. Ícones: Bootstrap Icons.
- Exclusão: `modalConfirmRemove.php` (form POST com `csrf_field()`, botão `name="remove"`).

## Validar

- `php -l <arquivo>` em todo PHP alterado.
- Local: `php -S 127.0.0.1:8099 -t public` (precisa do `config.php`).
- Auditoria de forms sem CSRF: script em `docs/seguranca_csrf.md` (resultado esperado: vazio).

## Commits

`<nº da tarefa> - descrição`. Release: `Release X.Y`, que só altera `ProjectStage::currentVersion()`.
