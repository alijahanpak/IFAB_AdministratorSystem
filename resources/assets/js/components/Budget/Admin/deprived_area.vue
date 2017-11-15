<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
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
                        <div style="margin-top: 2px;" class="button-group float-right">
                            <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
                            <a class="my-button toolbox-btn small">گزارش</a>
                        </div>
                    </div>
                </div>
                <div class="tabs-content" data-tabs-content="deprived_area">
                    <!-- province tab content-->
                    <div class="tabs-panel is-active table-mrg-btm" id="province">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="240px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">بخش</th>
                                        <th class="tbl-head-style-cell">دهستان</th>
                                        <th class="tbl-head-style-cell">روستا</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="240px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                        <tr v-for="da in deprivedArea">
                                            <td>{{ da.county.coName }}</td>
                                            <td>{{ da.region == null ? '&#45;&#45;' : da.region.reName }}</td>
                                            <td>{{ da.rural_district == null ? '&#45;&#45;' : da.rural_district.rdName }}</td>
                                            <td>{{ da.village == null ? '&#45;&#45;' : da.village.viName }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ da.daDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'daActionDropdown' + da.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'daActionDropdown' + da.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a @click="openUpdateModal(da)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a @click="openDeleteModal(da.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- county tab-->
                    <div class="tabs-panel table-mrg-btm" id="county">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="450px"/>
                                    <col width="390px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">نام</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="450px"/>
                                        <col width="390px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <template v-for="da in deprivedArea">
                                        <tr v-if="da.daReId == null">
                                            <td>{{ da.county.coName }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ da.daDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'daActionDropdown_county' + da.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'daActionDropdown_county' + da.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a @click="openUpdateModal(da)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a @click="openDeleteModal(da.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- region tab-->
                    <div class="tabs-panel table-mrg-btm" id="region">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="250px"/>
                                    <col width="250px"/>
                                    <col width="340px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">نام</th>
                                    <th class="tbl-head-style-cell">شهرستان</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="250px"/>
                                        <col width="250px"/>
                                        <col width="340px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <template v-for="da in deprivedArea">
                                        <tr v-if="da.daReId != null && da.daRdId == null">
                                            <td>{{ da.region.reName }}</td>
                                            <td>{{ da.county.coName }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ da.daDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'daActionDropdown_region' + da.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'daActionDropdown_region' + da.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a @click="openUpdateModal(da)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a @click="openDeleteModal(da.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- rural district tab -->
                    <div class="tabs-panel table-mrg-btm" id="rural_district">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="240px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">نام</th>
                                    <th class="tbl-head-style-cell">شهرستان</th>
                                    <th class="tbl-head-style-cell">بخش</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="240px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <template v-for="da in deprivedArea">
                                        <tr v-if="da.daRdId != null && da.daViId == null">
                                            <td>{{ da.rural_district.rdName }}</td>
                                            <td>{{ da.county.coName }}</td>
                                            <td>{{ da.region.reName }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ da.daDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'daActionDropdown_ruralDistrict' + da.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'daActionDropdown_ruralDistrict' + da.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a @click="openUpdateModal(da)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a @click="openDeleteModal(da.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- village district tab -->
                    <div class="tabs-panel table-mrg-btm" id="village">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="240px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">نام</th>
                                    <th class="tbl-head-style-cell">شهرستان</th>
                                    <th class="tbl-head-style-cell">بخش</th>
                                    <th class="tbl-head-style-cell">دهستان</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="240px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <template v-for="da in deprivedArea">
                                        <tr v-if="da.daViId != null">
                                            <td>{{ da.village.viName }}</td>
                                            <td>{{ da.county.coName }}</td>
                                            <td>{{ da.region.reName }}</td>
                                            <td>{{ da.rural_district.rdName }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ da.daDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'daActionDropdown_village' + da.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'daActionDropdown_village' + da.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a @click="openUpdateModal(da)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a @click="openDeleteModal(da.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------->
        </div>
        <!-- modal insert Start -->
        <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createDeprivedArea">
                    <div class="grid-x" style="display: none">
                        <div class="medium-12 columns padding-lr">
                            <div class="alert callout">
                                <p class="BYekan login-alert"><i class="fi-alert"></i> این منطقه محروم قبلا ثبت شده است!</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>شهرستان
                                <select class="form-element-margin-btm" v-model="deprivedAreaInput.county" @change="getRegions(deprivedAreaInput.county)" autocomplete="off" name="daCounty" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('daCounty')}">
                                    <option value=""></option>
                                    <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                </select>
                                <span v-show="errors.has('daCounty')" class="error-font">شهرستان را انتخاب کنید!</span>
                            </label>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>بخش
                                <select class="form-element-margin-btm" v-model="deprivedAreaInput.region" @change="getRuralDistricts(deprivedAreaInput.region)" autocomplete="off" :disabled="regionDisable">
                                    <option value=""></option>
                                    <option v-for="region in regions" :value="region.id">{{ region.reName }}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>دهستان
                                <select class="form-element-margin-btm" v-model="deprivedAreaInput.ruralDistrict" @change="getVillages(deprivedAreaInput.ruralDistrict)" autocomplete="off" :disabled="ruralDistrictDisable">
                                    <option value=""></option>
                                    <option v-for="ruralDistrict in ruralDistricts" :value="ruralDistrict.id">{{ ruralDistrict.rdName }}</option>
                                </select>
                            </label>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>روستا
                                <select class="form-element-margin-btm" v-model="deprivedAreaInput.village" autocomplete="off" :disabled="villageDisable">
                                    <option value=""></option>
                                    <option v-for="village in villages" :value="village.id">{{ village.viName }}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="medium-6 columns padding-lr">
                        <label>شرح
                            <textarea name="daDescription" v-model="deprivedAreaInput.description" style="min-height: 150px;"></textarea>
                        </label>
                    </div>

                    <div class="medium-6 columns padding-lr">
                        <button name="daFormSubmit" type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- modalF insert end -->
        <modal-tiny v-if="showUpdateModal" @close="showUpdateModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="updateDeprivedArea">
                    <div class="grid-x" style="display: none">
                        <div class="medium-12 columns padding-lr">
                            <div class="alert callout">
                                <p class="BYekan login-alert"><i class="fi-alert"></i> این منطقه محروم قبلا ثبت شده است!</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>شهرستان
                                <select class="form-element-margin-btm" v-model="deprivedAreaFill.county" @change="getRegions(deprivedAreaFill.county)" autocomplete="off" name="daCounty" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('daCounty')}">
                                    <option value=""></option>
                                    <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                </select>
                                <span v-show="errors.has('daCounty')" class="error-font">شهرستان را انتخاب کنید!</span>
                            </label>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>بخش
                                <select class="form-element-margin-btm" v-model="deprivedAreaFill.region" @change="getRuralDistricts(deprivedAreaFill.region)" autocomplete="off" :disabled="regionDisable">
                                    <option value=""></option>
                                    <option v-for="region in regions" :value="region.id">{{ region.reName }}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>دهستان
                                <select class="form-element-margin-btm" v-model="deprivedAreaFill.ruralDistrict" @change="getVillages(deprivedAreaFill.ruralDistrict)" autocomplete="off" :disabled="ruralDistrictDisable">
                                    <option value=""></option>
                                    <option v-for="ruralDistrict in ruralDistricts" :value="ruralDistrict.id">{{ ruralDistrict.rdName }}</option>
                                </select>
                            </label>
                        </div>
                        <div class="medium-6 cell padding-lr">
                            <label>روستا
                                <select class="form-element-margin-btm" v-model="deprivedAreaFill.village" autocomplete="off" :disabled="villageDisable">
                                    <option value=""></option>
                                    <option v-for="village in villages" :value="village.id">{{ village.viName }}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="medium-6 columns padding-lr">
                        <label>شرح
                            <textarea name="daDescription" v-model="deprivedAreaFill.description" style="min-height: 150px;"></textarea>
                        </label>
                    </div>
                    <div class="medium-6 columns padding-lr">
                        <button name="daFormSubmit" type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- Modal update Start -->
        <!-- Delete Modal Start -->
        <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
            <div  slot="body">
                <div class="small-font">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deleteDeprivedArea" class="my-button my-success"><span class="btn-txt-mrg"> تایید </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Delete Modal End -->
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                deprivedArea: [],
                deprivedAreaFill: {},
                deprivedAreaInput: {county: '' , region: '' , ruralDistrict: '' , village: '' , description: ''},
                counties: [],
                regions: [],
                ruralDistricts: [],
                villages: [],
                regionDisable: true,
                ruralDistrictDisable: true,
                villageDisable: true,
                daIdForDelete: '',
            }
        },

        created: function () {
            this.fetchData();
            this.getCounties();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted deprived area component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/admin/deprived_area/fetchData?page=' + page)
                    .then((response) => {
                        this.deprivedArea = response.data;
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            createDeprivedArea: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/deprived_area/register' , {
                            county: this.deprivedAreaInput.county ,
                            region: this.deprivedAreaInput.region ,
                            ruralDistrict: this.deprivedAreaInput.ruralDistrict ,
                            village: this.deprivedAreaInput.village ,
                            description: this.deprivedAreaInput.description})
                            .then((response) => {
                                this.deprivedArea = response.data;
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                this.deprivedAreaInput = [];
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            getCounties: function () {
                axios.get('/admin/get_all_counties')
                    .then((response) => {
                        this.counties = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getRegions: function (coId) {
                if (coId != "" && coId != null)
                {
                    axios.get('/admin/getCountyRegions' , {params:{coId: coId}})
                        .then((response) => {
                            this.regions = response.data;
                            this.regionDisable = false;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else{
                    this.regionDisable = true;
                    this.ruralDistrictDisable = true;
                    this.villageDisable = true;
                    this.deprivedAreaInput.region = '';
                    this.deprivedAreaInput.ruralDistrict = '';
                    this.deprivedAreaInput.village = '';

                    this.deprivedAreaFill.region = '';
                    this.deprivedAreaFill.ruralDistrict = '';
                    this.deprivedAreaFill.village = '';
                }
            },

            getRuralDistricts: function (reId) {
                if (reId != "" && reId != null)
                {
                    axios.get('/admin/getRuralDistrictByRegionId' , {params:{reId: reId}})
                        .then((response) => {
                            this.ruralDistricts = response.data;
                            this.ruralDistrictDisable = false;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else{
                    this.ruralDistrictDisable = true;
                    this.villageDisable = true;
                    this.deprivedAreaInput.ruralDistrict = '';
                    this.deprivedAreaInput.village = '';

                    this.deprivedAreaFill.ruralDistrict = '';
                    this.deprivedAreaFill.village = '';
                }
            },

            getVillages: function (rdId) {
                if (rdId != "" && rdId != null)
                {
                    axios.get('/admin/getVillagesByRuralDistrictId' , {params:{rdId: rdId}})
                        .then((response) => {
                            this.villages = response.data;
                            this.villageDisable = false;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else{
                    this.villageDisable = true;
                    this.deprivedAreaInput.village = '';

                    this.deprivedAreaFill.village = '';
                }
            },

            openInsertModal: function () {
                this.deprivedAreaInput = [];
                this.regionDisable = true;
                this.ruralDistrictDisable = true;
                this.villageDisable = true;
                this.getCounties();
                this.showInsertModal = true;
            },

            openUpdateModal: function (depArea) {
                this.deprivedAreaFill = [];
                this.regionDisable = true;
                this.ruralDistrictDisable = true;
                this.villageDisable = true;
                this.showUpdateModal = true;
                this.getCounties();
                this.deprivedAreaFill.id = depArea.id;
                this.deprivedAreaFill.county = depArea.daCoId;
                this.getRegions(depArea.daCoId);
                this.deprivedAreaFill.region = depArea.daReId;
                this.getRuralDistricts(depArea.daReId);
                this.deprivedAreaFill.ruralDistrict = depArea.daRdId;
                this.getVillages(depArea.daRdId);
                this.deprivedAreaFill.village = depArea.daViId;
                this.deprivedAreaFill.description = depArea.daDescription;
            },

            openDeleteModal: function (daId) {
                this.showDeleteModal = true;
                this.daIdForDelete = daId;
            },

            updateDeprivedArea: function(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/deprived_area/update' , {
                            id: this.deprivedAreaFill.id,
                            county: this.deprivedAreaFill.county ,
                            region: this.deprivedAreaFill.region ,
                            ruralDistrict: this.deprivedAreaFill.ruralDistrict ,
                            village: this.deprivedAreaFill.village ,
                            description: this.deprivedAreaFill.description})
                        .then((response) => {
                        this.deprivedArea = response.data;
                        this.showUpdateModal = false;
                        this.$parent.displayNotif(response.status);
                        this.deprivedAreaFill = [];
                        console.log(response);
                    },(error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            deleteDeprivedArea: function () {
                axios.post('/budget/admin/deprived_area/delete' , {
                            id: this.daIdForDelete})
                    .then((response) => {
                    if (response.status != 204)
                        this.deprivedArea = response.data;
                    this.showDeleteModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.showDeleteModal = false;
                });
            }
        }
    }
</script>
