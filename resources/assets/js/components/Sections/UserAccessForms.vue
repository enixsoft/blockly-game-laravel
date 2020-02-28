<template>
 <section class="download bg-primary text-center" id="game">
         <div class="container">
            <div class="row">  
               <div class="collapse show multi-collapse col-md-12 mx-auto" id="loginDiv">
                  <h2 class="section-heading">Prihlásenie</h2>
                  <p>Pre spustenie hry je potrebné byť prihlásený.</p>
                  <div class="form-group">
                      <LoginForm :errors="errors" :oldUsername="oldLoginUsername" :oldRemember="oldRememberChecked"/>
                  </div>
               </div>
             </div>
             </div>
    </section>
</template>
<script>
import LoginForm from './LoginForm';

export default {
    data(){
        return {
            login: false,
            token: document.head.querySelector('meta[name="csrf-token"]')
        }
    },
    props: {
        errors: Object,
        oldInputs: Object
        // errorsRegister: Object,
        // oldEmail: String,
        // oldUsername: String,
        // oldRememberChecked: Boolean,
        // oldLoginUsername: String
    },
    components: {
        LoginForm
    },
    computed:
    {
        oldLoginUsername()
        {
            return this.oldInputs && this.oldInputs['login-username'] ? this.oldInputs['login-username'] : "";
        },
        oldRememberChecked()
        {
            return this.oldInputs && this.oldInputs.remember ? true : false;
        }
    }, 
    mounted()
    {
        console.log("token",this.token);
    }    
}
</script>