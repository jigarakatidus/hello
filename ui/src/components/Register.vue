<template>
  <div class="register">
      <form action="#">
          <input type="text" v-model="formData.name" placeholder="Enter Name" name="name"/>
          <input type="text" v-model="formData.email" placeholder="Enter Email" name="email"/>
          <input type="password" v-model="formData.password" placeholder="Enter Password" name="password"/>
          <input type="password" v-model="formData.password_confirmed" placeholder="Re-enter Password" name="password_confirmed"/>
          <button type="button" value="Register" @click.prevent="submitRegistrationForm">Register</button>
      </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'Hello',
    data(){
        return {
            formData: {
                name: "",
                email: "",
                password:"",
                password_confirmed: ""
            }
        }
    },
    methods: {
        submitRegistrationForm(){
            console.log("test");
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.post('http://localhost/register', {
                    name: this.formData.name,
                    email: this.formData.email,
                    password: this.formData.password,
                    password_confirmed: this.formData.password_confirmed,
                }).then(function (response){
                    if(response.status == 200 || response.status == 201){
                        this.$emit('postRegister', response);
                    }
                }).catch(function (){
                    // TODO
                });
            });
        }
    }
}
</script>
