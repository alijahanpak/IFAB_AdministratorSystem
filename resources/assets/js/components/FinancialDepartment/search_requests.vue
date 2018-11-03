<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad">
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
                                <span class="show-for-sr">Current: </span>جستجو
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <div class="float-left">
                        <div class="input-group float-left">
                            <div class="inner-addon right-addon">
                                <i v-if="requestSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                <i v-if="requestSearchValue != ''" v-on:click.stop="removeFilter()" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                <input v-model="requestSearchValue" v-on:keyup.enter="search()" class="search" type="text" placeholder="جستجو">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="400px"/>
                                <col width="200px"/>
                                <col width="150px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">نوع درخواست</th>
                                <th class="tbl-head-style-cell">مبلغ <span class="btn-red small-font">(ریال)</span></th>
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
                                    <col width="400px"/>
                                    <col width="200px"/>
                                    <col width="150px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getRequestDetail(allRequest)" v-for="allRequest in allRequests">
                                    <td>{{allRequest.rSubject}}</td>
                                    <td class="text-center" v-if="allRequest.rRtId==1"> خدمات</td>
                                    <td class="text-center" v-else-if="allRequest.rRtId==2"> کالا</td>
                                    <td class="text-center" v-else="allRequest.rRtId==3"> تنخواه</td>
                                    <td class="text-center">{{$parent.dispMoneyFormat(allRequest.rCostEstimation)}}</td>
                                    <td class="text-center">{{allRequest.rLetterNumber}}</td>
                                    <td class="text-center">{{allRequest.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <vue-pagination  v-bind:pagination="result_pagination"
                                             v-on:click.native="fetchData(result_pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
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
                                <li class="tabs-title is-active"><a href="#requestDetailTab" aria-selected="true">جزییات</a></li>
                                <li class="tabs-title"><a href="#draftTab">حواله </a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                                <li class="tabs-title"><a href="#requestAttachmentsTab">پیوست ها </a></li>
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
                                                    <td width="150px">مبلغ برآورد : </td>
                                                    <td>{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
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
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(lists,index) in commodityList">
                                                    <td>{{index+1}}</td>
                                                    <td>{{lists.commodity.cSubject}}</td>
                                                    <td>{{lists.rcCount - lists.rcExistCount}}</td>
                                                    <td>{{$parent.dispMoneyFormat(lists.rcCostEstimation)}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span> </td>
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
                                                    <td width="150px">مبلغ برآورد : </td>
                                                    <td>{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
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
                                <div class="tabs-panel table-mrg-btm" id="draftTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rDraft  v-on:closeModal="showRequestDetailModal=false"
                                             v-on:updateReceiveRequestData="updateReceiveRequestData"
                                             v-bind:requestId="requestId"
                                             v-bind:contracts="contracts"
                                             v-bind:factors="factors"
                                             v-bind:rAcceptedAmount="rAcceptedAmount"
                                             v-bind:rCommitmentAmount="rCommitmentAmount"
                                             v-bind:requestType="requestType"
                                             v-bind:drafts="drafts"
                                             v-bind:sumOfDraftAmount="rSumOfDraftAmount"
                                             v-bind:lastRefDId="lastRefDId"
                                             v-bind:resultType="'SEARCH'"
                                             v-bind:searchValue="requestSearchValue">
                                    </rDraft>
                                </div>
                                <!--Tab 2-->
                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="requestHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 large-top-m">
                                            <div style="margin-top:-50px;" v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                                <div class="large-12 medium-12 small-12 timeline-item">
                                                    <div class="grid-x">
                                                        <div class="large-3 medium-3 small-12">

                                                        </div>
                                                        <div class="large-7 medium-7 small-12 timeline-icon">
                                                            <img style="width: 57px;height: 57px;margin-top: 1px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.source_user_info.avatarPath != null ? baseURL + recipientUser.source_user_info.avatarPath : $parent.baseAvatar">
                                                        </div>
                                                        <div class="large-7 medium-7 small-12 timeline-content">
                                                            <div class="grid-x">
                                                                <div class="large-12 medium-12 small-12 timeline-content-header">
                                                                    <p>{{recipientUser.source_user_info.name}}</p>
                                                                    <p style="margin-top:-13px;margin-bottom: -5px;" class="small-font">{{recipientUser.source_user_info.role.rSubject}}</p>
                                                                    <span class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                                </div>
                                                                <div class="large-12 medium-12 small-12">
                                                                    <p class="small-top-m text-justify gray-colors">
                                                                        {{recipientUser.rhDescription}}
                                                                    </p>
                                                                    <div v-if="recipientUser.destination_user_info != null && requestState != 'WAITING_FOR_PAY_REQUEST'">
                                                                        <p v-if="recipientUser.source_user_info.id != recipientUser.destination_user_info.id" style="margin-bottom: 0" class="small-top-m">گیرنده:</p>
                                                                        <div v-if="recipientUser.source_user_info.id != recipientUser.destination_user_info.id" class="grid-x">
                                                                            <div class="large-1 medium-2 small-12">
                                                                                <img style="width: 40px;height: 40px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.destination_user_info.avatarPath != null ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
                                                                            </div>
                                                                            <div class="large-11 medium-10 small-12 padding-lr">
                                                                                <p class="small-top-m" v-if="recipientUser.destination_user_info != null">
                                                                                    {{recipientUser.destination_user_info.name}} - {{recipientUser.destination_user_info.role.rSubject}}
                                                                                </p>
                                                                                <p class="small-top-m btn-red" v-else>
                                                                                    در انتظار مشاهده
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p style="direction: ltr;margin-bottom: -15px;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.rhShamsiTime}}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="large-3 medium-3 small-12">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 3-->
                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="requestAttachmentsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x" style="margin-bottom: 30px;margin-top: 20px">
                                        <div class="medium-12">
                                            <div class="grid-x">
                                                <div style="margin-top: 15px;margin-bottom: 15px;" v-for="(attachment, index) in attachments" class="large-3 medium-4 small-12 padding-lr">
                                                    <div class="format-card">
                                                        <a  v-bind:href="attachment.aPath" target="_blank">
                                                            <div style="padding:15px;" class="text-center">
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'pdf'" class="fas fa-file-pdf size-72 btn-red"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'jpg' || attachment.aName.split('.').pop().toLowerCase() == 'jpeg' || attachment.aName.split('.').pop().toLowerCase() == 'png'" class="fas fa-file-image size-72 purple-color"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'doc' || attachment.aName.split('.').pop().toLowerCase() == 'docx'" class="fas fa-file-word size-72 blue-color"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'xls' || attachment.aName.split('.').pop().toLowerCase() == 'xlsx'" class="fas fa-file-excel size-72 btn-green"></i>
                                                                <h3 style="margin-top:10px;" class="gray-colors">{{attachment.aName.split('.').pop().toUpperCase()}}</h3>
                                                            </div>
                                                        </a>
                                                        <div class="format-container direction-ltr">
                                                            <p style="cursor: pointer;" :data-toggle="'attachment' + index" class="small-top-m gray-color one-line"><b>{{attachment.aName}}</b></p>
                                                            <div class="clearfix tool-bar">
                                                                <div style="width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="auto" data-alignment="auto" :id="'attachment' + index" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p style="word-break: break-all;" class="black-color">{{attachment.aName}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="grid-x">
                                                                <div class="large-12">
                                                                    <p v-if="Number((attachment.aSize / 1000).toFixed(1)) < 1024 " class="gray-colors">{{  Number((attachment.aSize / 1000).toFixed(1)) + ' کیلوبایت'}}</p>
                                                                    <p v-if="Number((attachment.aSize / 1000).toFixed(1)) > 1024" class="gray-colors">{{  Number(((attachment.aSize / 1000)/1024).toFixed(1)) + ' مگابایت'}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--            <button class="my-button my-brand" v-on:click.prevent="submit">بارگذاری</button>-->
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 4-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- Request Detail Modal End-->

    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    import VuePagination from '../../public_component/pagination.vue';
    import rDraft from '../FinancialDepartment/receiveRequests/detailRequest/r_draft.vue';
    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
            'vue-pagination' : VuePagination,
            rDraft,
        },

        data () {
            return {
                attachments: [],
                allRequests:[],
                requestSearchValue:'',
                showRequestDetailModal:false,
                recipientUsers:[],
                requestState: '',
                verifiers:[],
                UserIsVerifier:[],
                factors:[],
                contracts:[],
                requestTypeDetail:'',
                requestFill:{},
                costTemp:'',
                requestId:'',
                lastRefDId: -1,
                drafts:[],
                requestType:'',
                rAcceptedAmount:0,
                rCommitmentAmount:0,
                rSumOfDraftAmount: 0,
                commodityList:[],
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,
                result_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

            }
        },

        created: function(){
            this.fetchData();
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.costTemp =  '  ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        methods: {
            updateReceiveRequestData: function(requests , rId){
                this.allRequests = requests.data;
                this.allRequests.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.makePagination(requests);
            },

            makePagination: function(data){
                this.result_pagination.current_page = data.current_page;
                this.result_pagination.to = data.to;
                this.result_pagination.last_page = data.last_page;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set search part update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... search part update thread");
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('/financial/request/search/normal/fetchData?page=' + page , {params:{searchValue:this.requestSearchValue}})
                    .then((response) => {
                        this.allRequests = response.data.data;
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getRequestDetail: function (request) {
                this.showRequestDetailModal=true;
                this.recipientUsers=[];
                this.UserIsVerifier=[];
                this.attachments=[];
                this.requestState = request.request_state.rsState;
                var requestHistory=[];

                requestHistory.push(request);

                requestHistory.forEach(users => {
                    users.history.forEach(userHistory => {
                        this.recipientUsers.push(userHistory);
                    });
                });


                requestHistory.forEach(remainUsers => {
                    remainUsers.rRemainingVerifiers.forEach(users => {
                        this.UserIsVerifier.push(users);
                    });
                });

                requestHistory.forEach(attach => {
                    attach.attachment.forEach(item => {
                        this.attachments.push(item);
                    });
                });

                this.requestId = request.id;
                this.contracts = request.contract;
                this.factors = request.factor;
                this.rCommitmentAmount=request.rCommitmentAmount;
                this.rAcceptedAmount=request.rAcceptedAmount;
                this.requestType= request.request_type.rtType;
                this.drafts = request.draft;
                this.rSumOfDraftAmount = request.rSumOfDraftAmount;
                this.lastRefDId = request.rLastRef.rhDId;

                if (request.rRtId == 1){
                    this.requestTypeDetail='SERVICES';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
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
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                }
            },


            removeFilter: function () {
                this.requestSearchValue = '';
                this.fetchData();
            },

            search: function () {
                this.fetchData();
            },

    }
}
</script>
