<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12">
                <p class="vue-select-label">{{pallasSelectLabel}}</p>
                <model-select
                        style="direction:rtl;text-align: right;border: 1px solid #cacaca;border-radius: 0px;color: #777777;font-size: small;line-height: 1.35"
                        :name="pallasSelectName"  v-validate data-vv-rules="required" :class="pallasSelectClass"
                        :options="pallasSelectOption"
                        v-model="pallasSelectModel"

                >
                </model-select>
                <span v-show="errors.has(pallasSelectName)" class="error-font">{{pallasSelectError}}</span>
        </div>
    </div>
</template>
<script>
    import { ModelSelect } from 'vue-search-select';
    export default{
        components:{
            ModelSelect,
        },
        props:['pallasSelectLabel','pallasSelectName','pallasSelectOption','pallasSelectModel','pallasSelectError','pallasSelectClass','pallasSelectV-validate'],
        data () {
            return {

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {
        },

        methods : {

        }
    }
</script>
