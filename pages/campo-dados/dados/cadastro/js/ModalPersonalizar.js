$('#modalPersonalizar').on('show.bs.modal', function (event) {
  	var button = $(event.relatedTarget)
  	const id = button.data('id') ? button.data('id') : null;
  	const nome = button.data('nome') ? button.data('nome') : null;
  	const tipo = button.data('tipo') ? button.data('tipo') : null;

  	document.getElementsByName('id')[0].value = id;
  	document.getElementsByName('nome')[0].value = nome;
  	document.getElementsByName('tipo')[0].value = tipo;
  	
  	changeTipo();
});