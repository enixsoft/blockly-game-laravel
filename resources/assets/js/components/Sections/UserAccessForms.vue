<template>
 <section class="download bg-primary text-center" id="game">
    <div class="container">
            <div class="row">              
                <LoginForm :errors="errors || {}" :oldUsername="oldLoginUsername" :oldRemember="oldRememberChecked"/>                
                <RegisterForm :errors="errors || {}" :oldUsername="oldRegisterUsername" :oldEmail="oldRegisterEmail"/>
            </div>
    </div>
</section>
</template>
<script>
import LoginForm from './LoginForm';
import RegisterForm from './RegisterForm';

export default {	
	props: {
		errors: Object,
		oldInputs: Object
	},
	components: {
		LoginForm,
		RegisterForm
	},
	computed:
	{
		oldLoginUsername()
		{
			return this.oldInputs && this.oldInputs['login-username'] ? this.oldInputs['login-username'] : '';
		},
		oldRememberChecked()
		{
			return this.oldInputs && this.oldInputs.remember ? true : false;
		},
		oldRegisterUsername()
		{
			return this.oldInputs && this.oldInputs['register-username'] ? this.oldInputs['register-username'] : '';
		},
		oldRegisterEmail()
		{       
			return this.oldInputs && this.oldInputs['email'] ? this.oldInputs['email'] : '';
		}
	}  
};
</script>