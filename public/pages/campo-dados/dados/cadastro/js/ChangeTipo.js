// change tipo
function changeTipo() {
	
	let value = document.getElementsByName('tipo')[0].value;
	let id = document.getElementsByName('id')[0].value;
	
	console.log("testee " + id);
	
	if (Object.values(id).length && value == "SELECAO") {
		loadListSelect(document.getElementsByName('id')[0].value);
	} else {
		document.getElementById('tableSelect').innerHTML = null;
	}
};

// carrega a lista cadastrada de opções
function loadListSelect(idCampo) {
    jQuery.ajax({
        type: 'POST',
        url: "findAllCampoOpcao.php",
        data: "idCampo=" + idCampo,
        cache: false,
        beforeSend: function() {
			document.getElementById('tableSelect').innerHTML = null;
    		document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>';
     	},
        success: function(html) {
			document.getElementById('tableSelect').innerHTML = html;
			document.getElementById('loading').innerHTML = null;
        },
        error: function() {
			document.getElementById('loading').innerHTML = null;
		}
    });
}