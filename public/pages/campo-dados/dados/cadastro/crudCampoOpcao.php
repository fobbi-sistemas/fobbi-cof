<?php
    use Src\Repository\CampoDados\Dados\CampoOpcaoRepository;
    
    require_once __DIR__ . '/../../../../../src/bootstrap-api.php';
    
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