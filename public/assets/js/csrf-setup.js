// CSRF (equivalente ao axios do Laravel com o header X-CSRF-TOKEN): o token vem
// do <meta name="csrf-token"> emitido pelo header.php e é enviado em todo
// request same-origin que altera estado. Intercepta fetch e XMLHttpRequest (o
// jQuery usa XHR por baixo, então $.ajax também fica coberto), sem precisar
// mexer em cada chamada. Forms HTML comuns usam o campo hidden _token.
(function () {
    var METODOS_SEGUROS = /^(GET|HEAD|OPTIONS|TRACE)$/i;
    var HEADER = 'X-CSRF-TOKEN';

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function mesmaOrigem(url) {
        try {
            return new URL(url, window.location.href).origin === window.location.origin;
        } catch (e) {
            return false;
        }
    }

    var xhrOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function (metodo, url) {
        this.__precisaCsrf = !METODOS_SEGUROS.test(metodo || 'GET') && mesmaOrigem(url);
        return xhrOpen.apply(this, arguments);
    };

    var xhrSend = XMLHttpRequest.prototype.send;
    XMLHttpRequest.prototype.send = function () {
        if (this.__precisaCsrf) {
            this.setRequestHeader(HEADER, csrfToken());
        }
        return xhrSend.apply(this, arguments);
    };

    var fetchOriginal = window.fetch;
    window.fetch = function (entrada, init) {
        var opcoes = init || {};
        var url = typeof entrada === 'string' ? entrada : (entrada && entrada.url) || '';
        var metodo = (opcoes.method || (entrada && entrada.method) || 'GET').toUpperCase();

        if (METODOS_SEGUROS.test(metodo) || !mesmaOrigem(url)) {
            return fetchOriginal(entrada, init);
        }

        var headers = new Headers(opcoes.headers || (entrada && entrada.headers) || {});
        headers.set(HEADER, csrfToken());
        return fetchOriginal(entrada, Object.assign({}, opcoes, { headers: headers }));
    };
})();
