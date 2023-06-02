<?php
    
    use Src\Controller\Site\Script\ScriptController;

    require_once '../../../header.php';
    require_once '../../menu.php';
    
    $controller = new ScriptController();
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    $objScript = null;
    
    try {
        $objScript = $controller->findById($id);
    } catch (Exception $e) {
        echo $e->getMessage();
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
        <div class="card-header"> SCRIPT </div>

        <div class="card-body">
			<form method="post" enctype="multipart/form-data">
				<div class="mb-3">
        			<div id="container-editor-code">
                        <div id="content-box">
                        	<textarea id="textarea-input" name="script" spellcheck="false" wrap="soft"><?php echo isset($objScript['script']) ? htmlspecialchars($objScript['script']) : null; ?></textarea>
                          	<pre id="highlight-area"></pre>
                    	</div>
					</div>
 
  					<div style="display: none" class="autocomplete" id="div-suggester">
    					<ul class="suggester" id="ul-suggester"></ul>
  					</div>
            	</div>
                
            	<div class="text-end">
            		<a href="../lista" class="btn btn-light btn-sm">Voltar</a>
					<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
            	</div>
			</form>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>