$(document).ready(function() {
	$("select[name=tipo]").change(function(ev){
		if (this.value == "SELECAO") {
 			loadListSelect(document.getElementsByName('id')[0].value);
		}
 	});
});

function loadListSelect(idFormulario) {
    jQuery.ajax({
        type: 'POST',
        url: "findTipoSelecao.php",
        data: "idFormulario=" + idFormulario,
        cache: false,
        beforeSend: function() {
			document.getElementById('tableSelect').innerHTML = null;
    		document.getElementById('loading').innerHTML = '<div class="loading"><div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div></div>';
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