<template>
	<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Vue</b>CHAT</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form method="post" @submit.prevent="register" id="register">
	    <ul v-if="errMsg">
	    	<li v-for="(msg, key, index) in errMsg" :key="index">
	    		{{ key }}
	    		<ul v-for="err in msg">
	    			<li>{{ err }}</li>
	    		</ul>
	    	</li>
	    </ul>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Full name" name="name" v-model="name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" v-model="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" v-model="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" v-model="password_confirmation">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" v-model="terms"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> 
        </div>
        <div class="col-md-12">
        <p class="text text-danger" v-if="Object.keys(errMsg).length > 0">There is a problem with the data submitted. Check the data and submit</p>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div>

    <router-link :to="{name: 'login'}" class="text-center">I already have a membership</router-link>
  </div>
  <!-- /.form-box -->
</div>
</template>

<script type="text/javascript">
import {mapMutations} from 'vuex';
	export default {
		data() {
			return {
				name: '',
				email: '',
				password: '',
				password_confirmation: '',
				errMsg: [],
				terms: ''
			}
		},
		mounted() {
			document.body.classList.add("register-page");
			document.body.classList.remove("skin-blue");
		},
		methods: {
			register() {
				//bring in vee-validate here
				let form = new FormData();
				form.append('name', this.name);
				form.append('email', this.email);
				form.append('password', this.password);
				form.append('password_confirmation', this.password_confirmation);
				this.errMsg = {};
				axios.post("api/register", form).then((res) => {
					let data = res.data;
					if(data.success) {
						this.errMsg = '';
						localStorage.setItem('jwt', data.token);
						localStorage.setItem("user", JSON.stringify(data.user));
						this.$store.commit("CHANGELOGINSTATETOLOGIN");
						this.$router.push({name: "home"});
					}else {
						this.errMsg = data.error;
					}
				}).catch(error => {
					console.log(error.response);
					this.errMsg = error.response.data.error;
				});
			}
		}
	}
</script>