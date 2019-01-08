const uri = location.pathname;

const uri_re = /^\/[a-zA-Z0-9]+\/servers$/;
const uri_free_re = /^\/[a-zA-Z0-9]+\/servers\/free$/;

if (uri_re.test(uri) || uri_free_re.test(uri)) serversPageStart();

function serversPageStart() {
    const serversApp = new Vue({
        el: '#servers',
    });
}