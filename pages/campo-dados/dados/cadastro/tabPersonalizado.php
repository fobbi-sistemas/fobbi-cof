<?php

    use Src\Controller\CampoDados\Dados\PersonalizadoController;

    $controller = new PersonalizadoController();
    $list = array();
    
    try {
        $list = $controller->findByAll();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    if (isset($_POST['savePersonalizacao'])) {
        try {
            $controller->save($_POST);
            header('location: ?aba=2');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

?>

<div class="text-end">
	<button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalPersonalizar">
  		Adicionar
	</button>
</div>
	
<div class="row">
	<div class="col mb-1">
		<label class="form-label text-muted"> DESCRIÇÃO </label>
	</div>
	
	<div class="col mb-1">
		<label class="form-label text-muted"> TIPO </label>
	</div>
          
    <div class="col mb-1" style="min-width: 65px;max-width: 65px;">
   	</div>
</div>

<?php foreach ($list as $objEntity) { ?>
	<div class="row">
		<div class="col mb-1">
			<input type="text" class="form-control form-control-sm" disabled="disabled"
			       value="<?php echo $objEntity['nome']; ?>">
		</div>
		
		<div class="col mb-1">
			<input type="text" class="form-control form-control-sm" disabled="disabled"
				   value="<?php echo $objEntity['tipo']; ?>">
		</div>
              
        <div class="col pt-1 mb-1" style="min-width: 65px;max-width: 65px;">
        	<i class="bi bi-pencil text-primary me-2" data-bs-toggle="modal" data-bs-target="#modalPersonalizar"
               data-id="<?php echo $objEntity['id']; ?>" data-nome="<?php echo $objEntity['nome']; ?>"
               data-tipo="<?php echo $objEntity['tipo']; ?>"></i>
               
        	<i class="bi bi-trash text-danger"></i>
       	</div>
       </div>
<?php } ?>

<!-- MODAL -->
<div class="modal fade" id="modalPersonalizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
	 data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		
      		<div class="modal-body">
        		<form method="post">
        		
        			<input type="hidden" name="id">
        		
        			<div class="mb-3">
        				<label class="form-label"> Nome </label>
        				<input type="text" name="nome" class="form-control form-control-sm">
        			</div>
        			
        			<div class="mb-3">
        				<label class="form-label"> Tipo </label>
        				<select name="tipo" class="form-select form-select-sm" onchange="changeTipo()">
        					<option value="TEXTO"> Texto </option>
        					<option value="SELECAO"> Seleção </option>
        					<option value="INTEIRO"> Inteiro </option>
        				</select>
        			</div>
        			
        			<div class="mb-3" id="tableSelect">
        			
        			</div>
        			
        			<div class="mb-3 text-end">
        				<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
        				<input type="submit" name="savePersonalizacao" value="Salvar" class="btn btn-success btn-sm">
        			</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="modalCampoOpcao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
	 data-bs-backdrop="static">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="btn-close" data-bs-dismiss="modalx" aria-label="Close"></button>
      		</div>
      		
      		<div class="modal-body">
        		<form method="post" id="formCampoOpcao">
        		
        			<input type="hidden" name="idCampoOpcao">
        		
        			<div class="mb-3">
        				<label class="form-label"> Nome </label>
        				<input type="text" name="nomeCampoOpcao" class="form-control form-control-sm">
        			</div>
        			
        			<div class="mb-3">
    					<label class="form-label"> Ordem </label>
    					<input type="number" name="ordemCampoOpcao" class="form-control form-control-sm"/>
    					<div class="form-text">Informe um número inteiro para definir a ordem de apresentação no site.</div>
                    </div>
        			
        			<div class="row">
        				<div class="col">
        					<button type="button" class="btn btn-warning btn-sm mb-3" onclick="deleteSelecaoOpcao();">
        						Excluir
        					</button>
        				</div>
        			
        				<div class="col text-end">
        					<button type="button" class="btn btn-light btn-sm mb-3" onclick="hideModalSelecaoOpcao();">
        						Cancelar
        					</button>
        				
        					<input type="submit" name="saveCampoOpcao" value="Salvar" class="btn btn-success btn-sm mb-3">
        				</div>
        			</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>

<!-- SCRIPT -->
<script src="js/ModalPersonalizar.js?v=1"></script>
<script src="js/ModalCampoOpcao.js?v=1"></script>
<script src="js/ChangeTipo.js?v=1"></script>
