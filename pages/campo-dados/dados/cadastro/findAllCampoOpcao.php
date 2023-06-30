<?php
    use Src\Repository\CampoDados\Dados\CampoOpcaoRepository;
    
    require_once '../../../usuario/login/controle/verificaLogado.php';
    require_once '../../../../autoload.php';
    
    $repositoty = new CampoOpcaoRepository();
    $list = $repositoty->findByIdCampo($_POST['idCampo']);

?>

<hr/>

<div class="text-end">
	<button type="button" class="btn btn-success btn-sm mb-2" onclick="openModalSelecaoOpcao(null);">
  		Adicionar
	</button>
</div>

<table class="table table-bordered table-sm" aria-describedby="Formulários">
	<thead class="thead-dark">
		<tr>
			<th style="width: 90%"> Nome </th>
			<th style="width: 10%"> Ordem </th>
			<th style="max-width: 40px;min-width: 40px;"></th>
		</tr>
	</thead>
	
	<tbody>
	
		<?php foreach ($list as $value) { ?>
		<tr>
			<td><?php echo $value['nome']; ?></td>
			<td><?php echo $value['ordem'] ?></td>
			<td class="text-center">
				<i class="bi bi-pencil text-primary me-2" onclick="openModalSelecaoOpcao(<?php echo $value['id']; ?>)"></i>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

