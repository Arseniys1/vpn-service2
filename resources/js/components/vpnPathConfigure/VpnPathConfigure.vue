<template>
    <div class="vpn-path-configure">
        <form>
            <div class="form-group" v-for="(path, index) in pathElements" :key="'server-' + index">
                <label :for="'select-' + index" :key="'label-' + index">Сервер #{{ index + 1 }}</label>
                <select class="form-control" :id="'select-' + index" v-on:change="changeServer(index, $event)"
                        :key="'select-' + index">

                    <option value="">Выберите сервер</option>

                    <option v-for="(server, server_index) in path.servers"
                            v-if="(server.ip && server.port) && (serversSelected.indexOf(server) === -1 || path.selected === server)"
                            :key="'option-' + index + '-' + server_index" :value="server_index">{{ server.ip + ':' +
                        server.port }}
                    </option>

                    <option v-if="pathElements.length > 1 && pathElements.length - 1 === index" value="tor">TOR</option>
                </select>
            </div>
            <button class="btn btn-primary"
                    v-if="pathElements.length < maxServersInPath && pathElements.length < servers.length + 1"
                    v-on:click.prevent="addPathElement">Добавить сервер
            </button>
            <button class="btn btn-success" v-on:click.prevent="create">Создать</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "vpn-path-configure",

        props: [
            'serversProp',
        ],

        data() {
            const servers = JSON.parse(atob(this.serversProp));

            servers.push({
                ip: '127.0.0.2',
                port: 443,
            });

            const path = {
                servers: servers.slice(),
                selected: null,
            };

            return {
                servers: servers,
                serversSelected: [],
                maxServersInPath: 5,
                pathElements: [path],
            };
        },

        methods: {
            changeServer: function (index, event) {
                const server_index = event.target.value;

                if (server_index === '') {
                    return event.preventDefault();
                } else if (server_index === 'tor') {
                    return this.pathElements[index].selected = 'tor';
                }

                this.pathElements[index].selected = this.servers[server_index];
                this.serversSelected.push(this.servers[server_index]);
            },

            addPathElement: function (event) {
                if (this.pathElements[this.pathElements.length - 1].selected === null) {
                    window.errorsShow.showError('Выберите сервер!');
                    return event.preventDefault();
                }

                this.pathElements.push({
                    servers: this.servers.slice(),
                    selected: null,
                });
            },

            create: function (event) {
                console.log(this.pathElements);
            }
        },
    }
</script>

<style scoped>

</style>