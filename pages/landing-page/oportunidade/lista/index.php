<?php
    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;
    use Src\Util\StatusOportunidade;
    use Src\Util\Origem;

    require_once '../../../header.php';
    require_once '../menu.php';
    
    $controller = new OportunidadeController();
    $list = array();
    $count = 0;
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $dataCadastroInicial = isset($_GET['dataCadastroInicial']) ? $_GET['dataCadastroInicial'] : null;
    $dataCadastroFinal = isset($_GET['dataCadastroFinal']) ? $_GET['dataCadastroFinal'] : null;
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;
    $origemFilter = isset($_GET['origem']) ? $_GET['origem'] : null;
    
    try {
        $list = $controller->findAll($_GET, $page);
        $count = count($controller->findAll($_GET, null));
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Formulário </div>

        <div class="card-body">
        	<form method="get" action="">
    			<div class="row align-items-end">
    				<div class="col-sm-12 col-md-2 mb-3">
            			<label class="form-label"> Data cadastro inicial </label>
            			<input type="date" name="dataCadastroInicial" value="<?php echo $dataCadastroInicial; ?>"
            				   class="form-control form-control-sm"/>
            		</div>
            		
            		<div class="col-sm-12 col-md-2 mb-3">
            			<label class="form-label"> Data cadastro final </label>
            			<input type="date" name="dataCadastroFinal" value="<?php echo $dataCadastroFinal; ?>"
            				   class="form-control form-control-sm"/>
            		</div>
            		
            		<div class="col-sm-12 col-md-2 mb-3">
            			<label class="form-label"> Status </label>
            			<select name="status" class="form-select form-select-sm">
            				<option value="">- Todos -</option>
            				<?php foreach (StatusOportunidade::listFacilCatalogos() as $status) { ?>
            					<option value="<?php echo $status; ?>" <?php echo $status == $statusFilter ? 'selected' : null; ?>>
            						<?php echo StatusOportunidade::descricaoFacilCatalogos($status); ?>
            					</option>
            				<?php } ?>
            			</select>
            		</div>
            		
            		<div class="col-sm-12 col-md-2 mb-3">
            			<label class="form-label"> Origem </label>
            			<select name="origem" class="form-select form-select-sm">
            				<option value="">- Todos -</option>
            				<option value="NAO_DEFINIDO">Não definido</option>
            				<?php foreach (Origem::list() as $origem) { ?>
            					<option value="<?php echo $origem; ?>" <?php echo $origem == $origemFilter ? 'selected' : null; ?>>
            						<?php echo Origem::descricao($origem); ?>
            					</option>
            				<?php } ?>
            			</select>
            		</div>
            		
            		<div class="col text-end mb-3">
            			<a href="export.php" target="_blank" class="btn btn-light btn-sm">Exportar em CSV</a>
            			<input type="submit" name="pesquisar" value="Pesquisar" class="btn btn-primary btn-sm">
            		</div>
    			</div>
    		</form>
        	
        	<div class="table-responsive mb-1">
    			<table class="table table-bordered table-sm" aria-describedby="Obras">
    				<thead class="thead-dark">
    					<tr>
    						<th style="width: 5%"> Código </th>
    						<th style="width: 12%"> ID/CNPJ </th>
    						<th style="width: 20%"> Razão social </th>
    						<th style="width: 5%"> Telefone </th>
    						<th style="width: 8%"> E-mail </th>
    						<th style="width: 15%"> Origem </th>
    						<th style="width: 10%"> Data </th>
    						<th style="width: 15%"> Atendimento </th>
    						<th style="width: 10%"> Status </th>
    						<th style="max-width: 40px;min-width: 40px;"></th>
    					</tr>
    				</thead>
    				
    				<tbody>
    					<?php foreach ($list as $objEntity) { ?>
        					<tr>
        						<td class="fs-7"><?php echo $objEntity['id']; ?></td>
        						<td class="fs-7"><?php echo $objEntity['idCnpj']; ?></td>
        						<td class="fs-7"><?php echo $objEntity['razaoSocial']; ?></td>
        						<td class="fs-7"><?php echo $objEntity['telefone']; ?></td>
        						<td class="fs-7"><?php echo $objEntity['email']; ?></td>
        						<td class="fs-7">
                            		<?php echo Origem::descricao($objEntity['origem']); ?>
                                </td>
                                
        						<td class="fs-7"><?php echo date('d/m/Y H:i:s', strtotime($objEntity['data'])); ?></td>
    
    							<td class="fs-7"><?php echo $objEntity['observacao']; ?></td>
        						
                                <td>
                                	<span class="badge <?php echo StatusOportunidade::cor($objEntity['statusFacilCatalogos']); ?>">
                                		<?php echo StatusOportunidade::descricaoFacilCatalogos($objEntity['statusFacilCatalogos']); ?>
                                	</span>
                                </td>
                                
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
			
			<div class="row">
				<div class="col">
					<ul class="pagination">
                        <?php if ($page == 1) { ?>
            				<li><a class="btn btn-light rounded-0" href="#">&laquo; Anterior </a></li>
                	    <?php } else { $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                			<li>
                				<a class="btn btn-light rounded-0" href="?page=<?php echo $link_prev; ?>&dataCadastroInicial=<?php echo $dataCadastroInicial; ?>&dataCadastroFinal=<?php echo $dataCadastroFinal ?>&status=<?php echo $statusFilter; ?>&origem=<?php echo $origemFilter; ?>">
                					&laquo; Anterior
                				</a>
                			</li>
            			<?php } ?>
                	    <?php
                	        $jumlah_page = ceil($count / 15);
                            $jumlah_number = 1;
                            $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                            
                            if ($jumlah_page < 3) {
                                $end_number = $jumlah_page;
                            } elseif ($page == 1) {
                                $end_number = 3;
                            } else {
                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;
                            }
            
                            for ($i = $start_number; $i <= $end_number; $i ++) {
                                $link_active = ($page == $i) ? 'class="active"' : '';
                        ?>
            				<li <?php echo $link_active; ?>>
            					<a class="btn btn-light rounded-0" href="?page=<?php echo $i; ?>&dataCadastroInicial=<?php echo $dataCadastroInicial; ?>&dataCadastroFinal=<?php echo $dataCadastroFinal; ?>&status=<?php echo $statusFilter; ?>&origem=<?php echo $origemFilter; ?>"><?php echo $i; ?></a>
            				</li>
            			<?php } ?>
            	        <?php if ($page == $jumlah_page) { ?>
                            <li><a class="btn btn-light rounded-0" href="#">Próximo &raquo; </a></li>
                	    <?php } else { $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                            <li>
                            	<a class="btn btn-light rounded-0" href="?page=<?php echo $link_next; ?>">
                            		Próximo &raquo;
                            	</a>
                            </li>
            			<?php } ?>
                	</ul>
				</div>
				
				<div class="col text-end">
					<div class="form-text">Quantidade total de registros: <?php echo $count; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>