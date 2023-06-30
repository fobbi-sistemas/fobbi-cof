function hideModalSelecaoOpcao() {
	$('#modalCampoOpcao').modal('hide');
}

function openModalSelecaoOpcao(id) {

	if (id == null) {
		$('#modalCampoOpcao').modal('show');
		const formulario = document.querySelector('#formCampoOpcao');
		formulario.reset();
	} else {
	
		jQuery.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: "findCampoOpcao.php",
	        data: "id=" + id,
	        cache: false,
	        beforeSend: function() {
	    		document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>';
	     	},
	        complete: function(response) {
				
				console.log(response.responseJSON.nome);
				
				$('#modalCampoOpcao').modal('show');
				
				document.getElementsByName('idCampoOpcao')[0].value = response.responseJSON.id;
			  	document.getElementsByName('nomeCampoOpcao')[0].value = response.responseJSON.nome;
			  	document.getElementsByName('ordemCampoOpcao')[0].value = response.responseJSON.ordem;
				
				
				document.getElementById('loading').innerHTML = null;
	        },
	    });
    }
}

function deleteSelecaoOpcao() {
	
	let idCampoOpcao = document.getElementsByName('idCampoOpcao')[0].value;
	let idCampo = document.getElementsByName('id')[0].value;
	
	jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: "crudCampoOpcao.php",
        data: "&idDelete=" + idCampoOpcao,
        cache: false,
        beforeSend: function() {
			document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>';
     	},
        complete: function(response) {
			
			if (typeof response.responseJSON !== 'undefined' && response.responseJSON.success) {
				loadListSelect(idCampo);
				$('#modalCampoOpcao').modal('hide');
				document.getElementById('loading').innerHTML = null;
			} else {
				document.getElementById('loading').innerHTML = null;
				alert('Ops! Ocorreu um erro, entre em contato com o suporte.');
			}
        },
        error: function() {
			document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div></div>';
		}
    });
	    
}

jQuery(document).ready(function() { 
	jQuery('#formCampoOpcao').submit(function() {
		
		var dados = jQuery( this ).serialize();
		let idCampo = document.getElementsByName('id')[0].value;
		
	    jQuery.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: "crudCampoOpcao.php",
	        data: dados + "&idCampo=" + idCampo,
	        cache: false,
	        beforeSend: function() {
    			document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>';
	     	},
	        complete: function(response) {
				
				if (typeof response.responseJSON !== 'undefined' && response.responseJSON.success) {
					loadListSelect(idCampo);
					$('#modalCampoOpcao').modal('hide');
					document.getElementById('loading').innerHTML = null;
				} else {
					document.getElementById('loading').innerHTML = null;
					alert('Ops! Ocorreu um erro, entre em contato com o suporte.');
				}
	        },
	        error: function() {
    			document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div></div>';
			}
	    });
	    return false;
    });
});