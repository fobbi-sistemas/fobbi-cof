<?php
    require_once __DIR__ . '/../../src/bootstrap-page.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title> Fobbi COF </title>
    <meta charset="utf-8"/>
    <meta name="author" content="HSYS - Desenvolvimento de Sistemas" />
	<meta name="description" content="Fobbi COF" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= csrf_meta() ?>

    <script src="../../../../assets/js/csrf-setup.js?v=1"></script>
    
    <link rel="shortcut icon" href="../../../../assets/images/favicon.ico"/>
    
    <!-- bootstrap css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	
	<!-- bootstrap icon -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	
	<!-- geral css -->
    <link rel="stylesheet" href="../../../../assets/css/style.css?v=2"/>
    
	<!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jquery js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
</head>
<body>

<div id="loading"></div>