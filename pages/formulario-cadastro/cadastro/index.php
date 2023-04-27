<?php 
    require_once '../../header.php';
    require_once '../menu.php';
    require_once 'class/FormularioCadastro.php';

    $formularioCadastro = new FormularioCadastro();
    $erro = "<strong>Ops!</strong> Ocorreu um erro, entre em contato com o suporte.";
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    
    if (! empty($id)) {
        try {
            $objFormularioCadastro = $formularioCadastro->findById($id);
        } catch (MyException $e) {
            echo $erro;
        }
    }
    
    if (isset($_POST['save'])) {
		try {
		    $formularioCadastro->save($id, $_POST);
	        header('location: ');
		} catch (DefaultException $e) {
		    echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle-fill me-1"></i>'.$e->getMessage().'</div>';
		} catch (MyException $e) {
		    echo $erro;
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
    					<label class="form-label">ID/CNPJ</label>
    					<input type="text" name="idCnpj" class="form-control form-control-sm" required="required"
    						   value="<?php echo isset($objFormularioCadastro['idCnpj']) ? $objFormularioCadastro['idCnpj'] : null; ?>">
    				</div>
    				
    				<?php if ($objFormularioCadastro['tipo'] == "INDICACAO") { ?>
    					<div class="col-sm-12 col-md-3 mb-3">
        					<label class="form-label">Pessoa ou responsável estabelecimento</label>
        					<input type="text" name="pessoaResponsavel" class="form-control form-control-sm" 
        						   value="<?php echo isset($objFormularioCadastro['pessoaResponsavel']) ? $objFormularioCadastro['pessoaResponsavel'] : null; ?>">
        				</div>
        				
        				<div class="col-sm-12 col-md-3 mb-3">
        					<label class="form-label">E-mail</label>
        					<input type="text" name="email" class="form-control form-control-sm"
        						   value="<?php echo isset($objFormularioCadastro['email']) ? $objFormularioCadastro['email'] : null; ?>">
        				</div>
        				
        				<div class="col-sm-12 col-md-3 mb-3">
        					<label class="form-label">Indicação</label>
        					<input type="text" name="indicacao" class="form-control form-control-sm"
        						   value="<?php echo isset($objFormularioCadastro['indicacao']) ? $objFormularioCadastro['indicacao'] : null; ?>">
        				</div>
    				
        				<div class="col-sm-12 col-md-12 mb-3">
        					<label class="form-label">Comentário:</label>
        					<textarea rows="4" name="comentario" class="form-control"><?php echo $objFormularioCadastro['comentario']; ?></textarea>
        				</div>
    				<?php } ?>
    				
    				<?php if ($objFormularioCadastro['tipo'] == "SOLICITACAO") { ?>
    					<div class="col-sm-12 col-md-3 mb-3">
        					<label class="form-label">Número ID vendedor</label>
        					<input type="text" name="vendedor" class="form-control form-control-sm"
        						   value="<?php echo isset($objFormularioCadastro['vendedor']) ? $objFormularioCadastro['vendedor'] : null; ?>">
        				</div>
        			
            			<div class="col-sm-12 col-md-12 mb-3">
        					<label class="form-label">Motivo de solicitação:</label>
        					<textarea rows="4" name="motivoSolicitacao" class="form-control"><?php echo $objFormularioCadastro['motivoSolicitacao']; ?></textarea>
        				</div>
    				<?php } ?>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Status</label>
    					<select name="status" class="form-select form-select-sm">
    						<option value="PENDENTE" <?php echo isset($objFormularioCadastro['status']) && $objFormularioCadastro['status'] == "PENDENTE" ? 'selected' : null; ?>>Pendente</option>
    						<option value="FINALIZADO" <?php echo isset($objFormularioCadastro['status']) && $objFormularioCadastro['status'] == "FINALIZADO" ? 'selected' : null; ?>>Finalizado</option>
    					</select>
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Tipo</label>
    					<select name="tipo" class="form-select form-select-sm">
    						<option value="INDICACAO" <?php echo isset($objFormularioCadastro['tipo']) && $objFormularioCadastro['tipo'] == "INDICACAO" ? 'selected' : null; ?>>Indicação</option>
    						<option value="SOLICITACAO" <?php echo isset($objFormularioCadastro['tipo']) && $objFormularioCadastro['tipo'] == "SOLICITACAO" ? 'selected' : null; ?>>Solicitação</option>
    					</select>
    				</div>
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

<?php include_once '../../footer.php'; ?>