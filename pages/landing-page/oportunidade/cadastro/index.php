<?php
    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;
use Src\Util\StatusOportunidade;
use Src\Util\Suborigem;
    
    require_once '../../../header.php';
    require_once '../menu.php';
    
    $controller = new OportunidadeController();
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    $campoList = array();
    
    if (! empty($id)) {
        try {
            $objOportunidade = $controller->findById($id);
            $campoList = $controller->findByCampo($id);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    if (isset($_POST['save'])) {
		try {
		    $controller->save($id, $_POST);
	        header('location: ?q=' . $id);
		} catch (Exception $ex) {
		    echo $ex->getMessage();
		}
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Cadastro de Formulário </div>

        <div class="card-body">
			<form method="post" enctype="multipart/form-data">
			
				<div class="row">
					<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm mb-1">
                            <?php foreach (StatusOportunidade::list() as $status) { ?>
                                <option value="<?php echo $status; ?>"
                                    <?php echo $objOportunidade['status'] === $status ? "selected" : null; ?>>
                                	<?php echo StatusOportunidade::descricao($status); ?>
                                </option>
                            <?php } ?>
                        </select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Tipo</label>
    					<select name="tipo" class="form-select form-select-sm" disabled="disabled">
    						<option value="INDICACAO" <?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "INDICACAO" ? 'selected' : null; ?>>Indicação</option>
    						<option value="SOLICITACAO" <?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "SOLICITACAO" ? 'selected' : null; ?>>Solicitação</option>
    						<option value="LANDING_PAGE" <?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "LANDING_PAGE" ? 'selected' : null; ?>>Landing Page</option>
    					</select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Suborigem</label>
    					<select name="formulario" class="form-select form-select-sm" disabled="disabled">
    						<option></option>
    						<?php foreach (Suborigem::list() as $suborigem) { ?>
                                <option value="<?php echo $suborigem; ?>"
                                    <?php echo $objOportunidade['formulario'] === $suborigem ? "selected" : null; ?>>
                                	<?php echo Suborigem::descricao($suborigem); ?>
                                </option>
                            <?php } ?>
    					</select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">ID Exact</label>
    					<input type="text" name="idExact" class="form-control form-control-sm" disabled="disabled"
    						   value="<?php echo isset($objOportunidade['idExact']) ? $objOportunidade['idExact'] : null; ?>">
    				</div>
				</div>
    				
				<div class="row">	
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Consulta de dados em API (receitaws.com.br) </label>
    					<div>
        					<?php if ($objOportunidade['processadoDadosCnpj']) { ?>
        						<span class="badge bg-success">
                            		Consultado com sucesso
                            	</span>
        					<?php } else { ?>
        						<span class="badge bg-warning text-dark">
                            		Consulta em andamento
                            	</span>
        					<?php } ?>
    					</div>
    				</div>
				</div>
				
				<hr/>
			
				<div class="row">
				 	<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">ID/CNPJ</label>
    					<input type="text" name="idCnpj" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['idCnpj']) ? $objOportunidade['idCnpj'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Razão Social</label>
    					<input type="text" name="razaoSocial" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['razaoSocial']) ? $objOportunidade['razaoSocial'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Nome Fantasia</label>
    					<input type="text" name="nomeFantasia" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['nomeFantasia']) ? $objOportunidade['nomeFantasia'] : null; ?>">
    				</div>
				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Loja</label>
    					<input type="text" name="loja" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['loja']) ? $objOportunidade['loja'] : null; ?>">
    				</div>
    				
					<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Pessoa ou responsável estabelecimento </label>
    					<input type="text" name="pessoaResponsavel" class="form-control form-control-sm" 
    						   value="<?php echo isset($objOportunidade['pessoaResponsavel']) ? $objOportunidade['pessoaResponsavel'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> E-mail </label>
    					<input type="text" name="email" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['email']) ? $objOportunidade['email'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Indicado por </label>
    					<input type="text" name="indicacao" class="form-control form-control-sm"
    						   value="<?php echo isset($objOportunidade['indicacao']) ? $objOportunidade['indicacao'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
        				<label class="form-label"> Telefone </label>
        				<input type="text" name="telefone" class="form-control form-control-sm"
        					value="<?php echo isset($objOportunidade['telefone']) ? $objOportunidade['telefone'] : null; ?>">
        			</div>
    			</div>
    			
    			<div class="row">
					<?php foreach ($campoList as $campo) { ?>
						<div class="col-sm-12 col-md-3 mb-3">
    						<label class="form-label"> <?php echo $campo['nome']; ?> </label>
    						<input type="text" class="form-control form-control-sm" disabled="disabled"
        					value="<?php echo $controller->findValor($campo); ?>">
        				</div>
					<?php } ?>
    			</div>
				
				<div class="mb-3">
					<label class="form-label"> Comentário </label>
					<textarea rows="4" name="comentario" class="form-control"><?php echo $objOportunidade['comentario']; ?></textarea>
				</div>
				
				<?php if (isset($objOportunidade['arquivo'])) { ?>
					<label class="form-label">Anexo</label>
                    <div class="mb-3">
                        <a href="../../../../../files/formulario/<?php echo $objOportunidade['arquivo']; ?>" class="text-decoration-none" target="_blank">
                        	<i class="bi bi-cloud-download-fill me-2"></i>BAIXAR ARQUIVO
                        </a>
                    </div>
                <?php } ?>
                
            	<div class="text-end">
            		<a href="../lista" class="btn btn-light btn-sm">Voltar</a>
					<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
            	</div>
			</form>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>