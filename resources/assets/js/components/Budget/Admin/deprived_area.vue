<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li> <a class="disabled">مدیریت</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مناطق محروم
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="deprived_area">
                    <li class="tabs-title is-active"><a href="#province" aria-selected="true">استان</a></li>
                    <li class="tabs-title"><a href="#county">شهرستان</a></li>
                    <li class="tabs-title"><a href="#region">بخش</a></li>
                    <li class="tabs-title"><a href="#rural_district">دهستان</a></li>
                    <li class="tabs-title"><a href="#village">روستا</a></li>
                </ul>
                <div class="medium-12 padding-lr" style="margin-top: 15px;">
                    <div class="clearfix border-btm-line tool-bar">
                        <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                            <a class="my-button toolbox-btn small" @click="showInsertModal = true;">جدید</a>
                            <a class="my-button toolbox-btn small">گزارش</a>
                        </div>
                        <div class="float-left">
                            <div class="input-group float-left">
                                <input class="input-group-field small-font" type="text">
                                <div class="input-group-button">
                                    <button type="button" class="my-button my-brand"><i class="fi-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs-content" data-tabs-content="deprived_area">
                    <!-- province tab content-->
                    <div class="tabs-panel is-active table-mrg-btm" id="province">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-2 table-border">
                                    <strong>شهرستان</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>بخش</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>دهستان</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>روستا</strong>
                                </div>
                                <div class="medium-4 table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-4 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">

                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown"><img width="15px" height="15px"  src=""></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- county tab-->
                    <div class="tabs-panel table-mrg-btm" id="county">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-4 table-border">
                                    <strong>نام</strong>
                                </div>
                                <div class="medium-8 table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-4 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-8 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">

                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown_county"><img width="15px" height="15px"  src=""></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown_county" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- region tab-->
                    <div class="tabs-panel table-mrg-btm" id="region">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-3 table-border">
                                    <strong>نام</strong>
                                </div>
                                <div class="medium-3 table-border">
                                    <strong>شهرستان</strong>
                                </div>
                                <div class="medium-6 table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-3 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-3 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-6 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">

                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown_region"><img width="15px" height="15px"  src=""></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown_region" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- rural district tab -->
                    <div class="tabs-panel table-mrg-btm" id="rural_district">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-2 table-border">
                                    <strong>نام</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>شهرستان</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>بخش</strong>
                                </div>
                                <div class="medium-6 table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-6 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">

                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown_ruralDistrict"><img width="15px" height="15px"  src=""></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown_ruralDistrict" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- village district tab -->
                    <div class="tabs-panel table-mrg-btm" id="village">
                        <div class="columns">
                            <!--Header Start-->
                            <div class="grid-x table-header">
                                <div class="medium-2 table-border">
                                    <strong>نام</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>شهرستان</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>بخش</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>دهستان</strong>
                                </div>
                                <div class="medium-4 table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                            <!--Header End-->
                            <div class="table-contain dynamic-height-level2">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                    <div class="medium-4 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">

                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown_village"><img width="15px" height="15px"  src=""></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown_village" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------->
            <notifications group="deprivedAreaPm"
                           position="bottom right"
                           animation-type="velocity"
                           :speed="700" />
        </div>
        <!-- modalFYActivate Start -->
        <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createTinySeason">
                    <div class="grid-x" id="existErrorInRegForm" style="display: none">
                        <div class="medium-12 columns padding-lr">
                            <div class="alert callout">
                                <p class="BYekan login-alert"><i class="fi-alert"></i> این منطقه محروم قبلا ثبت شده است!</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>شهرستان
                                <select name="daCounty" id="selectCounty" required>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </label>
                            <span class="form-error error-font" data-form-error-for="selectCounty">شهرستان را انتخاب کنید!</span>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>بخش
                                <select name="daRegion" id="selectRegion" disabled>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>دهستان
                                <select name="daRuralDistrict" id="selectRuralDistrict" disabled>
                                </select>
                            </label>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>روستا
                                <select name="daVillage" id="selectVillage" disabled>
                                </select>
                            </label>

                        </div>
                    </div>
                    <div class="medium-6 columns padding-lr">
                        <label>شرح
                            <textarea name="daDescription" id="daDescription" style="min-height: 150px;"></textarea>
                        </label>
                    </div>

                    <div class="medium-6 columns padding-lr">
                        <button name="daFormSubmit" type="submit" class="my-secondary button float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- modalFyActivate end -->

        <!-- Modal Permission Start -->
        <modal-large v-if="showChangePermissionDialog" @close="showChangePermissionDialog = false">
            <div  slot="body">

            </div>
        </modal-large>
        <!-- Modal Permission End-->
    </div>
</template>
<script>
    export default {
        data(){
            return {
                showInsertModal: false,
            }
        },

        created: function () {
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted deprived area component");
            res();
        },

        methods:{
            fetchData: function () {
/*                this.$root.start();
                axios.get('/budget/admin/fiscal_year/fetchData?page=' + page)
                    .then((response) => {
                        this.fiscalYears = response.data.data;
                        this.makePagination(response.data);
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });*/
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
