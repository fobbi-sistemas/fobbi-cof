<?php

    use Src\Controller\Canais\Formulario\FormularioController;

    require_once '../../../header.php';
    require_once '../../menu.php';
    
    $controller = new FormularioController();
    $list = array();
    
    try {
        $list = $controller->findByAll();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Formulários </div>

        <div class="card-body">
			<table class="table table-bordered table-sm" aria-describedby="Formulários">
				<thead class="thead-dark">
					<tr>
						<th style="width: 5%"> Código </th>
						<th style="width: 95%"> Nome </th>
						<th style="max-width: 40px;min-width: 40px;"></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($list as $objEntity) { ?>
    					<tr>
    						<td><?php echo $objEntity['id']; ?></td>
    						<td><?php echo $objEntity['nome']; ?></td>
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