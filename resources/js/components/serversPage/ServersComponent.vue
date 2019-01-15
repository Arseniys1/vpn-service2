<template>
    <div class="servers">
        <server-component v-if="servers.length > 0" :langs-prop="langs" :server-prop="server" :key="key" v-for="(server, key) in servers"></server-component>
        <p class="text-center" v-if="servers.length === 0">{{ langs['no_servers'] }}</p>
    </div>
</template>

<script>
    import ServerComponent from "./ServerComponent";

    export default {
        components: {ServerComponent},
        name: "servers-component",

        props: [
            'serversProp',
            'langsProp',
        ],

        data() {
            return {
                servers: this.serversProp.data,
                langs: this.langsProp,
            };
        },

        mounted() {

        }
    }
</script>

<style scoped>

</style>