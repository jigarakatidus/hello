<template>
    <div class="hello">
    <AddHello @add-hello="(hello) => postAddHello($event, hello)"/>
    <div v-for="hello in hellos" v-bind:key="hello.id">
        <Hello
            @update-hello="(hello) => postUpdateHello($event, hello)"
            @destroy-hello="(id) => destroyHello($event, id)"
            :item="hello" />
    </div>
  </div>
</template>

<script>
import Hello from "./Hello";
import AddHello from './AddHello';
import axios from "axios";
export default {
    name: 'HelloList',
    components: {
        Hello,
        AddHello,
    },
    data(){
        return {
            hellos: []
        }
    },
    emits: ['loggedOut'],
    mounted() {
        axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
            axios.get('http://localhost/api/hello').then(response => {
                this.hellos = response.data;
            }).catch(error => {
                if(error.response.status == 401){
                    this.$emit('loggedOut');
                }
            });
        });
    },
    methods: {
        postUpdateHello(e, hello){
            var index = this.hellos.findIndex((e) => {
               if(e.id == hello.id){
                   return true;
               }
            });
            this.hellos[index].name = hello.name;
        },
        postAddHello(e, hello){
            this.hellos.push(hello);
        },
        destroyHello(e, id){
            var index = this.hellos.findIndex((e) => {
                if(e.id == id){
                    return true;
                }
            });
            console.log("index " + index);
            this.hellos.splice(index, 1);
        }
    }
}
</script>
