<?php
    use Src\Repository\CampoDados\Dados\CampoOpcaoRepository;
    
    require_once __DIR__ . '/../../../../../src/bootstrap-api.php';
    
    $repositoty = new CampoOpcaoRepository();
    $result = $repositoty->findById($_POST['id']);

    echo json_encode($result);
?>
