<template>
    <div class="">
        <headercomponent></headercomponent>
        <sidebar></sidebar>
        <router-view></router-view>
        <footercomponent></footercomponent>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
