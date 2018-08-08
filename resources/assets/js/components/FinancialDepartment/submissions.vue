<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">کارتابل</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>درخواست های ارسالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <div style="margin-bottom: 0;" class="button-group float-right">
                        <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
                    </div>
                </div>
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
