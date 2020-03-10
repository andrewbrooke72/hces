<template>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="dupe-check">Dupe checking</label>
            <select id="dupe-check" name="dupe_method" class="form-control" v-model="selected_method" required>
                <option v-for="(dupe_method, index) in dupe_check_methods" :value="dupe_method.code">{{ dupe_method.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-12" v-if="selected_method == 'dupgroup'">
            <label for="dupe-check-group">Dupe Check in group</label>
            <select id="dupe-check-group" name="dupe_check_groups[]" class="form-control" multiple required>
                <option v-for="(list, index) in group_lists" :value="list.id">{{ list.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-6" v-if="selected_method != 'none'">
            <label for="dupe-check-date-from">Date From</label>
            <input type="date" class="form-control" name="dupe_check_date_range[]" id="dupe-check-date-from" required>
        </div>
        <div class="form-group col-md-6" v-if="selected_method != 'none'">
            <label for="dupe-check-date-to">Date To</label>
            <input type="date" class="form-control" name="dupe_check_date_range[]" id="dupe-check-date-to" required>
        </div>
        <div class="form-group col-md-12" v-if="selected_method != 'none'">
            <label for="list-option">List Option</label>
            <select id="list-option" name="list_option" class="form-control" required>
                <option value="" selected disabled>Select option</option>
                <option value="list_used">List used</option>
                <option value="list_non_used">List none used</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                dupe_check_methods: [
                    {name: 'NO DUPLICATE CHECK', code: 'none'},
                    {name: 'CURRENT LIST', code: 'currlist'},
                    {name: 'LISTS IN A PARTICULAR GROUP', code: 'dupgroup'},
                ],
                group_lists: null,
                selected_method: 'none',
            }
        },
        mounted(){
            console.log('Component dupe check mounted.');
            this.loadListGroups();
        },
        updated: function () {
        },
        computed: {},
        watch: {},
        methods: {
            loadListGroups(){
                var app = this;
                $.get('/vue/dupecheck/groups', function (response) {
                    app.group_lists = response;
                }).fail(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
