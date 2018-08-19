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
                                <span class="show-for-sr">Current: </span>درخواست های دریافتی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <div class="float-left cost-label">
                    <span class="small-font"> مبالغ : {{costTemp}} </span>
                </div>
            </div>
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="80px"/>
                                <col width="400px"/>
                                <col width="300px"/>
                                <col width="200px"/>
                                <col width="150px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">وضعیت</th>
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">ارسال کننده</th>
                                <th class="tbl-head-style-cell">نوع درخواست</th>
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
                                    <col width="80px"/>
                                    <col width="400px"/>
                                    <col width="300px"/>
                                    <col width="200px"/>
                                    <col width="150px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getRequestDetail(receiveRequest)" v-for="receiveRequest in receiveRequests">
                                    <td></td>
                                    <td>{{receiveRequest.rSubject}}</td>
                                    <td>{{receiveRequest.rLastRef.source_user_info.name}} - {{receiveRequest.rLastRef.source_user_info.role.rSubject}}</td>
                                    <td v-if="receiveRequest.rRtId==1"> خدمات</td>
                                    <td v-else-if="receiveRequest.rRtId==2"> کالا</td>
                                    <td v-else="receiveRequest.rRtId==3"> تنخواه</td>
                                    <td>{{receiveRequest.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                    <td>{{receiveRequest.rLetterNumber}}</td>
                                    <td>{{receiveRequest.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Detail Modal -->
        <modal-large v-if="showRequestDetailModal" @close="showRequestDetailModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_tab_view">
                                <li class="tabs-title is-active"><a href="#requestDetailTab" aria-selected="true">جزییات درخواست</a></li>
                                <li class="tabs-title"><a href="#requestVerifiersTab">تایید کنندگان درخواست </a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه درخواست </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="requestDetailTab">
                                    <div class="grid-x">
                                        <div v-show="requestTypeDetail == 'SERVICES'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">مبلغ برآردی : </td>
                                                    <td>{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">  {{costTemp}}  </span></td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">شرح کامل خدمات : </td>
                                                    <td class="text-justify">{{requestFill.rDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">توضیحات تکمیلی : </td>
                                                    <td class="text-justify">{{requestFill.rFurtherDetails}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-show="requestTypeDetail == 'COMMODITY'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table>
                                                <thead>
                                                <th width="50">ردیف</th>
                                                <th>شرح و نوع جنس</th>
                                                <th width="100">تعداد</th>
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">({{costTemp}})</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(lists,index) in commodityList">
                                                    <td>{{index+1}}</td>
                                                    <td>{{lists.commodity.cSubject}}</td>
                                                    <td>{{lists.rcCount}}</td>
                                                    <td>{{lists.rcCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">{{  costTemp  }}</span> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">مبلغ برآردی : </td>
                                                    <td>{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">  {{costTemp}}  </span></td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">متن درخواست : </td>
                                                    <td class="text-justify">{{requestFill.rDescription}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="requestVerifiersTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div v-for="verifier in verifiers" class="large-12 medium-12 small-12 verifier-panel">
                                            <div class="grid-x">
                                                <div class="large-1 medium-1 small-12">
                                                    <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="$parent.imgDataUrl">
                                                </div>
                                                <div class="large-6 medium-6 small-12 small-top-m">
                                                    <p>{{verifier.user.name}}</p>
                                                    <p style="margin-top:-13px;color:#757575;" class="small-font">{{verifier.user.role.rSubject}}</p>
                                                </div>
                                                <div v-show="verifier.rvSId != null" style="direction: ltr;" class="large-5 medium-5 small-12 small-top-m">
                                                    <p class="user-verifier-label">تایید شده</p>
                                                    <p style="margin-bottom: 0;color:#9E9E9E;margin-top:-8px" class="small-font"><i class="far fa-calendar-alt"></i><span> 1397/05/28 </span> - <i class="far fa-clock"></i> <span>14:29</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 2-->
                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="requestHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                        <div class="large-12 medium-12 small-12 timeline-item">
                                            <div class="grid-x">
                                                <div class="large-3 medium-3 small-12">

                                                </div>
                                                <div class="large-7 medium-7 small-12 timeline-icon">
                                                    <img style="width: 57px;height: 57px;margin-top: 1px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="$parent.imgDataUrl">
                                                </div>
                                                <div class="large-7 medium-7 small-12 timeline-content">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12 timeline-content-header">
                                                            <p>{{recipientUser.destination_user_info.name}}</p>
                                                            <p style="margin-top:-10px;" class="small-font">{{recipientUser.destination_user_info.role.rSubject}}</p>
                                                            <span style="text-align: left" class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                        </div>
                                                        <div class="large-12 medium-12 small-12">
                                                            <p class="small-top-m text-justify">
                                                                {{recipientUser.rhDescription}}
                                                            </p>
                                                            <p style="direction: ltr;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.created_at}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.created_at}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="large-3 medium-3 small-12">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 3-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- Request Detail Modal -->
    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default {
        components: {Suggestions},
        "vue-select": require("vue-select"),
        data () {
            return {
                receiveRequests:[],
                costTemp:'',
                showRequestDetailModal:false,
                requestTypeDetail:'',
                requestFill:{},
                commodityList:[],
                recipientUsers:[],
                verifiers:[],



            }
        },

        created: function(){
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.costTemp =  '  ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            this.$parent.myResize();
        },

        methods: {

            fetchData: function (page=1) {
                axios.get('/financial/request/received/fetchData?page=' + page)
                    .then((response) => {
                        this.receiveRequests = response.data.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getRequestDetail: function (request) {
                this.showRequestDetailModal=true;
                this.recipientUsers=[];
                var requestHistory=[];
                requestHistory.push(request);
                console.log(JSON.stringify(requestHistory));
                requestHistory.forEach(users => {
                    users.history.forEach(userHistory => {
                        this.recipientUsers.push(userHistory);
                    });
                });

                requestHistory.forEach(users => {
                    users.verifiers.forEach(verify => {
                        this.verifiers.push(verify);
                    });
                });
                console.log(JSON.stringify(this.recipientUsers));
                if (request.rRtId == 1){
                    this.requestTypeDetail='SERVICES';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                    this.requestFill.rFurtherDetails=request.rFurtherDetails;
                }
                else if (request.rRtId == 2){
                    var commodityTemp=[];
                    commodityTemp.push(request);
                    this.commodityList=[];
                    this.requestTypeDetail='COMMODITY';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    commodityTemp.forEach(items => {
                        items.request_commodity.forEach(commodity => {
                            this.commodityList.push(commodity);
                        });
                    });
                }
                else if (request.rRtId == 3){
                    this.requestTypeDetail='FUND';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                }
            },


    }
}
</script>
