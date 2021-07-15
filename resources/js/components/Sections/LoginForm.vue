<template>
<div class="collapse show multi-collapse col-md-12 mx-auto" id="loginDiv">
<h2 class="section-heading">{{ locales.loginHeading }}</h2>
<p>{{ locales.loginInfo }}</p>
<div class="form-group">    
<form method="POST" id="loginForm" action="/login">
<input type="hidden" name="_token" :value="$global.CsrfToken">
<div class="form-group row col-md-6 mx-auto">
    <label for="login-username" class="col-md-12">{{ locales.userName }}:</label>
    <input class="form-control" id="login-username" type="username" name="login-username" :value="oldUsername" required>    
    <span v-for="(error, index) in errors['name']" :key="index" class="help-block mx-auto text-danger">
    <strong>{{ error }}</strong>
    <br>
    </span> 
</div>
<div class="form-group row col-md-6 mx-auto" :class="{'has-error': errors.password !== undefined}">
    <label for="login-password" class="col-md-12">{{ locales.password }}:</label>
    <input class="form-control" id="login-password" type="password" name="login-password" autocomplete="current-password" required>
    <span v-for="(error, index) in errors['password']" :key="index" class="help-block mx-auto text-danger">
    <strong>{{ error }}</strong>
    <br>
    </span> 
</div>
<div class="col-md-6 mx-auto">
    <label class="fancy-checkbox">
    <input type="checkbox" id="remember" name="remember" :checked="oldRemember" />
    <i class="fa fa-fw fa-square unchecked"></i>
    <i class="fa fa-fw fa-check-square checked"></i> {{ locales.remember }}
    </label>
</div>
<br>
<div class="col-md-6 mx-auto">
    <button class="btn btn-lg btn-success" type="submit">
    {{ locales.loginBtn }}
    </button>
</div>
<br>
<div class="col-md-6 mx-auto">
    <p>
        {{ locales.loginQuestion }}
        <a class="btn btn-link" data-toggle="collapse" href="" data-target=".multi-collapse">
        {{ locales.loginLink }}
        </a>
    </p>
</div>
</form>
</div>
</div>
</template>
<script>
import { userAccessForms as locales } from '../Managers/LocaleManager';
export default {
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales)
		};
	},
	props: {       
		errors: Object,
		oldUsername: String,
		oldRemember: Boolean
	}	
};
</script>