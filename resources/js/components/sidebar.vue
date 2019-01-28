<template>
    <div>
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img :src="user.picture" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p v-text="user.name"></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    
                        <router-link :to="{name : 'home'}" tag="li" exact>
                            <a>   
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </router-link>
                    
                    
                        <router-link tag="li" :to="{name: 'chat'}">
                            <a>
                                <i class="fa fa-comment"></i> <span>Chat</span>
                            </a>
                        </router-link>
                    
                        <router-link tag="li" :to="{name: 'add-friend'}">
                            <a>
                                <i class="fa fa-comment"></i> <span>Add Friend</span>
                            </a>
                        </router-link>
                    
                        <router-link tag="li" :to="{name: 'register'}">
                            <a>
                                <i class="fa fa-comment"></i> <span>Register</span>
                            </a>
                        </router-link>
                    
                        <router-link tag="li" :to="{name: 'login'}">
                            <a>
                                <i class="fa fa-comment"></i> <span>Login</span>
                            </a>
                        </router-link>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        mounted() {
            console.log("sidebar mounted");
        },
        computed: {
            ...mapState(['user'])
        }
    }
</script>