<?php
    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;

    require_once '../../../header.php';
    require_once '../menu.php';
    
    $controller = new OportunidadeController();
    
    try {
        $list = $controller->findByAll();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Formulário </div>

        <div class="card-body">
			<table class="table table-bordered table-sm" aria-describedby="Obras">
				<thead class="thead-dark">
					<tr>
						<th style="width: 5%"> Código </th>
						<th style="width: 21%"> Nome </th>
						<th style="width: 21%"> ID/CNPJ </th>
						<th style="width: 22%"> Loja </th>
						<th style="width: 10%"> Tipo </th>
						<th style="width: 10%"> Landing Page </th>
						<th style="width: 10%"> Data </th>
						<th style="width: 10%"> Status </th>
						<th style="max-width: 40px;min-width: 40px;"></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($list as $objEntity) { ?>
    					<tr>
    						<td><?php echo $objEntity['id']; ?></td>
    						<td><?php echo $objEntity['nome']; ?></td>
    						<td><?php echo $objEntity['idCnpj']; ?></td>
    						<td><?php echo $objEntity['loja']; ?></td>
    						<td><?php echo $objEntity['tipo'] == "INDICACAO" ? 'Indicação' : 'Solicitação'; ?></td>
    						<td><?php echo $objEntity['formulario']; ?></td>
    						<td><?php echo date('d/m/Y H:i:s', strtotime($objEntity['data'])); ?></td>
    						<td><?php echo $objEntity['status'] == "PENDENTE" ? 'Pendente' : 'Finalizado'; ?></td>
    						<td class="text-center">
								<a href="../cadastro?q=<?php echo $objEntity['id']; ?>" title="Editar" class="text-decoration-none">
									<em class="bi bi-pencil"></em>
								</a>
    						</td>
    					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>