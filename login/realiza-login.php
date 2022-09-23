<?php
    include_once "class/Usuario.php";

    $service = new Usuario();

    ob_start();
    session_start();

	if ($_POST['entrar']) {       
		if ($service->login($_POST)) {
            header("Location: ../index.php");
        } else {
            header("Location: index.php?user=".$_POST['login']."&valid=false");
        } 
	}

?>