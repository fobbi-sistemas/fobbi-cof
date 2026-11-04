# CSRF e sessão — padrão para replicar nos projetos

Mesmo formato do Laravel. Mesmo padrão do `entrada-app-manager`, de onde os arquivos abaixo foram copiados.

## Como funciona

| Conceito | Laravel | Aqui |
|---|---|---|
| Campo no form | `@csrf` (`_token`) | `<?= csrf_field() ?>` |
| Meta tag | `<meta name="csrf-token">` | `<?= csrf_meta() ?>` no `<head>` |
| Header AJAX | `X-CSRF-TOKEN` | idem, injetado por `csrf-setup.js` |
| Validação | middleware `VerifyCsrfToken` | `Csrf::verifyOrFail()` nos bootstraps |
| Falha | 419 Page Expired | 419 (JSON na API, página simples nas demais) |
| Login | `session()->regenerate()` | `session_regenerate_id(true)` + `Csrf::regenerate()` |

- Token único por sessão (`$_SESSION['_token']`, 64 hex).
- Qualquer método diferente de GET/HEAD/OPTIONS precisa do token em `$_POST['_token']` ou no header `X-CSRF-TOKEN`.
- Validação com `hash_equals`. Não há checagem de Origin (o Laravel também não faz); `SameSite=Lax` no cookie é a segunda barreira.

## Arquivos

| Arquivo | Papel |
|---|---|
| `src/Util/Csrf.php` | token, `field()`, `meta()`, `verify()`, `verifyOrFail()`, `regenerate()` |
| `src/Util/SessionConfig.php` | `start()`: único `session_start()` do projeto, cookie `HttpOnly` + `SameSite=Lax` + `Secure` em HTTPS, `use_strict_mode` |
| `src/helpers.php` | `csrf_field()`, `csrf_meta()`, `csrf_token()` (carregado pelo `autoload.php`) |
| `public/assets/js/csrf-setup.js` | injeta `X-CSRF-TOKEN` em `fetch`/XHR/jQuery (same-origin, método não seguro) |

## Adoção em outro projeto (5 passos)

1. Copiar os 4 arquivos acima. Ajustar `SessionConfig::NOME` (nome do cookie) e, se precisar, `LIFETIME`.
2. `autoload.php`: `require_once __DIR__ . '/src/helpers.php';`
3. Bootstraps: trocar o `session_start()`/`setcookie()` manual por `SessionConfig::start()` e chamar `Csrf::verifyOrFail(false)` (páginas/públicas) ou `Csrf::verifyOrFail(true)` (JSON). Na API, validar **antes** do `session_write_close()`. Remover qualquer `setcookie(session_name(), ...)`: ele reescreve o cookie sem flags.
4. Header das páginas: `<?= csrf_meta() ?>` e `<script src=".../csrf-setup.js">` antes dos demais scripts.
5. Todo `<form method="post">` ganha `<?= csrf_field() ?>` logo após a tag. No login, chamar `session_regenerate_id(true); Csrf::regenerate();` ao autenticar.

## Auditoria (rodar depois de mexer em templates)

Lista `<form method="post">` sem `csrf_field()` nas linhas seguintes. O resultado esperado é vazio:

```bash
grep -rniE -A2 "<form[^>]*method=.post" --include="*.php" public | awk '
/<form/ {if (open && !ok) print "FALTA: " last; open=1; ok=0; last=$0; next}
/csrf_field/ {ok=1}
END {if (open && !ok) print "FALTA: " last}'
```

Limitação: o padrão `[^>]*` não enxerga tag `<form>` que contenha `?>` no meio (ex.: `id="<?php echo $x; ?>"`); revisar esses à mão.

## Comportamentos a conhecer

- Form aberto antes de um deploy falha uma vez com 419 até recarregar.
- Upload que estoura `post_max_size` zera `$_POST` e também cai em 419 (mensagem genérica).
- Falhas são registradas no `error_log` (`[CSRF] token ausente ou invalido: METODO URI`), o que ajuda a achar um form esquecido.
- `.submit()` programático funciona: o campo `_token` está no HTML do form.
- Novo form criado por JS (`createElement('form')`) precisa incluir o campo manualmente.
