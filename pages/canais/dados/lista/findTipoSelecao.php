<?php

?>

<div class="text-end">
	<button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalFormularioOpcao">
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
		<tr>
			<td>Teste</td>
			<td>1</td>
			<td class="text-center">
				<i class="bi bi-pencil text-primary me-2" data-bs-toggle="collapse" data-bs-target="#collapseFormularioOpcao"
               	data-id="<?php echo 1; ?>" data-nome="<?php echo "teste"; ?>" data-ordem="<?php echo 2; ?>"></i>
			</td>
		</tr>
	</tbody>
</table>

