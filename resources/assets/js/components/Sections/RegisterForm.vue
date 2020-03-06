<template>
<div class="collapse multi-collapse col-md-12 mx-auto" id="registerDiv">
<h2 class="section-heading">Registrácia</h2>
<p>Vyplňte všetky polia. Po registrácii budete automaticky prihlásení.</p>
<div class="form-group">    
<form method="POST" id="registerForm" action="register">
<input type="hidden" name="_token" :value="$global.CsrfToken">
    <div class="form-group col-md-6 mx-auto">
        <label for="register-username" class="col-md-12">Prihlasovacie meno:</label>
        <input class="form-control" id="register-username" type="username" name="register-username" :value="oldUsername" required>
        <span v-for="(error, index) in errors['register-username']" :key="index" class="help-block mx-auto text-danger">
        <strong>{{ error }}</strong>
        <br>
        </span> 
    </div>
    <div class="form-group col-md-6 mx-auto">
        <label for="register-email" class="col-md-12">E-mail:</label>
        <input class="form-control" id="register-email" type="email" name="register-email" :value="oldEmail" required>
        <span v-for="(error, index) in errors['register-email']" :key="index" class="help-block mx-auto text-danger">
        <strong>{{ error }}</strong>
        <br>
        </span>  
    </div>
    <div class="form-group col-md-6 mx-auto">
        <label for="register-password" class="col-md-12">Heslo: </label>
        <input id="register-password" autocomplete="new-password" type="password" class="form-control" name="register-password" required> 
        <span v-for="(error, index) in errors['register-password']" :key="index" class="help-block mx-auto text-danger">
        <strong>{{ error }}</strong>
        <br>
        </span>  
    </div>
    <div class="form-group col-md-6 mx-auto">
        <label for="register-password_confirmation" class="col-md-12">Zopakujte heslo: </label>
        <input id="register-password_confirmation" type="password" autocomplete="new-password" class="form-control" name="register-password_confirmation" required>
    </div>
    <div class="form-group g-recaptcha" :data-sitekey="$global.RecaptchaKey" style="margin: 0 auto;display: table">     
    </div>
        <div v-if="errors['g-recaptcha-response']" class="help-block mx-auto text-danger">
        <strong>{{ $global.Lang.validation.recaptcha }}</strong>        
        </div>                      
    <br>
    <div class="col-md-6 mx-auto">
        <button class="btn btn-lg btn-success" type="submit">
        Zaregistrovať sa
        </button>
    </div>
    <br>
    <div class="col-md-6 mx-auto">
        <p>
            Máte už účet?
            <a class="btn btn-link" data-toggle="collapse" href="" data-target=".multi-collapse">
            Prihláste sa.
            </a>
        </p>
    </div>
</form>
</div>
</div>
</template>
<script>
export default {
    props: {       
        errors: Object,
        oldUsername: String,
        oldEmail: String
    },
    data() {
        return {
            // csrfToken: window.csrfToken
        }
    },
    mounted(){
        console.log(this.errors);
    }
}
</script>