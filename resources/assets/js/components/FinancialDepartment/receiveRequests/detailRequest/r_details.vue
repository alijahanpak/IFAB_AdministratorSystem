<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div style="height: 63vh;" class="grid-x inner-vh-unsize">
        <div class="large-12 medium-12 small-12">
            <a class="my-button toolbox-btn small" @click="openUpdateRequestModal()">ویرایش</a>
            <a class="my-button toolbox-btn small" @click="openRequestPdfModal()">پیش نمایش</a>
        </div>
        <div v-show="requestTypeDetail == 'BUY_SERVICES'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{selectedRequest.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{selectedRequest.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{selectedRequest.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ برآوردی : </td>
                    <td>{{$root.dispMoneyFormat(selectedRequest.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                </tr>
                <tr>
                    <td width="150px">مبلغ نهایی : </td>
                    <td v-if="parseInt(selectedRequest.rAcceptedAmount) > 0">{{$root.dispMoneyFormat(selectedRequest.rAcceptedAmount)}} <span class="btn-red">  ریال  </span></td>
                    <td v-else><span class="reserved-label">فاقد قرارداد</span></td>
                </tr>
                <tr>
                    <td width="150px">شرح کامل خدمات : </td>
                    <td class="text-justify">{{selectedRequest.rDescription}}</td>
                </tr>
                <tr>
                    <td width="150px">توضیحات تکمیلی : </td>
                    <td class="text-justify">{{selectedRequest.rFurtherDetails}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-show="requestTypeDetail == 'BUY_COMMODITY'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{selectedRequest.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{selectedRequest.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{selectedRequest.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ نهایی : </td>
                    <td v-if="parseInt(selectedRequest.rAcceptedAmount) > 0">{{$root.dispMoneyFormat(selectedRequest.rAcceptedAmount)}} <span class="btn-red">  ریال  </span></td>
                    <td v-else><span class="reserved-label">فاقد فاکتور</span></td>
                </tr>
                </tbody>
            </table>

            <table>
                <thead>
                <th class="text-center" width="50">ردیف</th>
                <th class="text-center">شرح و نوع جنس</th>
                <th class="text-center" width="100">تعداد</th>
                <th class="text-center" v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")' width="120">موجودی انبار</th>
                <th class="text-center" width="150">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                <th class="text-center" width="300">توضیحات (موارد مصرف)</th>
                </thead>
                <tbody>

                <tr v-for="(lists,index) in selectedRequest.request_commodity">
                    <td  align="center">{{index+1}}</td>
                    <td>{{lists.commodity.cSubject}}</td>
                    <td  align="center">{{lists.rcCount - lists.rcExistCount}}</td>
                    <td  align="center" v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")'>
                        <input v-on:change="setRepoExistCount(lists.id,commodityCountInput['existCount' + lists.id])" v-model="commodityCountInput['existCount' + lists.id]"  style="margin-bottom: 0px;" class="form-element-margin-btm" type="text" :name="'repoCount' + lists.id" v-validate="'required','min_value:0','max_value:'+lists.rcCount " data-vv-as="field" :class="{'input': true, 'error-border': errors.has('repoCount' + lists.id)}">
                        <span v-show="errors.has('repoCount' + lists.id)" class="error-font"></span>
                    </td>
                    <td  align="center">{{$root.dispMoneyFormat(lists.rcCostEstimation)}}</td>
                    <td>{{lists.rcDescription}}</td>
                </tr>
                <tr>
                    <td :colspan='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY") ? 4 : 3' class="text-center font-wei-bold"> مجموع برآورد</td>
                    <td colspan="2" class="text-center font-wei-bold">{{$root.dispMoneyFormat(selectedRequest.rCostEstimation)}} <span class="btn-red">  ریال  </span> </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{selectedRequest.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{selectedRequest.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{selectedRequest.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ برآوردی : </td>
                    <td>{{$root.dispMoneyFormat(selectedRequest.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                </tr>
                <tr>
                    <td width="150px">متن درخواست : </td>
                    <td class="text-justify">{{selectedRequest.rDescription}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Request Edit Modal -->
        <modal-large v-if="showEditRequestModal" @close="showEditRequestModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="updateRequest" >
                    <div style="margin-top: 25px" class="grid-x">
                        <div class="large-6 medium-6 small-12">
                            <label>موضوع
                                <input type="text" name="requestSubject" v-model="requestFill.rSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('requestSubject')}">
                            </label>
                            <p v-show="errors.has('requestSubject')" class="error-font">لطفا موضوع را برای درخواست مورد نظر را وارد نمایید!</p>
                        </div>
                        <!--Commodity Start-->
                        <div  v-show="requestTypeDetail == 'BUY_COMMODITY'" style="margin-top: 20px;" class="large-12 medium-12 small-12">
                            <table class="stack">
                                <thead>
                                <tr style="color: #575962;">
                                    <th width="50">ردیف</th>
                                    <th>شرح و نوع جنس</th>
                                    <th width="100">تعداد</th>
                                    <th width="200">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
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
                                        <suggestions autocomplete="off" style="margin-bottom: -18px;" name="commodityTitle" v-validate :class="{'input': true, 'select-error': errors.has('commodityTitle')}"
                                                     v-model="commodityQuery"
                                                     :options="commodityOptions"
                                                     :onInputChange="onCommodityInputChange">
                                            <div slot="item" slot-scope="props" class="single-item">
                                                <strong>{{props.item}}</strong>
                                            </div>
                                        </suggestions>
                                    </td>
                                    <td>
                                        <input id="numberEdit" v-model="commodityItem.commodityCount" class="text-margin-btm" type="number" value="1">
                                    </td>
                                    <td>
                                        <money v-model="commodityItem.commodityPrice"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('price')}"></money>
                                    </td>
                                    <td>
                                        <input v-model="commodityItem.commodityDescription" class="text-margin-btm" type="text">
                                    </td>
                                    <td class="text-center"><a v-if="commodityQuery != '' && commodityItem.commodityCount != null && commodityItem.commodityPrice != 0" @click="addCommodityItem()"><i class="fas fa-check btn-green size-18"></i></a></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                    <td colspan="2" class="text-center font-wei-bold">{{$root.dispMoneyFormat(sumOfCommodityPrice)}} <span class="btn-red">{{  'ریال'  }}</span> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--Commodity End-->

                        <!--Service Start-->
                        <div v-show="requestTypeDetail == 'BUY_SERVICES'" class="large-12 medium-12 small-12">
                            <div class="grid-x">
                                <div class="large-12 medium-12 small-12">
                                    <p style="margin-bottom: 5px;" class="btn-red"><span><i style="margin-left:8px;margin-top:2px;" class="fas fa-exclamation-circle btn-red size-21"></i></span>
                                        <span class="black-color">کارشناس محترم، لطفا هنگام محاسبه مبلغ برآورد، کسورات قانونی سهم دولت (</span>
                                        <span class="btn-red">کارفرما</span>
                                        <span class="black-color">) را در نظر بگیرید، شامل: </span>
                                        <span class="btn-red">مالیات بر ارزش افزوده</span>
                                        <span class="black-color">، </span>
                                        <span class="btn-red">بیمه سهم کارفرما </span>
                                        <span class="black-color">و ...</span>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="large-4 medium-4 small-12">
                                    <label>برآورد تقریبی اعتبار مورد نیاز <span class="btn-red">(ریال)</span>
                                        <money v-model="requestFill.serviceEstimated"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('serviceEstimated')}"></money>
                                    </label>
                                    <p v-show="errors.has('serviceEstimated')" class="error-font">لطفا مبلغ تقریبی را برای درخواست مورد نظر را وارد نمایید!</p>
                                </div>
                            </div>
                            <div style="margin-top:16px;" class="grid-x">
                                <div style="padding-left: 10px" class="large-6 medium-6 small-12">
                                    <label>شرح کامل خدمات
                                        <textarea v-if="requestTypeDetail == 'BUY_SERVICES'"  style="min-height: 170px;" name="fullDescription" v-model="requestFill.fullDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                        <textarea v-else="" class="form-element-margin-btm"  style="min-height: 170px;" name="fullDescription" v-model="requestFill.fullDescription"   :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                        <p v-show="errors.has('fullDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</p>
                                    </label>
                                </div>
                                <div style="padding-right: 10px" class="large-6 medium-6 small-12">
                                    <label>توضیحات تکمیلی
                                        <textarea class="form-element-margin-btm"  style="min-height: 170px;" name="furtherDescription" v-model="requestFill.furtherDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!--Service End-->

                        <!--Fund Start-->
                        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
                            <div class="grid-x">
                                <div class="large-4 medium-4 small-12">
                                    <label> مبلغ تنخواه <span class="btn-red">(ریال)</span>
                                        <money v-model="requestFill.fundEstimated"  v-bind="money"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fundEstimated')}"></money>
                                    </label>
                                    <p v-show="errors.has('fundEstimated')" class="error-font">لطفا مبلغ تنخواه را برای درخواست مورد نظر را وارد نمایید!</p>
                                </div>
                                <div class="large-12 medium-12 small-12">
                                    <label>متن درخواست
                                        <textarea v-if="requestTypeDetail == 'FUND'"  style="min-height: 150px;" name="requestText" v-model="requestFill.fullDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                        <textarea v-else="" class="form-element-margin-btm"  style="min-height: 150px;" name="requestText" v-model="requestFill.fullDescription" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                        <p v-show="errors.has('fullDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!--Fund End-->
                        <div class="large-12 medium-12 small-12" style="margin-top: 10px">
                            <button v-show="!$root.btnLoadingCheckStatus" type="submit"  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                        </div>
                    </div>
                </form>
            </div>
        </modal-large>
        <!-- Request Edit Modal -->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>
        <!-- PDF report modal -->
        <modal-large v-if="showReportModal" @close="showReportModal = false">
            <div  slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12" style="width: 100%;height: 75vh">
                        <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                        <iframe style="width: 100%;height: 100%;border: 0px" :src="pdfFilePath" />
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- PDF report modal -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VueElementLoading from 'vue-element-loading';
    export default{
        components: {
            Suggestions,
            VueElementLoading,
        },
        props:['requestTypeDetail','selectedBuffer','selectedIndex','selectedRequest' , 'searchValue'],
        data () {
            return {
                showEditRequestModal:false,
                commodityCountInput:{},
                repoExistCount:[],
                requestFill:{},
                sumOfCommodityPrice:0,
                commodityRequest:[],
                commodityItem:{},
                //commodity input text
                commodityQuery: '',
                commodityList: [],
                commodityListEdit: [],
                selectedCommodity: null,
                commodityOptions: {},
                //commodity input text
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                dialogMessage: '',
                showDialogModal: false,
                pdfFilePath:'',
                showReportModal:false,
                showLoaderProgress: false,

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {

        },

        methods : {
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
                        console.log(JSON.stringify(this.commodityList));
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

            setRepoExistCount: function (cId,count) {
                console.log(JSON.stringify(this.commodityCountInput));
                var repoExistCountInput={};
                repoExistCountInput.rcId=cId;
                repoExistCountInput.existCount=count;

                console.log(JSON.stringify(repoExistCountInput));

                if(this.repoExistCount === undefined || this.repoExistCount.length == 0){
                    this.repoExistCount.push(repoExistCountInput);
                }
                else{
                    this.repoExistCount.forEach((item,index) =>{
                        if(item.rcId ==  repoExistCountInput.rcId){
                            this.repoExistCount.splice(index,1);
                            this.repoExistCount.push(repoExistCountInput);
                        }
                        else{
                            this.repoExistCount.push(repoExistCountInput);
                        }
                    });
                }
                this.$emit('setRepoExistCountParent' , this.repoExistCount);
            },

            addCommodityItem: function () {
                this.commodityItem.commodityName=this.commodityQuery;
                this.commodityItem.commodityDescription=this.commodityItem.commodityDescription != null ? this.commodityItem.commodityDescription : '',
                    console.log(JSON.stringify(this.commodityItem));
                this.commodityRequest.push(this.commodityItem);
                console.log(JSON.stringify(this.commodityRequest));
                this.commodityQuery='';
                var temp;
                temp=this.commodityItem.commodityPrice.split(',').join('');
                this.sumOfCommodityPrice += parseInt(temp,10);
                this.commodityItem={};
                if(this.commodityRequest.length >= 0){
                    this.btnState=false;
                }

            },

            deleteCommodityItem: function (index) {
                var arrayTemp=[];
                arrayTemp=this.commodityRequest[index];
                //arrayTemp.commodityPrice.replace(',','');
                this.sumOfCommodityPrice-=parseInt(arrayTemp.commodityPrice.split(',').join(''),10);
                this.commodityRequest.splice(index,1);
            },

            openUpdateRequestModal:function(){
                if(!this.selectedRequest.rAllowUpdateInReceived){
                    this.dialogMessage = 'ویرایش درخواست در این مرحله امکانپذیر نیست!';
                    this.showDialogModal = true;
                }
                else {
                    this.sumOfCommodityPrice = 0;
                    this.commodityRequest = [];
                    this.requestFill = {};
                    this.commodityItem = {};
                    this.commodityQuery = '';
                    this.requestType = this.selectedRequest.request_type.rtType;
                    this.requestFill.id = this.selectedRequest.id;
                    this.requestFill.rSubject = this.selectedRequest.rSubject;
                    this.requestFill.serviceEstimated = this.selectedRequest.rCostEstimation;
                    this.requestFill.fullDescription = this.selectedRequest.rDescription;
                    this.requestFill.furtherDescription = this.selectedRequest.rFurtherDetails;
                    this.sumOfCommodityPrice = this.requestFill.serviceEstimated;


                    this.selectedRequest.request_commodity.forEach(com => {
                        var commodityTemp = {};
                        commodityTemp.commodityName = com.commodity.cSubject;
                        commodityTemp.commodityCount = com.rcCount;
                        commodityTemp.commodityPrice = this.$root.dispMoneyFormat(com.rcCostEstimation);
                        commodityTemp.commodityDescription = com.rcDescription;
                        this.commodityRequest.push(commodityTemp);
                    });
                    console.log('-----------------------------------------------------1');
                    console.log(JSON.stringify(this.commodityRequest));
                    console.log('-----------------------------------------------------2');
                    this.fetchCommodity();
                    console.log(JSON.stringify(this.commodityList));
                    this.showEditRequestModal = true;
                }
            },

            updateRequest: function(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.commodityRequest.forEach(items => {
                            items.commodityPrice = items.commodityPrice.split(',').join('');
                        });
                        if (this.requestType == 'BUY_SERVICES') {
                            this.sumOfCommodityPrice = this.requestFill.serviceEstimated.split(',').join('');
                        }
                        if (this.requestType == 'FUND') {
                            this.sumOfCommodityPrice = this.requestFill.fundEstimated.split(',').join('');
                        }
                        var config = {
                            allowLoading:true,
                        };
                        console.log(JSON.stringify(this.commodityRequest));
                        axios.post('/financial/request/update', {
                            id: this.requestFill.id,
                            subject: this.requestFill.rSubject,
                            costEstimation: this.sumOfCommodityPrice,
                            description: this.requestFill.fullDescription,
                            furtherDetails: this.requestFill.furtherDescription,
                            searchValue: this.searchValue,
                            resultType: 'RECEIVED',
                            items: this.requestType == 'BUY_COMMODITY' ? this.commodityRequest : null,
                        },config).then((response) => {
                            this.$emit('updateReceiveRequestData' , response.data);
                            this.$emit('closeModal');
                            this.showEditRequestModal = false;
                            this.$root.displayNotif(response.status);
                            console.log(response);
                        }, (error) => {
                            console.log(error);
                            this.$root.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openRequestPdfModal: function (){
                this.pdfFilePath='';
                this.requestPrintPreviewModal();
                this.showReportModal=true;
            },

            requestPrintPreviewModal: function () {
                this.showLoaderProgress = true;
                axios.post('/financial/report/request' , {rId: this.selectedRequest.id} , {responseType:'blob'})
                    .then((response) => {
                        console.log(response.data);
                        var file = new Blob([response.data], {type: 'application/pdf'});
                        var fileURL = window.URL.createObjectURL(file);
                        this.pdfFilePath = decodeURI(fileURL + '#zome=50');
                        this.showLoaderProgress = false;
                    },(error) => {
                        console.log(error);
                        this.showLoaderProgress = false;
                    });
            },
        }
    }
</script>
