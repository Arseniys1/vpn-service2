<template>
    <div class="errors-show" v-if="errors.length > 0">
        <div class="alert alert-danger error" role="alert" :key="key" v-for="(error, key) in errors">
            {{ error.message }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "errors-show-component",

        data() {
            return {
                errors: [],
            };
        },

        created() {
            window.errorsShow = this;
        },

        methods: {
            showError(message, timeout = 1500) {
                const error = {
                    message: message,
                    timeout: timeout,
                };

                this.errors.push(error);

                setTimeout(() => {
                    this.errors.splice(this.errors.indexOf(error), 1);
                }, timeout);
            }
        }
    }
</script>

<style scoped>
    .errors-show {
        position: absolute;
        right: 10px;
        max-width: 250px;
    }

    .error {
        z-index: 1;
    }
</style>