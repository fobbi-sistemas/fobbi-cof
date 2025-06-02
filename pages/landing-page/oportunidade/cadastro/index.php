<?php
    use Src\Controller\LandingPage\Oportunidade\OportunidadeController;
    use Src\Util\StatusOportunidade;
     
    require_once '../../../header.php';
    require_once '../menu.php';
    
    $controller = new OportunidadeController();
    $id = isset($_GET['q']) ? $_GET['q'] : null;
    $campoList = array();
    $statusList = array();
    
    if (isset($_POST['save'])) {
		try {
		    $controller->save($id, $_POST);
	        header('location: ?q=' . $id);
		} catch (Exception $ex) {
		    echo $ex->getMessage();
		}
    }
    
    if (isset($_POST['remove'])) {
        try {
            $controller->delete($id);
            header('location: ../lista');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    if (! empty($id)) {
        try {
            $controller->validarHistoricoAtendimento($id);
            $objOportunidade = $controller->findById($id);
            $statusList = $controller->findByStatus($id);
            $campoList = $controller->findByCampo($id);
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

				<label class="form-label"> Status </label> 
				<table class="table table-bordered table-sm table-mobile" aria-describedby="Obras">
    				<thead class="thead-dark">
						<tr>
							<th>Nome</th>
							<th>Data</th>
						</tr>
					</thead>
					
					<tbody>
                    	<?php foreach ($statusList as $status) { ?>
                		<tr>
							<td><?php echo StatusOportunidade::descricao($status['nome']); ?></td>
							<td><?php echo date('d/m/Y H:i:s', strtotime($status['data'])); ?></td>
						</tr>
                    	<?php } ?>
                	</tbody>
				</table>
				
				<hr/>

				<div class="row">
					<div class="col-sm-12 col-md-2 mb-3">
						<label class="form-label"> Marca </label> <input type="text"
							name="marca" class="form-control form-control-sm"
							disabled="disabled"
							value="<?php echo isset($objOportunidade['marca']) ? $objOportunidade['marca'] : null; ?>">
					</div>

					<div class="col-sm-12 col-md-2 mb-3">
						<label class="form-label">Tipo</label> <select name="tipo"
							class="form-select form-select-sm" disabled="disabled">
							<option value="INDICACAO"
								<?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "INDICACAO" ? 'selected' : null; ?>>Indicação</option>
							<option value="SOLICITACAO"
								<?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "SOLICITACAO" ? 'selected' : null; ?>>Solicitação</option>
							<option value="LANDING_PAGE"
								<?php echo isset($objOportunidade['tipo']) && $objOportunidade['tipo'] == "LANDING_PAGE" ? 'selected' : null; ?>>Landing
								Page</option>
						</select>
					</div>
					
					<div class="col-sm-12 col-md-2 mb-3">
						<label class="form-label">ID/CNPJ</label> <input type="text"
							name="idCnpj" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['idCnpj']) ? $objOportunidade['idCnpj'] : null; ?>">
					</div>
					
					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label">Razão Social</label> <input type="text"
							name="razaoSocial" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['razaoSocial']) ? $objOportunidade['razaoSocial'] : null; ?>">
					</div>
					
					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label">Nome Fantasia</label> <input type="text"
							name="nomeFantasia" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['nomeFantasia']) ? $objOportunidade['nomeFantasia'] : null; ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label">Loja</label> <input type="text"
							name="loja" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['loja']) ? $objOportunidade['loja'] : null; ?>">
					</div>

					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label"> Pessoa ou responsável estabelecimento </label>
						<input type="text" name="pessoaResponsavel"
							class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['pessoaResponsavel']) ? $objOportunidade['pessoaResponsavel'] : null; ?>">
					</div>

					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label"> E-mail </label> <input type="text"
							name="email" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['email']) ? $objOportunidade['email'] : null; ?>">
					</div>

					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label"> Indicado por </label> <input
							type="text" name="indicacao" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['indicacao']) ? $objOportunidade['indicacao'] : null; ?>">
					</div>

					<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label"> Telefone </label> <input type="text"
							name="telefone" class="form-control form-control-sm"
							value="<?php echo isset($objOportunidade['telefone']) ? $objOportunidade['telefone'] : null; ?>">
					</div>

					<?php foreach ($campoList as $campo) { ?>
						<div class="col-sm-12 col-md-3 mb-3">
						<label class="form-label"> <?php echo $campo['nome']; ?> </label>
						<input type="text" class="form-control form-control-sm"
							disabled="disabled"
							value="<?php echo $controller->findValor($campo); ?>">
					</div>
					<?php } ?>
    			</div>

				<div class="mb-3">
					<label class="form-label"> Comentário </label>
					<textarea rows="4" name="comentario" class="form-control"
						disabled="disabled"><?php echo $objOportunidade['comentario']; ?></textarea>
				</div>

				<div class="mb-3">
					<label class="form-label"> Observação </label>
					<textarea rows="4" name="observacao" class="form-control"><?php echo $objOportunidade['observacao']; ?></textarea>
				</div>
				
				<?php if (isset($objOportunidade['arquivo'])) { ?>
					<label class="form-label">Anexo</label>
				<div class="mb-3">
					<a
						href="../../../../../files/formulario/<?php echo $objOportunidade['arquivo']; ?>"
						class="text-decoration-none" target="_blank"> <i
						class="bi bi-cloud-download-fill me-2"></i>BAIXAR ARQUIVO
					</a>
				</div>
                <?php } ?>
                
                <hr />

				<div class="row">
					<div class="col">
						<button type="button" class="btn btn-warning btn-sm"
							data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
					</div>

					<div class="col text-end">
						<a href="../lista" class="btn btn-light btn-sm">Voltar</a> <input
							type="submit" value="Salvar" name="save"
							class="btn btn-success btn-sm">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require_once '../../../modalConfirmRemove.php'; ?>
<?php require_once '../../../footer.php'; ?>