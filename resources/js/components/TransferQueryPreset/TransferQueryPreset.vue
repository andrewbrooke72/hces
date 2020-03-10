<template>
    <div>
        <select class="form-control" v-model="selected_preset">
            <option :value="null" disabled selected>Select Query Preset</option>
            <option v-for="preset in presets" :value="preset">{{ preset.name }}</option>
        </select>
        <br>
        <p class="text-muted" v-if="parse_query != null" v-html="parse_query"></p>
        <hr>
        <div v-if="final_query != null">
            <label>Final Query</label>
            <textarea style="width:100%;height:150px;" name="query" readonly="">{{ final_query }}</textarea>
        </div>
        <hr>
        <button v-if="parse_query != null" type="button" class="btn btn-primary" @click="transformQuery()">Transform
            query
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                presets: null,
                selected_preset: null,
                parse_query: null,
                final_query: null,
                shortcodes: [
                    {code: '<!ui_date!>', element: '<input class = "query-input" type = "datetime-local" required>'},
                    {
                        code: '<!ui_array!>',
                        element: '<input class = "query-input" type = "text" value = "a,b,c" required>'
                    },
                    {
                        code: '<!ui_string!>',
                        element: '<input class = "query-input" type = "text" value = "your value" required>'
                    }
                ]
            }
        },
        mounted() {
            this.loadPresets();
        },
        updated: function () {
        },
        computed: {},
        watch: {
            selected_preset: function (new_value) {
                var app = this;
                app.parse_query = null;
                app.final_query = null;
                var query = new_value.query;
                $.each(app.shortcodes, function (key, shortcode) {
                    query = query.replace(new RegExp(shortcode.code, 'g'), shortcode.element);
                });
                app.parse_query = query;
            }
        },
        methods: {
            loadPresets() {
                var app = this;
                $.get($('#query-presets-url').val(), function (data) {
                    app.presets = data;
                }).fail(function (error) {
                    console.error(error);
                });
            },
            transformQuery() {
                var app = this;
                var query = app.selected_preset.query;
                var values = [];
                $('.query-input').each(function (index, query_input) {
                    values.push($(query_input).val());
                });
                var short_codes = query.match(/(<!\S+)/g);
                $.each(short_codes, function (index, shortcode) {
                    var value = values[index];
                    if (shortcode == '<!ui_date!>') {
                        value = "'" + moment(value).format('YYYY-MM-DD HH:mm:ss') + "'";
                    }
                    query = query.replace(shortcode, value);
                });
                app.final_query = query;
            },

        }
    }
</script>