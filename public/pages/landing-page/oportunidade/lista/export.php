<?php

    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;

    require_once __DIR__ . '/../../../../../src/bootstrap-page.php';
    
    $controller = new OportunidadeController();
    $list = $controller->findAll($_GET, null);

    // Coloca o codigo da oportunidade como primeira coluna do CSV.
    $list = array_map(function ($row) {
        $codigo = isset($row['codigo_oportunidade']) ? $row['codigo_oportunidade'] : null;
        unset($row['codigo_oportunidade']);
        return array('codigo_oportunidade' => $codigo) + $row;
    }, $list);

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