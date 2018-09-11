<template xmlns:v-on="http://www.w3.org/1999/xhtml">

</template>
<script>

    export default{
        props:['requestTypeDetail','requestFill','commodityList'],
        data () {
            return {
                commodityCountInput:{},
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
