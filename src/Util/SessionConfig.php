<?php

namespace Src\Util;

/**
 * Sessão PHP com cookie endurecido.
 *
 * Único lugar do projeto que chama session_start(): se outro ponto iniciar a
 * sessão antes, o cookie sai com os flags default e o endurecimento não vale.
 * Os bootstraps (page, api, public) chamam SessionConfig::start() e nada mais.
 */
class SessionConfig
{
    const NOME = 'FobbiCof';

    /** 12h. Mesma regra de inatividade usada pelos bootstraps no servidor. */
    const LIFETIME = 43200;

    public static function start()
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        session_name(self::NOME);

        session_set_cookie_params([
            'lifetime' => self::LIFETIME,
            'path'     => '/',
            'secure'   => self::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        // Recusa id de sessão que o servidor não gerou (session fixation).
        ini_set('session.use_strict_mode', '1');
        ini_set('session.gc_maxlifetime', (string) self::LIFETIME);

        session_start();
    }

    private static function isHttps()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        }

        // Atrás de proxy/balanceador o TLS termina antes do PHP.
        return isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
            && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https';
    }
}
