<template>
    <div class="item" v-if="!editHello">{{item.name}}</div>
    <form action="#" v-if="editHello">
        <input type="text" v-model="formData.name" />
        <button type="button" @click="submitEditForm">Submit</button>
    </form>
    <button type="button" @click="editHello = true" v-if="!editHello">Edit</button>
    <button type="button">Delete</button>
</template>

<script>
import axios from "axios";
export default {
    name: 'Hello',
    props: {
        item: Object,
    },
    emits: ['updateHello'],
    data(){
        return {
            editHello: false,
            formData: {
                name: this.item.name,
            },
        }
    },
    methods: {
        submitEditForm(){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.put('http://localhost/api/hello/' + this.item.id, {
                    name: this.formData.name,
                }).then(response => {
                    console.log(response.data);
                    this.$emit('updateHello', response.data);
                    this.editHello = false;
                }).catch(error => {
                    console.log(error);
                    this.editHello = false;
                });
            });
        }
    }
}
</script>
