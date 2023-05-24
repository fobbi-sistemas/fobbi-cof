<?php

    use Src\Controller\Usuario\Login\UsuarioController;

    require_once '../../../../autoload.php';

    $service = new UsuarioController();

    ob_start();
    session_start();

	if ($_POST['entrar']) {
		if ($service->login($_POST)) {
            header("Location: ../../../../index.php");
        } else {
            header("Location: ../acessar/index.php?user=".$_POST['login']."&valid=false");
        }
	}

?>