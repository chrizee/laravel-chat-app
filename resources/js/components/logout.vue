<template>
    <div>
        logout
    </div>
</template>

<script>
    export default {
        mounted () {
            this.logout();
        },
        methods: {
            logout() {
                this.$store.dispatch("logout");
                this.$router.push({name: "login"});
            }
        }
    }
</script>