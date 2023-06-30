<?php
    use Src\Repository\CampoDados\Dados\CampoOpcaoRepository;
    
    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
    
    $repositoty = new CampoOpcaoRepository();
    $result = $repositoty->findById($_POST['id']);

    echo json_encode($result);
?>
