<template>
    <form action="#">
        <input type="text" v-model="formData.name" />
        <button type="button" @click.prevent="submitEditForm">Submit</button>
    </form>
</template>

<script>
import axios from "axios";
export default {
    name: 'AddHello',
    emits: ['addHello'],
    data(){
        return {
            editHello: false,
            formData: {
                name: "",
            },
        }
    },
    methods: {
        submitEditForm(){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.post('http://localhost/api/hello', {
                    name: this.formData.name,
                }).then(response => {
                    this.$emit('addHello', response.data);
                    this.formData.name = "";
                }).catch(error => {
                    console.log(error.response);
                });
            });
        }
    }
}
</script>
