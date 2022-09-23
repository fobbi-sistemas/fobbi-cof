<?php 
    $chave = isset($_GET['q']) ? $_GET['q'] : null;  

    if ($chave != null && $chave == "bKORI6g0xF3BAeEMBebMrT6xL") {
        
        include_once "class/LogSistema.php";
        
        $service = new LogSistema();
        
        if ($service->findAll() > 0) {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        } else {
            header($_SERVER["SERVER_PROTOCOL"]." 200 Success", true, 200);
        }
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 500 Server Error", true, 500);
    }
    
    echo http_response_code();
?>