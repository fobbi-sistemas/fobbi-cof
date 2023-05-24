<?php
    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;
use Src\Util\StatusOportunidade;
use Src\Util\Suborigem;
    
    require_once '../../../header.php';
    require_once '../menu.php';
    
    $controller = new OportunidadeController();
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    
    if (! empty($id)) {
        try {
            $objFormularioCadastro = $controller->findById($id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    if (isset($_POST['save'])) {
		try {
		    $controller->save($id, $_POST);
	        header('location: ');
		} catch (Exception $e) {
		    echo $e->getMessage();
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
                                    <?php echo $objFormularioCadastro['status'] === $status ? "selected" : null; ?>>
                                	<?php echo StatusOportunidade::descricao($objFormularioCadastro['status']); ?>
                                </option>
                            <?php } ?>
                        </select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Tipo</label>
    					<select name="tipo" class="form-select form-select-sm" disabled="disabled">
    						<option value="INDICACAO" <?php echo isset($objFormularioCadastro['tipo']) && $objFormularioCadastro['tipo'] == "INDICACAO" ? 'selected' : null; ?>>Indicação</option>
    						<option value="SOLICITACAO" <?php echo isset($objFormularioCadastro['tipo']) && $objFormularioCadastro['tipo'] == "SOLICITACAO" ? 'selected' : null; ?>>Solicitação</option>
    						<option value="LANDING_PAGE" <?php echo isset($objFormularioCadastro['tipo']) && $objFormularioCadastro['tipo'] == "LANDING_PAGE" ? 'selected' : null; ?>>Landing Page</option>
    					</select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Suborigem</label>
    					<select name="formulario" class="form-select form-select-sm" disabled="disabled">
    						<?php foreach (Suborigem::list() as $suborigem) { ?>
                                <option value="<?php echo $suborigem; ?>"
                                    <?php echo $objFormularioCadastro['formulario'] === $suborigem ? "selected" : null; ?>>
                                	<?php echo Suborigem::descricao($objFormularioCadastro['formulario']); ?>
                                </option>
                            <?php } ?>
    					</select>
    				</div>
				</div>
				
				<hr/>
			
				<div class="row">
					 <div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">ID/CNPJ</label>
    					<input type="text" name="idCnpj" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['idCnpj']) ? $objFormularioCadastro['idCnpj'] : null; ?>">
    				</div>
				
					<div class="col-sm-12 col-md-3 mb-3">
        				<label class="form-label">Nome</label>
        				<input type="text" name="nome" class="form-control form-control-sm"
        					value="<?php echo isset($objFormularioCadastro['nome']) ? $objFormularioCadastro['nome'] : null; ?>">
        			</div>
				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Loja</label>
    					<input type="text" name="loja" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['loja']) ? $objFormularioCadastro['loja'] : null; ?>">
    				</div>
    				
					<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Pessoa ou responsável estabelecimento </label>
    					<input type="text" name="pessoaResponsavel" class="form-control form-control-sm" 
    						   value="<?php echo isset($objFormularioCadastro['pessoaResponsavel']) ? $objFormularioCadastro['pessoaResponsavel'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> E-mail </label>
    					<input type="text" name="email" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['email']) ? $objFormularioCadastro['email'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label"> Indicação </label>
    					<input type="text" name="indicacao" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['indicacao']) ? $objFormularioCadastro['indicacao'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Número ID vendedor</label>
    					<input type="text" name="vendedor" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['vendedor']) ? $objFormularioCadastro['vendedor'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
        				<label class="form-label"> Telefone </label>
        				<input type="text" name="telefone" class="form-control form-control-sm"
        					value="<?php echo isset($objFormularioCadastro['telefone']) ? $objFormularioCadastro['telefone'] : null; ?>">
        			</div>
    			</div>
				
				<div class="mb-3">
					<label class="form-label"> Comentário </label>
					<textarea rows="4" name="comentario" class="form-control"><?php echo $objFormularioCadastro['comentario']; ?></textarea>
				</div>
				
    			<div class="col-sm-12 col-md-12 mb-3">
					<label class="form-label">Motivo de solicitação:</label>
					<textarea rows="4" name="motivoSolicitacao" class="form-control"><?php echo $objFormularioCadastro['motivoSolicitacao']; ?></textarea>
				</div>
				
				<?php if (isset($objFormularioCadastro['arquivo'])) { ?>
					<label class="form-label">Anexo</label>
                    <div class="mb-3">
                        <a href="../../../../files/formulario/<?php echo $objFormularioCadastro['arquivo']; ?>" class="text-decoration-none" target="_blank">
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