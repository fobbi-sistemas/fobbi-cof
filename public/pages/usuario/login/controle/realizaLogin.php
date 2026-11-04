<?php

    use Src\Controller\Usuario\Login\UsuarioController;

    require_once __DIR__ . '/../../../../../src/bootstrap-public.php';

    $service = new UsuarioController();

	if ($_POST['entrar']) {
		if ($service->login($_POST)) {
            header("Location: ../../../../index.php");
        } else {
            header("Location: ../acessar/index.php?user=" . rawurlencode((string) $_POST['login']) . "&valid=false");
        }
	}

?>