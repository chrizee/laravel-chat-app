<template>
    <div class="">
        <headercomponent v-if="isLoggedIn"></headercomponent>
        <sidebar v-if="isLoggedIn"></sidebar>
        <router-view></router-view>
        <footercomponent v-if="isLoggedIn"></footercomponent>
    </div>
</template>

<script>
import {mapState} from 'vuex';
    export default {
        mounted() {
            if(this.isLoggedIn) {
                //if users is previously logged in, set authorization header
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt');
            }
        },
        computed: {
            ...mapState(['isLoggedIn']),
        }
    }
</script>
