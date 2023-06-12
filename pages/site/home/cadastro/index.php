<?php
    use Src\Controller\Site\Home\HomeController;

    require_once '../../../header.php';
    require_once '../../menu.php';
  
    $controller = new HomeController();
    
    try {
        $objHome = $controller->findById();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
    if (isset($_POST['save'])) {
        try {
            $controller->save($_POST, $_FILES);
            header('location: ');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Home </div>

        <div class="card-body">
			<form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                	<label for="formFileBanner" class="form-label"> Imagem Banner </label>
                  	<input class="form-control form-control-sm" id="formFileBanner" type="file" name="banner">
                  	<div class="form-text">Selecione o arquivo e clique em Salvar no canto inferior direito</div>
                </div>
				
                <div class="mb-3">
                    <?php if (!empty($objHome['banner'])) { ?>
                        <img width="160" src="../../../../../files/site/<?php echo $objHome['banner']; ?>" alt="">
                    <?php } ?>
                </div>
                
                <hr/>
                
                <div class="mb-3">
                	<label for="formFileModal" class="form-label"> Modal </label>
                  	<input class="form-control form-control-sm" id="formFileModal" type="file" name="modal">
                  	<div class="form-text">Selecione o arquivo e clique em Salvar no canto inferior direito</div>
                </div>
				
                <div class="mb-3">
                    <?php if (!empty($objHome['modal'])) { ?>
                        <img width="160" src="../../../../../files/site/<?php echo $objHome['modal']; ?>" alt="">
                    <?php } ?>
                </div>
                
                <div class="mb-3 form-check">
                	<input type="checkbox" name="modalAtivo" class="form-check-input" id="exampleCheck1"
                	       <?php echo $objHome['modalAtivo'] ? 'checked' : null; ?>>
                	<label class="form-check-label" for="exampleCheck1">Ativo</label>
              	</div>
                
                <hr/>
                
                <label class="mb-3"> Slogan Principal </label>
                
                <div class="row">
                	<div class="col-sm-12 col-md-4 mb-3">
                		<input type="text" class="form-control form-control-sm" name="titulo1"
                			   value="<?php echo $objHome['titulo1'] ?>">
                	</div>
                	
                	<div class="col-sm-12 col-md-2 mb-3">
                		<input type="text" class="form-control form-control-sm" name="corTitulo1" id="colorpicker1">
                	</div>
                </div>
                
                <div class="row">
                	<div class="col-sm-12 col-md-4 mb-3">
                		<input type="text" class="form-control form-control-sm" name="titulo2"
                			   value="<?php echo $objHome['titulo2'] ?>">
                	</div>
                	
                	<div class="col-sm-12 col-md-2 mb-3">
                		<input type="text" class="form-control form-control-sm" name="corTitulo2" id="colorpicker2">
                	</div>
                </div>
                
                <div class="mb-3">
        			<label class="form-label"> Texto de apresentação </label>
        			<textarea id="descricao" name="descricao" class="form-control form-control-sm" rows="4"><?php echo isset($objHome['descricao']) ? $objHome['descricao'] : null; ?></textarea>
            	</div>
                
                <div class="mb-3 text-end">
					<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
            	</div>
			</form>
		</div>
	</div>
</div>

<script>
    $("#colorpicker1").spectrum({
    	color: "<?php echo isset($objHome['corTitulo1']) ? $objHome['corTitulo1'] : '#000'; ?>",
        cancelText: "Cancelar",
        chooseText: "Definir"
    });
    
    $("#colorpicker2").spectrum({
    	color: "<?php echo isset($objHome['corTitulo2']) ? $objHome['corTitulo2'] : '#000'; ?>",
        cancelText: "Cancelar",
        chooseText: "Definir"
    });
</script>

<?php require_once '../../../footer.php'; ?>