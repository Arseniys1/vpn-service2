<template>
    <div class="servers">
        <server-component v-if="servers.length > 0" :server-prop="server" :key="key" v-for="(server, key) in servers"></server-component>
        <p class="text-center" v-if="servers.length === 0">Серверов нет!</p>
    </div>
</template>

<script>
    import ServerComponent from "./ServerComponent";

    export default {
        components: {ServerComponent},
        name: "servers-component",

        props: [
            'serversProp',
        ],

        data() {
            return {
                servers: this.serversProp.data,
            };
        },

        mounted() {

        }
    }
</script>

<style scoped>

</style>