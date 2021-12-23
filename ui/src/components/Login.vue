<template>
  <div class="login">
      <form action="#">
          <input type="text" v-model="formData.email" placeholder="Enter Email" name="email"/>
          <div v-if="errors.email">
              <span>{{errors.email[0]}}</span>
          </div>
          <input type="password" v-model="formData.password" placeholder="Enter Password" name="password"/>
          <div class="error" v-if="errors.password">
              <span>{{errors.password[0]}}</span>
          </div>
          <button type="button" value="Login" @click.prevent="submitLoginForm">Login</button>
      </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Login',
    data(){
        return {
            formData: {
                email: "",
                password: "",
            },
            // user: null,
            errors: []
        }
    },
    emits: ['postLogin'],
    methods: {
        submitLoginForm(){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.post('http://localhost/login', {
                    email: this.formData.email,
                    password: this.formData.password,
                }).then(response => {
                    if(response.status == 200 || response.status == 201){
                        // this.user = response.data;
                        console.log(response.data);
                        this.$emit('postLogin');
                    }
                }).catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }
                });
            });
        }
    }
}
</script>
