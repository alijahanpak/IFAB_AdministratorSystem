<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="">داشبورد</a></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>ریز فصول
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <div class="dynamicParentId1">
                    <!--Tab 1 Start-->
                    <div class="tabs-panel is-active table-mrg-btm">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-2 table-border">
                                    <strong>سال مالی</strong>
                                </div>
                                <div class="medium-4 table-border">
                                    <strong>شرح</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>وضعیت</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>مجوزها</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>فعالسازی</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-4 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    </div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 1 End-->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
            }
        },

        created: function () {
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
/*                this.$root.start();
                axios.get('/budget/admin/sub_seasons/fetchData?page=' + page , {params:{planOrCost: 0}})
                    .then((response) => {
                        this.tinySeasons = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });*/
            },

            makePagination: function(data , type){
                if (type == "cost")
                {
                    this.cost_pagination.current_page = data.current_page;
                    this.cost_pagination.to = data.to;
                    this.cost_pagination.last_page = data.last_page;
                }else if (type == "plan")
                {
                    this.plan_pagination.current_page = data.current_page;
                    this.plan_pagination.to = data.to;
                    this.plan_pagination.last_page = data.last_page;
                }
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
            },
        }
    }
</script>
