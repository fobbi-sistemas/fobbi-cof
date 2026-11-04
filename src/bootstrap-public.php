<?php
/**
 * Bootstrap para páginas públicas (login, logout).
 *
 * Carrega autoload e inicia sessão, mas NÃO exige autenticação.
 * Define APP_BOOTSTRAPPED para permitir includes de componentes.
 */

require_once __DIR__ . '/bootstrap-paths.php';
require_once APP_ROOT . '/autoload.php';

use Src\Util\Csrf;
use Src\Util\SessionConfig;

ob_start();
SessionConfig::start();

// O login também valida o token (o form o emite via csrf_field()).
Csrf::verifyOrFail(false);

if (!defined('APP_BOOTSTRAPPED')) {
    define('APP_BOOTSTRAPPED', true);
}
