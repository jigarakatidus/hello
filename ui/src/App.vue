<template>
    <img alt="Vue logo" src="./assets/logo.png">
    <div v-if="!loggedIn && !showRegister">
        <Login @post-login="postLogin($event)"></Login>
    </div>
    <div v-if="!loggedIn && showRegister">
        <Register @post-register="postRegister()"></Register>
    </div>
    <div v-if="loggedIn">
        <HelloList @logged-out="loggedIn = false"></HelloList>
    </div>
    <button type="button" v-if="!showRegister && !loggedIn" @click.prevent="showRegister = true">Register</button>
</template>

<script>
import Login from './components/Login';
import Register from './components/Register';
import HelloList from './components/HelloList';
import axios from "axios";
export default {
    name: 'App',
    components: {
        Login,
        Register,
        HelloList,
    },
    data() {
        return {
            loggedIn: false,
            showRegister: false,
        };
    },
    methods: {
        postLogin(){
            this.loggedIn = true;
            localStorage.setItem('loggedInUser', "true")
        },
        postRegister(){
            this.loggedIn = false;
            this.showRegister = false;
        }
    },
    mounted() {
        if("true" == localStorage.getItem('loggedInUser')){
            this.loggedIn = true;
        }
    }
}
axios.defaults.withCredentials = true;
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
