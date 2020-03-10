<template>
    <div>
        <div class="input-group mb-3" v-for="(column, index) in columns">
            <input name="columns[]" type="text" class="form-control" placeholder="Column name" aria-label="Column name" aria-describedby="Column name">
            <div class="input-group-append" v-if="(index + 1) == columns.length">
                <button class="btn btn-primary" type="button" :id="index" @click="appendColumn(index)">Add Column</button>
            </div>
            <div class="input-group-append" v-if="index == (columns.length - 2)">
                <button class="btn btn-danger" type="button" :id="index" @click="removeColumn(index)">Remove Column</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                columns: [''],
            }
        },
        mounted(){
            console.log('Component mounted.');
        },
        updated: function () {
        },
        computed: {},
        watch: {},
        methods: {
            appendColumn(name){
                var app = this;
                app.columns.push(name);
            },
            removeColumn(index){
                var app = this;
                app.columns.splice(index, 1);
            }
        }
    }
</script>