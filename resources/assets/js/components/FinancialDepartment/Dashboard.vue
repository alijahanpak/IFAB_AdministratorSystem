<template>
<!--Body system-->
<div style="padding: 30px;" class="medium-10 border-right-line main-margin">
    <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
        <div class="medium-12 border-btm-line">
            <h5 class="BYekan black-color">داشبورد مدیریت مالی</h5>
        </div>
    </div>
</div>
</template>
<script>
    import LineChart from '../../charts/lineChart'

    export default {
        components: {
            LineChart
        },
        data () {
            return {
            }
        },

        created: function(){
        },

        beforeDestroy: function () {

        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        methods: {

        }
    }
</script>
