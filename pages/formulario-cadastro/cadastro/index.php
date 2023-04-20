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
    					<label class="form-label">CNPJ</label>
    					<input type="text" name="cnpj" class="form-control form-control-sm" required="required"
    						   value="<?php echo isset($objFormularioCadastro['cnpj']) ? $objFormularioCadastro['cnpj'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Canal</label>
    					<input type="text" name="canal" class="form-control form-control-sm" required="required" 
    						   value="<?php echo isset($objFormularioCadastro['canal']) ? $objFormularioCadastro['canal'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Nome</label>
    					<input type="text" name="contatoNome" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['contatoNome']) ? $objFormularioCadastro['contatoNome'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">E-mail</label>
    					<input type="text" name="email" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['email']) ? $objFormularioCadastro['email'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Telefone</label>
    					<input type="text" name="telefone" class="form-control form-control-sm"
    						   value="<?php echo isset($objFormularioCadastro['telefone']) ? $objFormularioCadastro['telefone'] : null; ?>">
    				</div>
    				
    				<div class="col-sm-12 col-md-3 mb-3">
    					<label class="form-label">Status</label>
    					<select name="status" class="form-select form-select-sm">
    						<option value="PENDENTE" <?php echo isset($objFormularioCadastro['status']) && $objFormularioCadastro['status'] == "PENDENTE" ? 'selected' : null; ?>>Pendente</option>
    						<option value="FINALIZADO" <?php echo isset($objFormularioCadastro['status']) && $objFormularioCadastro['status'] == "FINALIZADO" ? 'selected' : null; ?>>Finalizar</option>
    					</select>
    				</div>
                </div>
				
				<?php if (isset($objFormularioCadastro['arquivo'])) { ?>
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