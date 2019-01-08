<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Add Friend</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                      <!-- USERS LIST -->
                      <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Latest Members</h3>

                          <div class="box-tools pull-right">
                            <span class="label label-danger">8 New Members</span>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <ul class="users-list clearfix" v-if="otherUsers">
                            <li v-for="(user, index) in otherUsers" :key="index">
                            
                              <div class="hovereffect">
                                <img :src="user.picture" alt="User Image">
                                <div class="overlay2">
                                <p>
                                  <button @click="addFriend(user.id)" class="btn btn-primary" title="add friend"><i class="fa fa-plus"></i></button>
                                  </p>
                                </div>
                              </div>  
                              <a class="users-list-name" href="#">{{user.name}}</a>
                              <span class="users-list-date">{{user.created_at}}</span>
                              
                            </li>
                          </ul>
                          <!-- /.users-list -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center" v-show="nextUrl">
                          <a href="#" class="uppercase" @click.prevent="loadNext">View more Users</a>
                        </div>
                        <!-- /.box-footer -->
                      </div>
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        name: "AddFriend",
        data() {
          return {
            nextUrl: "api/users",   //hold the next link to load paginated users from.defaults to the first
          }
        },
        beforeRouteEnter(to, from, next) {  
        //todo: move this to when the component is loaded and check if other users are available before sending 
        //the first request
            //get all friends here
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt');
            axios.get("api/users")
            .then((res) => {
                let data = res.data;
                if(data.data) {
                    next(vm => {
                        vm.$store.commit("SETOTHERUSERS", data.data);
                        vm.nextUrl = data.links.next;   //
                    });
                }
            })
            .catch((err) => {
                console.log(err);
            });

        },
        computed: {
            ...mapState(['otherUsers'])
        },
        methods: {
          loadNext() {
            if(this.nextUrl) {
              axios.get(this.nextUrl)
              .then((res) => {
                let data = res.data;
                if(data.data) {
                  this.$store.commit("UPDATEOTHERUSERS", data.data);
                  this.nextUrl = data.links.next;
                }
              })
              .catch((err) => {
                console.log(err);
              })
            }
          },
          addFriend(id) {
            let form = new FormData();
            form.append("friend_id", id);
            axios.post("api/addfriend", form)
            .then((res) => {
              let data = res.data;
              console.log(data);
            })
            .catch((err) => {
              console.log(err)
            })
          }
        }
    }
</script>

<style scoped>
ul li a {
  display: block;
  width: 100%;
}
  .hovereffect {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
  background: -webkit-linear-gradient(45deg, #ff89e9 0%, #05abe0 100%);
  background: linear-gradient(45deg, #ff89e9 0%,#05abe0 100%);
}

.hovereffect .overlay2 {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
  padding: 3em;
  text-align: left;
}

.hovereffect img {
  display: block;
  position: relative;
  width: calc(100% + 60px);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.45s;
  transition: opacity 0.35s, transform 0.45s;
  -webkit-transform: translate3d(-20px,0,0);
  transform: translate3d(-20px,0,0);
}

.hovereffect .overlay2:before {
  position: absolute;
  top: 20px;
  right: 20px;
  bottom: 20px;
  left: 20px;
  border: 1px solid #fff;
  content: '';
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.45s;
  transition: opacity 0.35s, transform 0.45s;
  -webkit-transform: translate3d(-20px,-10px,0);
  transform: translate3d(-20px,-10px,0);
}

.hovereffect a, .hovereffect p {
  color: #FFF;
  text-align: center;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.45s;
  transition: opacity 0.35s, transform 0.45s;
  -webkit-transform: translate3d(-10px,0,0);
  transform: translate3d(-10px,0,0);
}

.hovereffect:hover img {
  opacity: 0.6;
  filter: alpha(opacity=60);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect:hover .overlay2:before,
.hovereffect:hover a, .hovereffect:hover p {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}
</style>