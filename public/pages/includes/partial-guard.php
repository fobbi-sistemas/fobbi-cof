<?php
/**
 * Impede inclusão/acesso direto a partials/componentes sem passar pelo bootstrap da aplicação.
 * Defina APP_BOOTSTRAPPED em header.php (após sessão/login) antes dos includes da página.
 */
if (!defined('APP_BOOTSTRAPPED') || APP_BOOTSTRAPPED !== true) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('Forbidden');
}
