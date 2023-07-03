<?php

    use Src\Repository\LogSistema\Status\LogSistemaRepository;

    require_once '../../../../autoload.php';
        
    $repository = new LogSistemaRepository();
    
    if ($repository->findAll() > 0) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 200 Success", true, 200);
    }
    
    echo http_response_code();