<?php
    require_once '../../../header.php';
    require_once '../../menu.php';
    
    $aba = isset($_GET['aba']) ? $_GET['aba'] : 1;
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> Lista de Formulário </div>

        <div class="card-body">
        	
			<ul class="nav nav-tabs" id="myTab" role="tablist">
  				<li class="nav-item" role="presentation">
    				<button class="nav-link <?php echo $aba == 1 ? 'active' : null; ?>" id="home-tab" data-bs-toggle="tab"
    					    data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
    					    aria-selected="true">
    					PADRÃO
    				</button>
  				</li>
  				
  				<li class="nav-item" role="presentation">
    				<button class="nav-link <?php echo $aba == 2 ? 'active' : null; ?>" id="profile-tab" data-bs-toggle="tab"
    					    data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
    					    aria-selected="false">
    					PERSONALIZADO
    				</button>
  				</li>
			</ul>
			
			<div class="tab-content" id="myTabContent">
  				<div class="tab-pane fade p-3 <?php echo $aba == 1 ? 'show active' : null; ?>" id="home-tab-pane"
  					 role="tabpanel" aria-labelledby="home-tab" tabindex="0">
  					<?php require_once 'tabPadrao.php'; ?>
  				</div>
  				
  				<div class="tab-pane fade p-3 <?php echo $aba == 2 ? 'show active' : null; ?>" id="profile-tab-pane"
  					 role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
  					<?php require_once 'tabPersonalizado.php'; ?>
  				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once '../../../footer.php'; ?>