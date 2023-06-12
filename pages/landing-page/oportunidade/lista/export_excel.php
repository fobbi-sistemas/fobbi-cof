<meta http-equiv="content-type" content="application/x-msexcel; charset=UTF-8" />

<?php

    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;

    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
    
    $controller = new OportunidadeController();
    $list = $controller->findByAll();

	header("Content-Type: application/x-msexcel; charset=UTF-8");
	header("Content-Disposition: attachment; filename=export.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	$output ="
        <table>
        	<thead>
        		<tr>
        			<th>Código</th>
        			<th>Tipo</th>
        			<th>Data</th>
        			<th>Status</th>
        			<th>ID/CNPJ</th>
                    <th>Razão social</th>
                    <th>Nome fantasia</th>
                    <th>Responsável</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Indicação</th>
                    <th>Comentário</th>
                    <th>Motivo solicitação</th>
        		</tr>
        	</thead>
    	
    		<tbody>";
    		
            foreach ($list as $value) {
    	       
    	       $output .="
    			<tr>
    				<td>" . $value['id'] . "</td>
    				<td>" . $value['tipo'] . "</td>
    				<td>" . $value['data'] . "</td>
                    <td>" . $value['status'] . "</td>
                    <td>" . $value['idCnpj'] . "</td>
                    <td>" . $value['razaoSocial'] . "</td>
                    <td>" . $value['nomeFantasia'] . "</td>
                    <td>" . $value['pessoaResponsavel'] . "</td>
                    <td>" . $value['email'] . "</td>
                    <td>" . $value['telefone'] . "</td>
                    <td>" . $value['indicacao'] . "</td>
                    <td>" . $value['comentario'] . "</td>
                    <td>" . $value['motivoSolicitacao'] . "</td>
    			</tr>";
    		}
    		
    		$output .="
    		</tbody>
    	</table>
    ";
	
	echo $output;
?>