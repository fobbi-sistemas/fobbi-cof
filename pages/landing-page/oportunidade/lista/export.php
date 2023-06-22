<?php

    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;

    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
    
    $controller = new OportunidadeController();
    $list = $controller->findByAll();

    function cabecalho_download_csv($filename) {
        // desabilitar cache
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        
        // forçar download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        
        // disposição do texto / codificação
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
    
    function array_para_csv(array &$array)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }
    
    cabecalho_download_csv("csv_" . date("Y-m-d") . ".csv");
    echo array_para_csv($list);
    die();
    
    
?>