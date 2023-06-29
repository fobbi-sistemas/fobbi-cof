<?php
    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title> Admin Site | Fobbi </title>
    <meta charset="utf-8"/>
    <meta name="author" content="HSYS - Desenvolvimento de Sistemas" />
	<meta name="description" content="Apolinário Construção" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="shortcut icon" href="../../../../assets/images/favicon.ico"/>
    
    <!-- bootstrap css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	
	<!-- bootstrap icon -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	
	<!-- geral css -->
    <link rel="stylesheet" href="../../../../assets/css/style.css"/>
    
    <!-- editor code css -->
    <link rel="stylesheet" href="../../../../assets/css/editor-code.css"/>
	
	<!-- color picker css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
	
	<!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jquery js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    <!-- ckeditor -->
    <script type="text/javascript" src="../../../../assets/ckeditor_4.14.0_basic/ckeditor.js"></script>

	<!-- color picker css -->
    <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>

    <script type="text/javascript">
        window.onload = function()  {
            CKEDITOR.replace( 'descricao' );
        };
    </script>
    
</head>
<body>

<div id="loading"></div>