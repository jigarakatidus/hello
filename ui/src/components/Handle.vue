<template>
    <div class="row">
<!--        <div class="col-1">-->
<!--            <button class="btn btn-secondary button" @click="add">Add</button>-->
<!--        </div>-->
        <AddHello @add-hello="(hello) => postAddHello($event, hello)"/>
        <div class="col-7">
            <h3>Draggable {{ draggingInfo }}</h3>

            <draggable
                tag="div"
                :list="list"
                class="list-group"
                handle=".handle"
                item-key="id"
            >
                <template #item="{ element, index }">
                    <div class="list-group-item">
                        <i class="fa fa-align-justify handle"></i>
                        <span class="text">Hello </span>
                        <input type="text" class="form-control" v-model="element.name" />
                        <i class="fa fa-pen close" @click="submitEditForm(index, element.name)"></i>
                        <i class="fa fa-times close" @click="deleteHello(index)"></i>
                    </div>
                </template>
            </draggable>
            <div class="alert" v-if="message">{{message}}</div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

import draggable from "vuedraggable";
import AddHello from "./AddHello";
export default {
    name: "handle",
    display: "Handle",
    instruction: "Drag using the handle icon",
    order: 5,
    components: {
        draggable,
        AddHello,
    },
    data() {
        return {
            list: [],
            dragging: false,
            message: "",
        };
    },
    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    },
    mounted() {
        axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
            axios.get('http://localhost/api/hello').then(response => {
                this.list = response.data;
            }).catch(error => {
                if(error.response.status == 401){
                    this.$emit('loggedOut');
                }
            });
        });
    },
    methods: {
        // removeAt(idx) {
        //     this.list.splice(idx, 1);
        // },
        // editAt(idx) {
        //     console.log(this.list[idx]);
        // },
        // add: function() {
        //     id++;
        //     this.list.push({ name: "", id});
        // },
        postAddHello(e, hello){
            this.list.push(hello);
        },
        submitEditForm(idx, name){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.put('http://localhost/api/hello/' + this.list[idx].id, {
                    name: name,
                }).then(response => {
                    console.log(response.data);
                    this.message = response.data.name + ' updated!';
                    // this.$emit('updateHello', response.data);
                    // this.editHello = false;
                }).catch(error => {
                    console.log(error);
                    this.message = JSON.stringify(error);
                });
            });
        },
        deleteHello(idx){
            axios.get('http://localhost/sanctum/csrf-cookie').then(() => {
                axios.delete('http://localhost/api/hello/' + this.list[idx].id)
                    .then(() => {
                        this.list.splice(idx, 1);
                    })
                    .catch(error => {
                        console.log(error);
                        this.message = JSON.stringify(error);
                    });
            });

        }
    }
};
</script>
<!--<style scoped>-->
<!--.button {-->
<!--    margin-top: 35px;-->
<!--}-->
<!--.handle {-->
<!--    float: left;-->
<!--    padding-top: 8px;-->
<!--    padding-bottom: 8px;-->
<!--}-->

<!--.close {-->
<!--    float: right;-->
<!--    padding-top: 8px;-->
<!--    padding-bottom: 8px;-->
<!--}-->

<!--input {-->
<!--    display: inline-block;-->
<!--    width: 50%;-->
<!--}-->

<!--.text {-->
<!--    margin: 20px;-->
<!--}-->
<!--</style>-->
