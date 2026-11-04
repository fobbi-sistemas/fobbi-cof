<?php
/**
 * Funções globais para uso direto nos templates (equivalentes aos helpers do
 * Laravel). Carregado pelo autoload.php, então todo bootstrap já as tem.
 */

use Src\Util\Csrf;

if (!function_exists('csrf_token')) {
    /** Token CSRF da sessão. */
    function csrf_token()
    {
        return Csrf::token();
    }
}

if (!function_exists('csrf_field')) {
    /** <input hidden name="_token">. Uso: <?= csrf_field() ?> logo após <form method="post">. */
    function csrf_field()
    {
        return Csrf::field();
    }
}

if (!function_exists('csrf_meta')) {
    /** <meta name="csrf-token">. Uso: <?= csrf_meta() ?> dentro do <head>. */
    function csrf_meta()
    {
        return Csrf::meta();
    }
}
