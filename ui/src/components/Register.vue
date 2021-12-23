<template>
  <div class="register">
      <form action="#">
          <input type="text" v-model="formData.name" placeholder="Enter Name" name="name"/>
          <div class="error" v-if="errors.name">{{errors.name[0]}}</div>
          <input type="text" v-model="formData.email" placeholder="Enter Email" name="email"/>
          <div class="error" v-if="errors.email">{{errors.email[0]}}</div>
          <input type="password" v-model="formData.password" placeholder="Enter Password" name="password"/>
          <div class="error" v-if="errors.password">{{errors.password[0]}}</div>
          <input type="password" v-model="formData.password_confirmed" placeholder="Re-enter Password" name="password_confirmed"/>
          <div class="error" v-if="errors.password_confirmed">{{errors.password_confirmed[0]}}</div>
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
            },
            errors: [],
        }
    },
    emits: ['postRegister'],
    methods: {
        submitRegistrationForm(){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.post('http://localhost/register', {
                    name: this.formData.name,
                    email: this.formData.email,
                    password: this.formData.password,
                    password_confirmed: this.formData.password_confirmed,
                }).then(response => {
                    if(response.status == 200 || response.status == 201){
                        this.$emit('postRegister');
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
