(function () {
    var senha = document.getElementById('senha');
    var toggle = document.getElementById('toggle-senha');
    var icon = document.getElementById('toggle-senha-icon');
    var form = document.getElementById('form-login');
    var btn = document.getElementById('btn-entrar');

    toggle.addEventListener('click', function () {
        var mostrar = senha.type === 'password';
        senha.type = mostrar ? 'text' : 'password';
        icon.className = mostrar ? 'bi bi-eye-slash' : 'bi bi-eye';
        toggle.setAttribute('aria-label', mostrar ? 'Ocultar senha' : 'Mostrar senha');
    });

    // Desabilita o botao apos o envio (o valor de "entrar" ja foi lido pelo browser no submit).
    form.addEventListener('submit', function () {
        setTimeout(function () { btn.disabled = true; }, 0);
    });
})();
