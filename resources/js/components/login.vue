<template>
	<div class="login-box">
	  <div class="login-logo">
	    <a href="/"><b>vue</b>CHAT</a>
	  </div>
	  <!-- /.login-logo -->
	  <div class="login-box-body">
	    <p class="login-box-msg">Sign in to start your session</p>

	    <form method="post" @submit.prevent="login">
	      <div class="form-group has-feedback">
	        <input type="email" class="form-control" placeholder="Email" v-model='email'>
	        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	      </div>
	      <div class="form-group has-feedback">
	        <input type="password" class="form-control" placeholder="Password" v-model='password'>
	        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	      </div>
	      <div class="row">
	        <div class="col-xs-8">
	          <div class="checkbox icheck">
	            <label>
	              <input type="checkbox"> Remember Me
	            </label>
	          </div>
	        </div>
	        <!-- /.col -->
	        <div class="col-xs-4">
	          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
	        </div>
	        <!-- /.col -->
	      </div>
	    </form>

	    <div class="social-auth-links text-center">
	      <p>- OR -</p>
	      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
	        Facebook</a>
	      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
	        Google+</a>
	    </div>
	    <!-- /.social-auth-links -->

	    <a href="#">I forgot my password</a><br>
	    <router-link :to="{name: 'register'}" class="text-center">Register a new membership</router-link>

	  </div>
	  <!-- /.login-box-body -->
	</div>
</template>

<script type="text/javascript">
	import {mapMutations} from 'vuex';
	export default {
		data() {
			return {
				email: '',
				password: '',
				errMsg: ''
			}
		},
		mounted() {
			document.body.classList.add("login-page");
			document.body.classList.remove("skin-blue");
		},
		methods: {
			login() {
				//bring in vee-validate here
				let form = new FormData();
				form.append("email", this.email);
				form.append("password", this.password);
				axios.post("api/login", form).then((res) => {
					let data = res.data;
					if(data.success) {
						this.errMsg = '';
						localStorage.setItem('jwt', data.token);
						localStorage.setItem("user", JSON.stringify(data.user));
						this.email = this.password = '';
						this.$store.commit("CHANGELOGINSTATETOLOGIN");	//change state to logged in after logging in
						this.$router.push({name: "home"});		//redirect to home route after successful login
					}else {
						this.errMsg = data.error;
					}
				}).catch(error => {
					console.log(error);
				});
			}
		}
	}
</script>
<style type="text/css">
	
</style>