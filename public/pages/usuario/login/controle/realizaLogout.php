<?php

    require_once __DIR__ . '/../../../../../src/bootstrap-public.php';

    // 1. Limpa os dados da sessão
    unset($_SESSION['idUsuarioAdminSite']);
    unset($_SESSION['ultima_atividade']);

    // 2. Destrói a sessão completamente
    session_destroy();

    // 3. Redireciona para a tela de login
    header("Location: ../acessar/");
    exit();
?>
