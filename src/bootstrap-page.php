<?php
/**
 * Bootstrap para páginas HTML autenticadas e para downloads (export).
 *
 * Absorve a lógica que vivia em pages/usuario/login/controle/verificaLogado.php:
 * sessão, expiração por inatividade e verificação de login.
 * Mantido em src/ para que o bootstrap nunca precise alcançar a árvore pública.
 *
 * Chamado por pages/header.php. Não emite HTML — apenas prepara o ambiente PHP.
 */

require_once __DIR__ . '/bootstrap-paths.php';
require_once APP_ROOT . '/autoload.php';

use Src\Util\Csrf;
use Src\Util\SessionConfig;

ob_start();
SessionConfig::start();

/**
 * Expiração por inatividade no servidor (12h).
 */
if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > 43200)) {
    unset($_SESSION['idUsuarioAdminSite']);
}
$_SESSION['ultima_atividade'] = time();

// Sem usuário na sessão: volta para o login.
// Caminho relativo à URL da página (o navegador resolve), não ao filesystem.
if (!isset($_SESSION['idUsuarioAdminSite'])) {
    header("Location: ../../../usuario/login/acessar");
    die();
}

// CSRF: garante o token da sessão (o header.php emite o meta) e barra todo
// método que altera estado sem token válido.
Csrf::token();
Csrf::verifyOrFail(false);

if (!defined('APP_BOOTSTRAPPED')) {
    define('APP_BOOTSTRAPPED', true);
}
