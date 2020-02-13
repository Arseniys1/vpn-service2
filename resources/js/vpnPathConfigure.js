const uri = location.pathname;

const uri_re = /^\/[a-zA-Z0-9]+\/vpn\/path\/configure$/;

if (uri_re.test(uri)) vpnPathConfigureStart();

function vpnPathConfigureStart() {
    const vpnPathConfigureApp = new Vue({
        el: '#vpn-path-configure',
    });
}