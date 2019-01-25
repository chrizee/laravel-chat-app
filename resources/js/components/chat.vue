<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Chats</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Chats</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <router-view></router-view>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-3 connectedSortable">
                    <div class="box box-solid box-success">
                        <div class="box-header">
                            <i class="fa fa-users"></i>
                            <h3 class="box-title">Friends ({{ friends.length}})</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="list-group">
                                <li class="list-item" v-for="friend in friends" :key="friend.id">
                                    <router-link :to="`/chat/${friend.id}`">
                                        <div class="user-panel">
                                            <div class="pull-left image">
                                                <img :src="friend.picture" class="img-circle" alt="User Image">
                                            </div>
                                            <div class="pull-left info">
                                                <p v-text="friend.name"></p>
                                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                                            </div>
                                        </div>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.box -->

                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
    export default {
        computed: {
            ...mapGetters(['friends'])
        },
        mounted() {
            this.$store.dispatch("getFriends");
        }
    }
</script>
<style scoped>
    li {
        list-style: none;
    }
    li p {
        color: #222;
    }
</style>