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
                            <li v-for="submissionsTypes in submissionsType" :value="submissionsTypes.id"><a  @click="openSubmissionsModal(submissionsTypes)">{{ submissionsTypes.rtSubject }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="590px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">قیمت</th>
                                <th class="tbl-head-style-cell">شماره</th>
                                <th class="tbl-head-style-cell">تاریخ</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="590px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr v-for="allSubmissions in submissions">
                                    <td>{{allSubmissions.rSubject}}</td>
                                    <td>{{allSubmissions.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                    <td>{{allSubmissions.rLetterNumber}}</td>
                                    <td>{{allSubmissions.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submission Buy Service Modal -->
        <modal-large v-if="showBuyCommodityModal" @close="showBuyCommodityModal = false">
            <div  slot="body">
                <form>
                    <div class="small-font">
                        <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="commodity_tab_view">
                            <li class="tabs-title is-active"><a href="#reciverTab" aria-selected="true">دریافت کنندگان</a></li>
                            <li class="tabs-title"><a href="#commodityTab">فرم درخواست کالا</a></li>
                        </ul>
                        <div class="tabs-content" data-tabs-content="commodity_tab_view">
                            <!--Tab 1-->
                            <div class="tabs-panel is-active table-mrg-btm" id="reciverTab">
                                <div class="grid-x">
                                    <div v-for="recipientsGroup in recipients"  class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div class="large-4 medium-4 small-12"></div>
                                            <div class="large-4 medium-4 small-12">
                                                <label>{{recipientsGroup.category.cSubject}}
                                                   <!-- <v-selectpage style="font-family: BYekan" class="form-control"
                                                                  :data="recipientsGroup.category.role_category[0].role.user"
                                                                  show-field="name"
                                                                  sort="name desc"
                                                                  language="en"
                                                                  placeholder="انتخاب کنید"
                                                                  @values="singleValues">
                                                    </v-selectpage>-->
                                                    <select class="form-element-margin-btm"  name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                                        <option value=""></option>
                                                        <template v-for="rolCat in recipientsGroup.category.role_category">
                                                            <option v-for="users in rolCat.role.user" :value="users.id" >{{users.name}} - {{rolCat.role.rSubject}}</option>
                                                        </template>

                                                    </select>
                                                </label>
                                            </div>
                                            <div class="large-4 medium-4 small-12"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Tab 1-->

                            <!--Tab 2-->
                            <div class="tabs-panel table-mrg-btm" id="commodityTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                <div style="margin-top: 25px" class="grid-x">
                                    <div class="large-12 medium-12 small-12 padding-lr">
                                        <table class="stack">
                                            <thead>
                                            <tr style="color: #575962;">
                                                <th width="50">ردیف</th>
                                                <th>شرح و نوع جنس</th>
                                                <th width="100">تعداد</th>
                                                <th width="150">مبلغ برآوری</th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(commodityRequests,index) in commodityRequest">
                                                <td>{{index+1}}</td>
                                                <td>{{commodityRequests.commodityName}}</td>
                                                <td>{{commodityRequests.commodityCount}}</td>
                                                <td>{{commodityRequests.commodityPrice}}</td>
                                                <td>{{commodityRequests.commodityDescription}}</td>
                                                <td class="text-center"><a @click="deleteCommodityItem(index)"><i class="far fa-trash-alt btn-red size-18"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <suggestions style="margin-bottom: -18px;" name="commodityTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('commodityTitle')}"
                                                                 v-model="commodityQuery"
                                                                 :options="commodityOptions"
                                                                 :onInputChange="onCommodityInputChange">
                                                        <div slot="item" slot-scope="props" class="single-item">
                                                            <strong>{{props.item}}</strong>
                                                        </div>
                                                    </suggestions>
                                                    <span v-show="errors.has('commodityTitle')" class="error-font">لطفا عنوان کالای مورد نظر را وارد کنید!</span>
                                                </td>
                                                <td>
                                                    <input id="number" v-model="commodityItem.commodityCount" class="text-margin-btm" type="number" value="1">
                                                </td>
                                                <td>
                                                    <money v-model="commodityItem.commodityPrice"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('price')}"></money>
                                                </td>
                                                <td>
                                                    <input v-model="commodityItem.commodityDescription" class="text-margin-btm" type="text">
                                                </td>
                                                <td class="text-center"><a v-if="commodityQuery != '' && commodityItem.commodityCount != '' && commodityItem.commodityPrice" @click="addCommodityItem()"><i class="fas fa-check btn-green size-18"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-center font-wei-bold">مجموع برآورد</td>
                                                <td colspan="2" class="text-center font-wei-bold">{{sumOfCommodityPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--Tab 2-->
                        </div>
                    </div>
                </form>
            </div>
        </modal-large>
        <!-- Submission Buy Service Modal -->
    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default {
        components: {Suggestions},
        "vue-select": require("vue-select"),
        data () {
            return {
                attachments: [],
                // Each file will need to be sent as FormData element
                data: new FormData(),
                percentCompleted: 0, // You can store upload progress 0-100 in value, and show it on the screen
                submissionsType:{},
                submissions:[],
                commodity:[],
                recipients:[],
                requestInput:{},
                showBuyServiceModal:false,
                showBuyCommodityModal:false,
                showFundModal:false,
                //commodity input text
                commodityQuery: '',
                commodityList: [],
                selectedCommodity: null,
                commodityOptions: {},
                //commodity input text
                money: {
                    thousands: ',',
                    precision: '',
                    masked: true
                },
                commodityItem:{},
                commodityRequest:[],
                sumOfCommodityPrice:0,
                convertCommodityPrice:'',
                requestTypeSend:'',
                recipientsUsers:[],
                recIndex1:'',


            }
        },

        created: function(){
            this.fetchData();
            this.fetchSubmissionsType();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            this.$parent.myResize();
        },

        methods: {

            fetchData: function (page=1) {
                axios.get('/financial/request/posted/fetchData?page=' + page)
                    .then((response) => {
                        this.submissions = response.data.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchSubmissionsType: function () {
                axios.get('/financial/request/types/fetchData')
                    .then((response) => {
                        this.submissionsType = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchRecipientsGroup: function () {
                axios.get('/financial/request/steps/fetchData', {params:{requestType:this.requestTypeSend}})
                    .then((response) => {
                        this.recipients = response.data;

                        /*this.recipients.forEach(rec=> {
                            rec.category.role_category.forEach(role_category =>{
                                role_category.role.user.forEach(user=>{
                                    this.recipientsUsers.push(user.id);
                                });
                            });
                        });

                        console.log(JSON.stringify(this.recipientsUsers));*/
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            /*-----------------------------------------------------------------------------
            ------------------ Commodity search Item Start ------------------------------
            -----------------------------------------------------------------------------*/
            fetchCommodity: function () {
                axios.get('/financial/commodity/fetchData')
                    .then((response) => {
                        this.commodity = response.data;
                        this.commodityList= [];
                        this.commodity.forEach(subject=> {
                            this.commodityList.push(subject.cSubject)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            onCommodityInputChange(commodityQuery) {
                if (commodityQuery.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.commodityList.filter((commodityes) => {
                    return commodityes.toLowerCase().includes(commodityQuery.toLowerCase())
                })
            },
            onCommoditySelected(item) {
                this.selectedCommodity = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ Commodity search Item End ------------------------------
            -----------------------------------------------------------------------------*/

            openSubmissionsModal: function (st) {
                this.requestTypeSend=st.rtType;
                this.fetchRecipientsGroup();
                switch (st.id){
                    case 1:
                        this.showBuyServiceModal=true;
                        break;

                    case 2:
                        this.showBuyCommodityModal=true;
                        this.fetchCommodity();
                        this.sumOfCommodityPrice=0;
                        break;

                    case 3:
                        this.showFundModal=true;
                        this.fetchCommodity();
                        break;

                }
            },

            addCommodityItem: function () {

                this.commodityItem.commodityName=this.commodityQuery;
                this.commodityRequest.push(this.commodityItem);
                console.log(JSON.stringify(this.commodityRequest));
                this.commodityQuery='';
                this.commodityItem={};
                this.commodityRequest.forEach(sum => {
                    var temp;
                    temp=sum.commodityPrice.replace(',','');
                    this.sumOfCommodityPrice+=parseInt(temp,10);

                });

            },

            deleteCommodityItem: function (index) {
                this.commodityRequest.splice(index,1);
            },

            createRequest: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        //var formData = new FormData(this.newCarInput);
                        var config = {
                            headers: {'Content-Type': 'multipart/form-data'},
                            onUploadProgress: function (progressEvent) {
                                this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                                this.$forceUpdate();
                            }.bind(this)
                        };
                        //this.prepareFields();
                    }
                });

            },



        }
    }
</script>
