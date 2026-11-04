<?php
/**
 * Bootstrap para endpoints JSON.
 *
 * Diferença para o bootstrap-page: sem login responde 401 JSON em vez de
 * redirecionar, e garante que nenhum warning/fatal do PHP corrompa a resposta.
 */

ini_set('display_errors', '0');
ini_set('html_errors', '0');
header('Content-Type: application/json; charset=utf-8');
ob_start();

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

register_shutdown_function(function () {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'code'    => 'INTERNAL_ERROR',
            'message' => 'Erro interno do servidor.',
        ]);
    }
});

require_once __DIR__ . '/bootstrap-paths.php';
require_once APP_ROOT . '/autoload.php';

use Src\Util\Csrf;
use Src\Util\SessionConfig;

SessionConfig::start();

if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > 43200)) {
    unset($_SESSION['idUsuarioAdminSite']);
}
$_SESSION['ultima_atividade'] = time();

if (!isset($_SESSION['idUsuarioAdminSite'])) {
    if (ob_get_length()) ob_clean();
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'code'    => 'AUTH_REQUIRED',
        'message' => 'Sessao expirada. Faca login novamente.',
    ]);
    exit;
}

// CSRF: precisa rodar antes do session_write_close abaixo, que libera a sessão.
Csrf::verifyOrFail(true);

/*
 * Libera o lock exclusivo do arquivo de sessão assim que os dados necessários já
 * foram lidos. Sem isso o PHP mantém a sessão travada durante toda a requisição,
 * o que serializa no servidor chamadas "paralelas" disparadas pelo mesmo navegador.
 */
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}

if (!defined('APP_BOOTSTRAPPED')) {
    define('APP_BOOTSTRAPPED', true);
}
