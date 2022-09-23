<?php 
    require_once '../../header.php';
    require_once '../menu.php';
    require_once 'class/BannerModal.php';

    $objBannerModal = new BannerModal();
    $erro = "<strong>Ops!</strong> Ocorreu um erro, entre em contato com o suporte.";
    
    try {
        $obj = $objBannerModal->findById();
    } catch (MyException $e) {
        echo $erro;
    }
    
    if (isset($_POST['save'])) {
		try {
		    $objBannerModal->update($_POST, $_FILES);
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
        <div class="card-header"> Cadastro de Banner em Modal </div>

        <div class="card-body">
			<form method="post" enctype="multipart/form-data">
				<div class="row">
                    <div class="col mb-3">
                    	<label for="formFileSm" class="form-label"> Upload de imagem </label>
                      	<input class="form-control form-control-sm" id="formFileSm" type="file" name="imagem">
                      	<div class="form-text">Selecione o arquivo e clique em Salvar no canto inferior direito</div>
                    </div>
                </div>
				
                <div class="row">
                    <div class="col mb-3">
                        <?php if (!empty($obj['imagem'])) { ?>
                            <img width="160" src="../../../../files/banner-modal/<?php echo $obj['imagem']; ?>" alt="">
                        <?php } ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col mb-3">
                		<div class="form-check form-switch">
  							<input class="form-check-input" type="checkbox" name="ativo" role="switch" id="flexSwitchCheckDefault" <?php echo $obj['ativo'] ? 'checked' : null; ?> >
  							<label class="form-check-label" for="flexSwitchCheckDefault"> Ativo </label>
						</div>
					</div>
				</div>
                
                <hr/>

                <div class="row">
                	<div class="col text-end"> 
						<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
                	</div>
                </div>
			</form>
		</div>
	</div>
</div>	

<?php include_once '../../footer.php'; ?>