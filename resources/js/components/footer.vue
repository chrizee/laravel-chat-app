<template>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.8
        </div>
        <strong>Copyright &copy; {{ date }} <a href="#">Christopher Studio</a>.</strong> All rights
        reserved.
    </footer>
</template>

<script>
    export default {
        data() {
            return {
                date: (new Date()).getFullYear()
            }
        },
        mounted() {
            console.log("footer mounted");
        }
    }
</script>