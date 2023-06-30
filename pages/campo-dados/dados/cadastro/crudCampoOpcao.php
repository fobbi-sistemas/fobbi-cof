<?php
    use Src\Repository\CampoDados\Dados\CampoOpcaoRepository;
    
    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
    
    $repositoty = new CampoOpcaoRepository();
    
    try {
        
        if (isset($_POST['idDelete'])) {
            $repositoty->delete($_POST['idDelete']);
        } else {
            $repositoty->save($_POST);
        }
        echo json_encode(array("success" => true));
    } catch (Exception $ex) {
        echo json_encode(array("success" => false));
    }

?>