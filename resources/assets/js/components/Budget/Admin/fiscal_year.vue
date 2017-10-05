<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>سال مالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
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
                                <div class="grid-x" v-for="fiscalYear in fiscalYears">
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ fiscalYear.fyLabel }}</div>
                                    <div class="medium-4 table-contain-border cell-vertical-center">{{ fiscalYear.fyDescription }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    </div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                        <div v-show="fiscalYear.fyStatus == 0">
                                            <a @click="fyActiveModal = true"><i class="fi-checkbox size-21 edit-pencil"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="pagination"
                                                     v-on:click.native="fetchData(pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 1 End-->
                    <notifications group="tinySeasonPm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
            </div>
        </div>
        <!--modalFYActivate Start-->
        <modal-tiny v-if="fyActiveModal" @close="fyActiveModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">آیا مایل به فعال سازی سال مالی <span>.............</span>هستید؟</p>
                    <div class="grid-x">
                        <div class="medium-6 text-center">
                            <a class="button primary btn-large-w">بله</a>
                        </div>
                        <div class="medium-6 text-center">
                            <a class="button primary hollow btn-large-w">خیر</a>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                fiscalYears: [],
                fyActiveModal: false,
                pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },

        created: function () {
            this.fetchData();
        },

        mounted: function () {
            console.log("mounted fiscal year component");
            $(this.$el).foundation(); //WORKS!
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                this.$root.start();
                axios.get('/budget/admin/fiscal_year/fetchData?page=' + page)
                    .then((response) => {
                        this.fiscalYears = response.data.data;
                        this.makePagination(response.data);
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            makePagination: function(data){
                this.pagination.current_page = data.current_page;
                this.pagination.to = data.to;
                this.pagination.last_page = data.last_page;
            },

            getFiscalYearStatus: function (status) {
                if (status == 0)
                {
                    return 'غیر فعال';
                }
                else if (status == 1)
                {
                    return 'فعال';
                }
                else if (status == 2)
                {
                    return 'بسته شده';
                }
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'fiscalYearPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'fiscalYearPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
            }
        }
    }
</script>
