<template>
    <div class="server">
        <div class="card mb-2">
            <div class="card-body">
                <span class="dot bg-success" v-if="server.online"></span>
                <span class="dot bg-danger" v-if="!server.online"></span>

                {{ server.ip + ':' + server.port }}
                {{ server.country.name + ' ' + server.country.iso }}

                <img class="country-image" :src="'/images/countries/' + server.country.image">

                Online {{ server.online_counter + '/' + server.max_online }}

                <a href="#" v-if="createAccessShow" v-on:click.prevent="createAccess()">{{ langs['create_access'] }}</a>
                <a href="#" v-if="removeAccessShow" v-on:click.prevent="removeAccess()">{{ langs['remove_access'] }}</a>
                <a :href="'/cabinet/download/config/' + this.server.ip" v-if="downloadConfigShow" v-on:click.prevent="downloadConfig()">{{ langs['download_config'] }}</a>
                <p class="d-inline" v-if="waitingShow">{{ langs['waiting'] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "server-component",

        props: [
            'serverProp',
            'langsProp',
        ],

        data() {
            return {
                server: this.serverProp,
                langs: this.langsProp,
                createAccessShow: false,
                removeAccessShow: false,
                downloadConfigShow: false,
                waitingShow: false,
            };
        },

        created() {
            if (laravel.auth) {
                if ((laravel.hasActiveAccess || this.server.free) && this.server.online) {
                    if (this.server.have_access) {
                        this.removeAccessShow = true;
                        this.downloadConfigShow = true;
                    } else {
                        this.createAccessShow = true;
                    }
                }
            }
        },

        methods: {
            createAccess() {
                this.createAccessShow = false;
                this.waitingShow = true;

                axios.post('/servers/create/access', {
                    ip: this.server.ip,
                }).then((res) => {
                    if (res.data.ok) {

                        this.checkResponse(res.data.event_id, () => {
                            this.waitingShow = false;
                            this.removeAccessShow = true;
                            this.downloadConfigShow = true;
                        });

                    } else {
                        if (res.data.code === 1) {

                            this.waitingShow = false;
                            this.createAccessShow = true;

                            errorsShow.showError(res.data.message);
                            console.log(res.data.message);

                        } else if (res.data.code === 2) {

                            this.checkResponse(res.data.event_id, () => {
                                this.waitingShow = false;
                                this.removeAccessShow = true;
                                this.downloadConfigShow = true;
                            });

                        } else if (res.data.code === 3) {

                            this.waitingShow = false;
                            this.removeAccessShow = true;
                            this.downloadConfigShow = true;

                        } else if (res.data.code === 5) {

                            this.waitingShow = false;
                            this.createAccessShow = true;

                            errorsShow.showError(res.data.message);

                        } else if (res.data.code === 6) {

                            this.createAccessShow = false;
                            this.removeAccessShow = false;
                            this.downloadConfigShow = false;
                            this.waitingShow = false;

                            this.server.online = false;

                            errorsShow.showError(res.data.message);

                        }
                    }
                }).catch((err) => {
                    this.waitingShow = false;
                    this.createAccessShow = true;

                    errorsShow.showError(err);
                    console.error(err);
                });
            },

            removeAccess() {
                this.removeAccessShow = false;
                this.downloadConfigShow = false;
                this.waitingShow = true;

                axios.post('/servers/remove/access', {
                    ip: this.server.ip,
                }).then((res) => {
                    if (res.data.ok) {

                        this.checkResponse(res.data.event_id, () => {
                            this.waitingShow = false;
                            this.createAccessShow = true;
                        });

                    } else {
                        if (res.data.code === 1) {

                            this.waitingShow = false;
                            this.removeAccessShow = true;
                            this.downloadConfigShow = true;

                            errorsShow.showError(res.data.message);
                            console.log(res.data.message);

                        } else if (res.data.code === 2) {

                            this.checkResponse(res.data.event_id, () => {
                                this.waitingShow = false;
                                this.createAccessShow = true;
                            });

                        } else if (res.data.code === 3) {

                            this.waitingShow = false;
                            this.createAccessShow = true;

                        } else if (res.data.code === 5) {

                            this.createAccessShow = false;
                            this.removeAccessShow = false;
                            this.downloadConfigShow = false;
                            this.waitingShow = false;

                            this.server.online = false;

                            errorsShow.showError(res.data.message);

                        }
                    }
                }).catch((err) => {
                    this.waitingShow = false;
                    this.removeAccessShow = true;
                    this.downloadConfigShow = true;

                    errorsShow.showError(err);
                    console.error(err);
                });
            },

            downloadConfig() {
                window.open('/cabinet/download/config/' + this.server.ip);
            },

            checkResponse(event_id, callback) {
                const interval_id = setInterval(() => {
                    axios.post('/servers/check/response', {
                        event_id: event_id,
                    }).then((res) => {
                        if (res.data.ok) {
                            clearInterval(interval_id);
                            callback();
                        } else {
                            if (res.data.code === 1 || res.data.code === 2) {
                                clearInterval(interval_id);

                                errorsShow.showError(res.data.message);
                                console.log(res.data.message);
                            }
                        }
                    }).catch((err) => {
                        clearInterval(interval_id);

                        errorsShow.showError(res.data.message);
                        console.error(err);
                    });
                }, 3000);
            },
        },
    }
</script>

<style scoped>
    .country-image {
        height: 20px;
    }
</style>