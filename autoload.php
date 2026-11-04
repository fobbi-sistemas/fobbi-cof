<?php

spl_autoload_register(
    function (string $nomeCompletoDaClasse) {
        $prefixo = 'Src\\';
        if (strpos($nomeCompletoDaClasse, $prefixo) !== 0) {
            return;
        }

        $classeRelativa = substr($nomeCompletoDaClasse, strlen($prefixo));
        $classeRelativa = str_replace('\\', DIRECTORY_SEPARATOR, $classeRelativa);
        $caminhoArquivo = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $classeRelativa . '.php';

        if (file_exists($caminhoArquivo)) {
            require_once $caminhoArquivo;
        }
    }
);

// Helpers globais dos templates (csrf_field(), csrf_meta(), csrf_token()).
require_once __DIR__ . '/src/helpers.php';
