<?php

    use Src\Controller\Site\Script\ScriptController;

    require_once '../../../header.php';
    require_once '../../menu.php';
    
    $controller = new ScriptController();
    
    try {
        $list = $controller->findAll();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Script </div>

        <div class="card-body">
			<table class="table table-bordered table-sm" aria-describedby="Obras">
				<thead class="thead-dark">
					<tr>
						<th style="width: 100%"> Tipo </th>
						<th style="max-width: 40px;min-width: 40px;"></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($list as $objEntity) { ?>
    					<tr>
    						<td class="fs-7"><?php echo $objEntity['tipo']; ?></td>
                            
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