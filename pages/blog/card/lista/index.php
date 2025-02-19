<?php
    use Src\Controller\CardController;
use Src\Util\Segmento;

    require_once '../../../header.php';
    require_once '../../menu.php';
    
    $controller = new CardController();
    $list = array();
    $count = 0;
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    
    try {
        $list = $controller->findAll($_GET, $page);
        $count = count($controller->findAll($_GET, null));
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Card </div>

        <div class="card-body">
        	<form method="get" action="">
        		<div class="text-end mb-1">
        			<a href="../cadastro" class="btn btn-success btn-sm">Novo</a>
        		</div>
    		</form>
        	
        	<div class="table-responsive mb-1">
    			<table class="table table-bordered table-sm table-mobile" aria-describedby="Obras">
    				<thead class="thead-dark">
    					<tr>
    						<th style="width: 10%"> Código </th>
    						<th style="width: 65%"> Nome </th>
    						<th style="width: 25%"> Segmento </th>
    						<th style="max-width: 40px;min-width: 40px;"></th>
    					</tr>
    				</thead>
    				
    				<tbody>
    					<?php foreach ($list as $objEntity) { ?>
        					<tr>
        						<td class="fs-7"><?php echo $objEntity->getId(); ?></td>
        						<td class="fs-7"><?php echo $objEntity->getNome(); ?></td>
        						<td class="fs-7"><?php echo Segmento::descricao($objEntity->getSegmento()); ?></td>
        						<td class="text-center">
    								<a href="../cadastro?q=<?php echo $objEntity->getId(); ?>" title="Editar" class="text-decoration-none">
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
                				<a class="btn btn-light rounded-0" href="?page=<?php echo $link_prev; ?>">
                					&laquo; Anterior
                				</a>
                			</li>
            			<?php } ?>
                	    <?php
                	        $jumlah_page = ceil($count / 25);
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
            					<a class="btn btn-light rounded-0" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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