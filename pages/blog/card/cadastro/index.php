<?php
    use Src\Controller\CardController;
use Src\Model\Card;
use Src\Util\Segmento;

    require_once '../../../header.php';
    require_once '../../menu.php';
    
    
    $controller = new CardController();
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    $entity = new Card();
    
    if (isset($id)) {
        try {
            $entity = $controller->findById($id);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    if (isset($_POST['save'])) {
        try {
            $entity = $controller->save($id, $_POST, $_FILES);
            header('location: ?q=' . $entity->getId());
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Card </div>

        <div class="card-body">
        	<form method="post" enctype="multipart/form-data">
				<div class="row">
                    <div class="col-sm-12 col-md-2 mb-3">
    					<label class="form-label"> Código </label>
    					<input type="text" name="id" class="form-control form-control-sm" disabled="disabled"
    						   value="<?php echo $entity->getId(); ?>"/>
                    </div>
                    
                    <div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Nome </label>
    					<input type="text" name="nome" class="form-control form-control-sm" required="required"
    						   value="<?php echo $entity->getNome(); ?>"/>
                    </div>
                    
                    <div class="col-sm-12 col-md-5 mb-3">
    					<label class="form-label"> Link </label>
    					<input type="text" name="link" class="form-control form-control-sm" required="required"
    						   value="<?php echo $entity->getLink(); ?>"/>
                    </div>
                    
                    <div class="col-sm-12 col-md-2 mb-3">
                    	<label class="form-label"> Ativo </label>
                    	<select name="ativo" class="form-select form-select-sm">
                		    <option value="1" <?php echo empty($entity->getId()) || $entity->getAtivo() ? 'selected' : null; ?>>
                            	Sim
                            </option>
                            
                            <option value="0"
                                    <?php echo !empty($entity->getId()) && !$entity->getAtivo() ? 'selected' : null; ?>>
                            	Não
                            </option>
                    	</select>
                    </div>
            	</div>
            	
            	<div class="row">
            		<div class="col-sm-12 col-md-2 mb-3">
    					<label class="form-label"> Status </label>
    					<select name="segmento" class="form-select form-select-sm">
    						<?php foreach (Segmento::list() as $status) { ?>
    							<option value="<?php echo $status; ?>" <?php echo $status == $entity->getSegmento() ? 'selected' : null; ?>>
    								<?php echo Segmento::descricao($status); ?>
    							</option>
    						<?php } ?>
    					</select>
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
    					<label class="form-label"> Imagem </label>
    					<input class="form-control form-control-sm" name="imagem" type="file">
    					<div class="form-text mb-2">
    						Selecione o arquivo e clique em Salvar no canto inferior direito.
    					</div>
    					
                		<div class="mb-2">
                    		<img alt="" height="95" src="<?php echo $entity->getImagem(); ?>">
                    	</div>
    				</div>
                	
            		<div class="text-end">
    					<a href="../lista" class="btn btn-light btn-sm">Voltar</a>
    					<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
    				</div>
    			</div>
			</form>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>