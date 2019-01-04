const uri = location.pathname;

const uri_re = /^\/[a-zA-Z0-9]+\/servers$/;

if (uri_re.test(uri)) serversPageStart();

function serversPageStart() {
    $('a[name="sendRequest"]').click((e) => {
        e.preventDefault();

        const a = $(e.target);
        const ip = a.attr('data-ip');

        if (a.text() === 'Подождите...') return;

        axios.post('/servers/create/access', {
            ip: ip,
        }).then((res) => {
            if (res.data.ok) {
                a.text('Подождите...');
                startCheckResponse(a, res.data.event_id);
            } else {
                alert(res.data.message);
                console.log(res.data);
            }
        }).catch((error) => {
            alert('Error');
            console.log(error);
        });
    });

    function startCheckResponse(a, event_id) {
        const interval_id = setInterval(() => {
            axios.post('/servers/check/response', {
                event_id: event_id,
            }).then((res) => {
                if (res.data.ok) {
                    clearInterval(interval_id);
                    a.hide();
                }
            }).catch((error) => {
                clearInterval(interval_id);
                alert('Error');
                console.log(error);
            });
        }, 1000);
    }
}