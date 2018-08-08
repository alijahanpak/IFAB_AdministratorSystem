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
                    <button style="width: 120px;" class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="insertDropDown">جدید</button>
                    <div  style="width: 120px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="insertDropDown" data-dropdown data-auto-focus="true">
                        <ul class="my-menu small-font">
                            <li v-for="submissionsTypes in submissionsType" :value="submissionsTypes.id"><a  @click="">{{ submissionsTypes.rtSubject }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data () {
            return {
                submissionsType:{},
            }
        },

        created: function(){
            this.fetchSubmissionsType();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        methods: {

            fetchSubmissionsType: function () {
                axios.get('/financial/request/types/fetchData')
                    .then((response) => {
                        this.submissionsType = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

        }
    }
</script>
