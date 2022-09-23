<?php
	include_once "../class/ProjectStage.php";
	$projectStage = new ProjectStage();
?>
<table border="1" aria-labelledby="...">
	<thead>
		<tr>
			<th colspan="4" style="background-color: #eee">Config</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Versão</td>
			<td><?php echo $projectStage->currentVersion(); ?></td>
		</tr>
		<tr>
			<td>Project Stage</td>
			<td><?php echo $projectStage->currentStage(); ?></td>
		</tr>
	</tbody>
</table>
