<template>
<!--Body system-->
<div style="padding: 30px;" class="medium-10 border-right-line">
    <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
        <div class="large-12 medium-12 small-12 border-btm-line">
            <h5 class="BYekan black-color">داشبورد مدیریت مالی</h5>
        </div>
    </div>
</div>
</template>
<script>
    import LineChart from '../../charts/lineChart';
    import myUpload from 'vue-image-crop-upload';

    export default {
        data () {
            return {

            }
        },

        created: function(){

        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        methods: {
        }
    }
</script>
