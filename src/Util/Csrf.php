<?php

namespace Src\Util;

class Csrf
{
    const SESSION_KEY = '_token';
    const FIELD = '_token';
    const HEADER = 'HTTP_X_CSRF_TOKEN';

    /** Token da sessão; gera no primeiro uso. */
    public static function token()
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            self::regenerate();
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /** Novo token. Chamar junto de session_regenerate_id() no login. */
    public static function regenerate()
    {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
    }

    /** <input hidden> para dentro de <form method="post">. */
    public static function field()
    {
        return '<input type="hidden" name="' . self::FIELD . '" value="' . self::escape(self::token()) . '">';
    }

    /** <meta> para o <head>; o csrf-setup.js lê dele o token dos requests AJAX. */
    public static function meta()
    {
        return '<meta name="csrf-token" content="' . self::escape(self::token()) . '">';
    }

    /** true quando o token enviado (campo ou header) bate com o da sessão. */
    public static function verify()
    {
        $esperado = isset($_SESSION[self::SESSION_KEY]) ? $_SESSION[self::SESSION_KEY] : '';
        $enviado = self::tokenEnviado();

        if (!is_string($esperado) || $esperado === '' || $enviado === '') {
            return false;
        }

        return hash_equals($esperado, $enviado);
    }

    /**
     * Barra a requisição com 419 se ela altera estado e não traz token válido.
     * GET/HEAD/OPTIONS passam direto.
     *
     * @param bool $json true nos endpoints JSON (bootstrap-api); false nas demais.
     */
    public static function verifyOrFail($json)
    {
        if (self::isLeitura() || self::verify()) {
            return;
        }

        error_log('[CSRF] token ausente ou invalido: ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);

        if (ob_get_length()) {
            ob_clean();
        }
        http_response_code(419);

        $mensagem = 'Página expirada. Recarregue a página e tente novamente.';

        if ($json) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'code'    => 'CSRF_INVALID',
                'message' => $mensagem,
            ]);
            exit;
        }

        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html lang="pt-br"><head><meta charset="utf-8"><title>Página expirada</title></head>'
            . '<body style="font-family:sans-serif;text-align:center;margin-top:15vh">'
            . '<h2>Página expirada</h2><p>' . self::escape($mensagem) . '</p>'
            . '<p><a href="javascript:history.back()">Voltar</a></p></body></html>';
        exit;
    }

    private static function isLeitura()
    {
        return in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD', 'OPTIONS'], true);
    }

    private static function tokenEnviado()
    {
        if (isset($_POST[self::FIELD]) && is_string($_POST[self::FIELD])) {
            return $_POST[self::FIELD];
        }
        if (isset($_SERVER[self::HEADER]) && is_string($_SERVER[self::HEADER])) {
            return $_SERVER[self::HEADER];
        }

        return '';
    }

    private static function escape($valor)
    {
        return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    }
}
