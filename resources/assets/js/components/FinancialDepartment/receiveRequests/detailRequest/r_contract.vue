<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-show="$can('UNIT_OF_CONTRACT_ADD_NEW_CONTRACT')" class="large-12 medium-12 small-12">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a v-if="contracts.length == 0" class="my-button toolbox-btn small" @click="openInsertContractModal()">جدید</a>
                </div>
            </div>
        </div>
        <div class="large-12 medium-12 small-12 small-top-m">
            <!--Table Start-->
            <!--Table Head Start-->
            <div class="tbl-div-container">
                <table class="tbl-head">
                    <colgroup>
                        <col width="300px"/>
                        <col width="120px"/>
                        <col width="110px"/>
                        <col width="110px"/>
                        <col width="300px"/>
                        <col width="150px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شماره نامه</th>
                        <th class="tbl-head-style-cell">تاریخ نامه</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style inner-vh-3">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="300px"/>
                            <col width="120px"/>
                            <col width="110px"/>
                            <col width="110px"/>
                            <col width="300px"/>
                            <col width="150px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="(contract,index) in contracts">
                            <td :data-toggle="'contract' + contract.id">{{contract.cSubject}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{$root.dispMoneyFormat(contract.cBaseAmount)}}
                                <div class="clearfix tool-bar">
                                    <div  style="width: 35vw;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'contract' + contract.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <div class="large-12">
                                                <!--Table Start-->
                                                <div style="height: 30vh;" class="tbl_body_style">
                                                    <table class="stack text-right">
                                                        <tbody>
                                                            <tr class="align-right">
                                                                <td width="300" class="black-color">عنوان  :</td>
                                                                <td width="400">{{contract.cSubject}}</td>
                                                            </tr>
                                                            <tr class="align-right">
                                                                <td class="black-color">مجری  :</td>
                                                                <td>{{contract.executor.eSubject}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">مبلغ  :</td>
                                                                <td>{{$root.dispMoneyFormat(contract.cBaseAmount)}} ریال</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">مبلغ با در نظر گرفتن کسورات  :</td>
                                                                <td>{{$root.dispMoneyFormat(contract.cAmount)}} ریال</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">حداکثر درصد افزایش / کاهش  :</td>
                                                                <td>{{contract.cPercentInAndDec}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">ضریب پیمان: </td>
                                                                <td dir="ltr">{{contract.cCoefficient}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">شماره قرارداد  :</td>
                                                                <td>{{contract.cLetterNumber}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">تاریخ قرارداد  :</td>
                                                                <td>{{contract.cLetterDate}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">تاریخ شروع  :</td>
                                                                <td>{{contract.cStartDate}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">تاریخ پایان  :</td>
                                                                <td>{{contract.cEndDate}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="black-color">شرح  :</td>
                                                                <td>{{contract.cDescription}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--Table Body End-->
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterNumber}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterDate}}</td>
                            <td :data-toggle="'contract' + contract.id" class="one-line">{{contract.cDescription}}</td>
                            <td>
                                <div class="grid-x">
                                    <div class="medium-11">
                                        <div v-show="contract.cIsAccepted == 1"><span class="success-label">تایید شده</span></div>
                                        <div v-show="contract.cIsAccepted == 0"><span class="reserved-label">تایید نشده</span></div>
                                    </div>
                                    <div v-show="!contract.cIsAccepted" class="medium-1 cell-vertical-center text-left">
                                        <a class="dropdown small sm-btn-align" :data-toggle="'contractMenu' + contract.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" :id="'contractMenu' + contract.id" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font text-right">
                                                <li v-show="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')"><a v-on:click.prevent="openUpdateContractModal(index)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                <li v-show="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')"><a @click="openConfirmDeleteContract(contract.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
            <!--Table Body End-->
            <div class="large-12 medium-12 small-12" v-show='$can("UNIT_OF_CONTRACT_ACCEPT_CONTRACT")'>
                <div class="stacked-for-small button-group float-left">
                    <button @click="checkAcceptContract()"  class="my-button my-success float-left"><span class="btn-txt-mrg">تایید اطلاعات قرارداد</span></button>
                </div>
            </div>
        </div>

        <!--Insert Contract Start-->
        <modal-small v-if="showInsertContractModal" @close="showInsertContractModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="addNewContract" >
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>عنوان
                                    <input type="text" name="contractSubject" v-model="contractInput.subject = requestSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('contractSubject')}">
                                </label>
                                <p v-show="errors.has('contractSubject')" class="error-font">لطفا عنوان را برای قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-8 medium-8 small-12 padding-lr">
                                <label>مجری
                                    <suggestions style="margin-bottom: -18px;height: 41px;" name="executorTitle" :class="executorAlert ? 'select-error' : ''"
                                                 v-model="contractInput.executor"
                                                 :options="executorOptions"
                                                 :onInputChange="onExecutorInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                                <p style="margin-top:23px !important;" v-show="executorAlert" class="error-font">لطفا مجری قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-4 medium-4 small-12 padding-lr">
                                <label>ضریب پیمان
                                    <input type="text" dir="ltr" name="contractCoefficient" v-model="contractInput.coefficient" v-validate="'required|integer'" :class="{'input': true, 'error-border': errors.has('contractCoefficient')}">
                                </label>
                                <p v-show="errors.has('contractCoefficient')" class="error-font">مقدار نامعتبر است!</p>
                            </div>
                        </div>
                        <div style="margin-top:15px;"  class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ پایه<span class="btn-red">(ریال)</span>
                                    <money dir="ltr" :class="checkInputAmount == true ? 'select-error' : ''" @keyup.native="calculateFinalContractAmount()" v-model="contractInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'"></money>
                                </label>
                                <p v-show="errors.has('contractAmount')" class="error-font">لطفا مبلغ را برای قرارداد مورد نظر را وارد نمایید!</p>
                                <p style="margin-top: 8px;" v-show="checkInputAmount" class="btn-red">مبلغ قرارداد نمی تواند کمتر از صفر باشد! </p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>درصد افزایش و یا کاهش
                                    <input dir="ltr" type="text" name="contractPercent" v-model="contractInput.percentIncAndDec = 25" readonly v-validate="'required|min_value:0|max_value:25'" :class="{'input': true, 'error-border': errors.has('contractPercent')}">
                                </label>
                                <p v-show="errors.has('contractPercent')" class="error-font">مقدار نا معتبر است!</p>
                            </div>
                        </div>
                        <div v-show="displayWarning" class="grid-x"  style="margin-top: -10px; margin-bottom: 10px">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <span class="btn-red size-12">اخطار! </span>
                                <span class="black-color size-12">کارشناس محترم، مبلغ نهایی قرارداد از مبلغ براورد بیشتر است, آیا برای ثبت قرارداد اطمینان دارید؟</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>شماره قرارداد
                                    <input dir="ltr" type="text" name="letterNumber" v-model="contractInput.letterNumber" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('letterNumber')}">
                                </label>
                                <p v-show="errors.has('letterNumber')" class="error-font">لطفا شماره قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ قرارداد
                                    <date-picker
                                            :color="letterDateAlert ? '#d9534f' : '#5c6bc0'"
                                            v-model="contractInput.letterDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-letterDate"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                                <p style="margin-top:3px !important;" v-show="letterDateAlert" class="error-font">لطفا تاریخ قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ شروع
                                    <date-picker
                                            :color="startDateAlert ? '#d9534f' : '#5c6bc0'"
                                            v-model="contractInput.startDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-startDate"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                                <p style="margin-top:3px !important;" v-show="startDateAlert" class="error-font">لطفا تاریخ شروع قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ پایان
                                    <date-picker
                                            :color="endDateAlert ? '#d9534f' : '#5c6bc0'"
                                            v-model="contractInput.endDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-endDate"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                                <p style="margin-top:3px !important;" v-show="endDateAlert" class="error-font">لطفا تاریخ پایان قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="panel-separator padding-lr">
                                    <div  v-for="(category , index) in percentageIncreaseCategory" class="grid-x">
                                        <div class="large-8 medium-8  small-12">
                                            <div class="grid-x">
                                                <div class="large-12 medium-12  small-12">
                                                    <label>{{ category.picSubject }}
                                                        <select name="percentageIncrease" v-model="contractInput['percentage' + category.id]" v-on:change="calculateAmount(contractInput['percentage' + category.id] , index)">
                                                            <option value=""></option>
                                                            <option v-for="pi in category.percentage_increase" :value="pi.id">{{pi.piSubject}} - {{'(' + pi.piPercent + '%)'}}</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-4 medium-4  small-12 text-left">
                                            <p style="margin-top: 30px;" class="btn-red text-left">{{$root.dispMoneyFormat(category.amountInc)}} ریال</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: -16px;border-top: 1px solid #E0E0E0;" class="panel-separator padding-lr">
                                    <div class="grid-x">
                                        <div class="large-9 medium-9 small-12">
                                            <div class="grid-x">
                                                <div class="large-12 medium-12  small-12">
                                                    <p>مبلغ نهایی قرارداد : </p>
                                                </div>
                                            </div>
                                            <div v-show="displayWarning" class="grid-x"  style="margin-top: -10px">
                                                <div class="large-12 medium-12  small-12">
                                                    <span class="btn-red size-12">اخطار! </span>
                                                    <span class="black-color size-12">کارشناس محترم، مبلغ نهایی قرارداد از مبلغ براورد بیشتر است, آیا برای ثبت قرارداد اطمینان دارید؟</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-3 medium-3  small-12 text-left">
                                            <p class="btn-red text-left">{{$root.dispMoneyFormat(finalAmount)}} ریال</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:16px;" class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح کامل خدمات
                                    <textarea style="min-height: 150px;" name="contractDescription" v-model="contractInput.description" v-validate="'required'"  :class="{'input': true, 'error-border': errors.has('contractDescription')}"></textarea>
                                    <p v-show="errors.has('contractDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button  v-show="!$root.btnLoadingCheckStatus" type="submit" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                    <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-small>
        <!--Insert Contract End-->

        <!--Update Contract Start-->
        <modal-small v-if="showUpdateContractModal" @close="showUpdateContractModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="updateContract" >
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>عنوان
                                    <input type="text" name="contractSubject" v-model="contractInput.subject = requestSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('contractSubject')}">
                                </label>
                                <p v-show="errors.has('contractSubject')" class="error-font">لطفا عنوان را برای قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-8 medium-8 small-12 padding-lr">
                                <label>مجری
                                    <suggestions style="margin-bottom: -18px;height: 41px;" name="executorTitle" :class="executorAlert ? 'select-error' : ''"
                                                 v-model="contractInput.executor"
                                                 :options="executorOptions"
                                                 :onInputChange="onExecutorInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                                <p style="margin-top:23px !important;" v-show="executorAlert" class="error-font">لطفا مجری قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-4 medium-4 small-12 padding-lr">
                                <label>ضریب پیمان
                                    <input type="text" dir="ltr" name="contractCoefficient" v-model="contractInput.coefficient" v-validate="'required|integer'" :class="{'input': true, 'error-border': errors.has('contractCoefficient')}">
                                </label>
                                <p v-show="errors.has('contractCoefficient')" class="error-font">مقدار نامعتبر است!</p>
                            </div>
                        </div>
                        <div style="margin-top:15px;"  class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ پایه<span class="btn-red">(ریال)</span>
                                    <money dir="ltr" :class="checkInputAmount == true ? 'select-error' : ''" @keyup.native="calculateFinalContractAmount()" v-model="contractInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'"></money>
                                </label>
                                <p v-show="errors.has('contractAmount')" class="error-font">لطفا مبلغ را برای قرارداد مورد نظر را وارد نمایید!</p>
                                <p style="margin-top: 8px;" v-show="checkInputAmount" class="btn-red">مبلغ قرارداد نمی تواند کمتر از صفر باشد! </p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>درصد افزایش و یا کاهش
                                    <input dir="ltr" type="text" name="contractPercent" v-model="contractInput.percentIncAndDec = 25" readonly v-validate="'required|min_value:0|max_value:25'" :class="{'input': true, 'error-border': errors.has('contractPercent')}">
                                </label>
                                <p v-show="errors.has('contractPercent')" class="error-font">مقدار نا معتبر است!</p>
                            </div>
                        </div>
                        <div v-show="displayWarning" class="grid-x"  style="margin-top: -10px; margin-bottom: 10px">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <span class="btn-red size-12">اخطار! </span>
                                <span class="black-color size-12">کارشناس محترم، مبلغ نهایی قرارداد از مبلغ براورد بیشتر است, آیا برای ثبت قرارداد اطمینان دارید؟</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>شماره قرارداد
                                    <input dir="ltr" type="text" name="letterNumber" v-model="contractInput.letterNumber" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('letterNumber')}">
                                </label>
                                <p v-show="errors.has('letterNumber')" class="error-font">لطفا شماره قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ قرارداد
                                    <date-picker
                                            :color="'#5c6bc0'"
                                            v-model="contractInput.letterDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-letterDate-Update"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                                <p v-show="errors.has('letterDate')" class="error-font">لطفا تاریخ قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ شروع
                                    <date-picker
                                            :color="'#5c6bc0'"
                                            v-model="contractInput.startDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-startDate-Update"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ پایان
                                    <date-picker
                                            :color="'#5c6bc0'"
                                            v-model="contractInput.endDate"
                                            input-class="form-control form-control-lg date-picker-bottom-margin"
                                            id="contract-endDate-Update"
                                            placeholder="انتخاب تاریخ">
                                    </date-picker>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="panel-separator padding-lr">
                                    <div  v-for="(category , index) in percentageIncreaseCategory" class="grid-x">
                                        <div class="large-8 medium-8  small-12">
                                            <div class="grid-x">
                                                <div class="large-12 medium-12  small-12">
                                                    <label>{{ category.picSubject }}
                                                        <select name="percentageIncrease" v-model="contractInput['percentage' + category.id]" v-on:change="calculateAmount(contractInput['percentage' + category.id] , index)">
                                                            <option value=""></option>
                                                            <option v-for="pi in category.percentage_increase" :value="pi.id">{{pi.piSubject}} - {{'(' + pi.piPercent + '%)'}}</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-4 medium-4  small-12 text-left">
                                            <p style="margin-top: 30px;" class="btn-red text-left">{{$root.dispMoneyFormat(category.amountInc)}} ریال</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: -16px;border-top: 1px solid #E0E0E0;" class="panel-separator padding-lr">
                                    <div class="grid-x">
                                        <div class="large-9 medium-9 small-12">
                                            <div class="grid-x">
                                                <div class="large-12 medium-12  small-12">
                                                    <p>مبلغ نهایی قرارداد : </p>
                                                </div>
                                            </div>
                                            <div v-show="displayWarning" class="grid-x"  style="margin-top: -10px">
                                                <div class="large-12 medium-12  small-12">
                                                    <span class="btn-red size-12">اخطار! </span>
                                                    <span class="black-color size-12">کارشناس محترم، مبلغ نهایی قرارداد از مبلغ براورد بیشتر است, آیا برای ثبت قرارداد اطمینان دارید؟</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-3 medium-3  small-12 text-left">
                                            <p class="btn-red text-left">{{$root.dispMoneyFormat(finalAmount)}} ریال</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:16px;" class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح کامل خدمات
                                    <textarea style="min-height: 150px;" name="contractDescription" v-model="contractInput.description" v-validate="'required'"  :class="{'input': true, 'error-border': errors.has('contractDescription')}"></textarea>
                                    <p v-show="errors.has('contractDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button v-show="!$root.btnLoadingCheckStatus" type="submit" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                    <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-small>
        <!--Update Contract End-->

        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>

        <!-- accept Financing modal -->
        <modal-tiny v-if="showAcceptConfirmModal" @close="showAcceptConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">تایید اطلاعات قرارداد به منزله ایجاد تعهد در محل های تامین اعتبار است، آیا صحت اطلاعات را تایید می کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-show="!$root.btnLoadingCheckStatus" v-on:click="acceptContract" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- accept Financing modal -->

        <!-- accept Financing modal -->
        <modal-tiny v-if="showDeleteConfirmModal" @close="showDeleteConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا مایل هستید قرارداد را حذف کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-show="!$root.btnLoadingCheckStatus" v-on:click="deleteContract"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- accept Financing modal -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default{
        props:['contracts','requestId' , 'rCreditIsAccepted' , 'rCreditIsExist', 'requestSubject' , 'rCostEstimation'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertContractModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showUpdateContractModal: false,
                showDialogModal: false,
                displayWarning: false,
                cIdForDelete: 0,
                dialogMessage: '',
                contractInput:{},
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                //contract input text
                executorItems:[],
                executor: '',
                executorList: [],
                selectedExecutor: null,
                executorOptions: {},
                //contract input text

                percentageIncreaseCategory:[],
                percentageCheckBox:false,
                increaseItems:[],
                increaseItemsValue:[],
                finalAmount:0,
                positionTemp:0,
                checkInputAmount:false,
                selectedContractIndex:'',
                selectedContract:[],
                letterDateAlert:false,
                startDateAlert:false,
                endDateAlert:false,
                executorAlert:false,
            }
        },

        watch: {
            finalAmount: function (newValue , oldValue) {
                if (newValue > this.rCostEstimation)
                    this.displayWarning = true;
                else
                    this.displayWarning = false;
            },
            contractInput: function (newQuestion, oldQuestion) {
                if(this.contractInput.letterDate != null)
                    this.letterDateAlert=false;
                if(this.contractInput.startDate != null)
                    this.startDateAlert=false;
                if(this.contractInput.endDate != null)
                    this.endDateAlert=false;
                if(this.contractInput.executor != null)
                    this.executorAlert=false;
            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
        },

        mounted: function () {
            this.contractPercentageIncrease();
            this.getAllExecutors();

        },

        methods : {

            /*-----------------------------------------------------------------------------
           ------------------ Contract Executor Start ------------------------------
           -----------------------------------------------------------------------------*/
            getAllExecutors: function () {
                axios.get('/financial/executor/fetchData')
                    .then((response) => {
                        this.executorItems = response.data;
                        this.executorList= [];
                        this.executorItems.forEach(item=> {
                            this.executorList.push(item.eSubject)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            onExecutorInputChange(executorInput) {
                if (executorInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.executorList.filter((executors) => {
                    return executors.toLowerCase().includes(executorInput.toLowerCase())
                })
            },
            onCommoditySelected(item) {
                this.selectedExecutor = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ Contract Executor End ------------------------------
            -----------------------------------------------------------------------------*/
            contractPercentageIncrease: function () {
                axios.get('/financial/request/contract/fetchPercentageIncreaseData')
                    .then((response) => {
                        this.percentageIncreaseCategory = response.data;
                        this.percentageIncreaseCategory.forEach(category =>{
                            Vue.set(category,"amountInc",0);
                            category.percentage_increase.forEach(item =>{
                                Vue.set(item,"amountInc",0);
                            });
                        });
                        //console.log(JSON.stringify(this.percentageIncreaseCategory));
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            calculateAmount: function(piId , catIndex){
                this.calculateChangeInputAmount(piId , catIndex);
                this.calculateFinalContractAmount();
            },

            calculateChangeInputAmount:function(piId , catIndex){
                if (piId != '')
                {
                    var selectedPercent = null;
                    this.percentageIncreaseCategory[catIndex].percentage_increase.forEach(item => {
                        if (item.id == piId)
                            selectedPercent = item;
                        else{
                            Vue.set(item, "amountInc", 0);
                            Vue.set(item,"checked",false);
                        }
                    });
                    if (selectedPercent != null)
                    {
                        var tempAmount = Math.round((selectedPercent.piPercent * parseInt(this.contractInput.amount.split(',').join(''),10)) / 100);
                        var amountInc = 0;
                        this.percentageIncreaseCategory[catIndex].percentage_increase.forEach(item => {
                            if (selectedPercent.id == item.id) {
                                Vue.set(item, "amountInc", tempAmount);
                                Vue.set(item,"checked",true);
                                amountInc = tempAmount;
                            }
                        });
                        Vue.set(this.percentageIncreaseCategory[catIndex], "amountInc", amountInc);
                        console.log(JSON.stringify(this.percentageIncreaseCategory));
                    }
                }else{
                    this.percentageIncreaseCategory[catIndex].percentage_increase.forEach(item => {
                        Vue.set(item,"amountInc",0);
                        Vue.set(item,"checked",false);
                    });
                    Vue.set(this.percentageIncreaseCategory[catIndex], "amountInc", 0);
                }

            },

            calculateFinalContractAmount: function(){

                if(parseInt(this.contractInput.amount.split(',').join(''),10) < 0){
                    this.checkInputAmount=true;
                }
                else{
                    this.checkInputAmount=false;
                    this.percentageIncreaseCategory.forEach((category , index) =>{
                        category.percentage_increase.forEach(item => {
                            if (item.checked == true){
                                this.calculateChangeInputAmount(item.id, index);
                            }
                        });
                    });
                    this.finalAmount=0;
                    var lastTemp=0;
                    lastTemp = parseInt(this.contractInput.amount.split(',').join(''),10);
                    this.percentageIncreaseCategory.forEach(category =>{
                        category.percentage_increase.forEach(item => {
                            lastTemp += item.amountInc;
                        });
                    });
                    this.finalAmount = Math.round(lastTemp);
                }
            },


            checkAcceptContract: function(){
                var existNotAccepted = false;
                this.contracts.forEach(item => {
                    if (item.cIsAccepted == false)
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'قرارداد تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات قرارداد نسبت به ثبت قرارداد جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteContract: function(cId){
                this.cIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptContract: function(){
                var config = {
                    allowLoading:true,
                };
                axios.post('/financial/request/contract/accept', {
                    rId: this.requestId,
                } , config).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data);
                    this.$emit('closeModal');
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            deleteContract: function() {
                var config = {
                    allowLoading:true,
                };
                axios.post('/financial/request/contract/delete', {
                    rId: this.requestId,
                    cId: this.cIdForDelete,
                } , config).then((response) => {
                    if (response.status == 200)
                        this.$emit('updateReceiveRequestData' , response.data);
                    this.showDeleteConfirmModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            openInsertContractModal:function () {
                if (this.rCreditIsExist == true)
                {
                    if (this.rCreditIsAccepted == false)
                    {
                        this.dialogMessage = 'تامین اعتبار تایید نهایی نشده است!';
                        this.showDialogModal = true;
                    }else{
                        //this.increaseTemp=[];
                        this.letterDateAlert=false;
                        this.startDateAlert=false;
                        this.endDateAlert=false;
                        this.finalAmount=0;
                        this.contractPercentageIncrease();
                        this.contractInput={};
                        this.increaseItems=[];
                        this.increaseItemsValue=[];
                        this.getAllExecutors();
                        this.showInsertContractModal=true;
                    }
                }else{
                    this.dialogMessage = 'امکان ثبت قرارداد وجود ندارد. منابع تامین اعتبار برای این درخواست تعیین نشده است!';
                    this.showDialogModal = true;
                }

            },

            addNewContract:function () {
                this.$validator.validateAll().then((result) => {
                     if(this.contractInput.executor == null)
                            this.executorAlert=true;
                     if(this.contractInput.letterDate == null)
                        this.letterDateAlert=true;
                     if(this.contractInput.startDate == null)
                        this.startDateAlert=true;
                     if(this.contractInput.endDate == null)
                        this.endDateAlert=true;
                     if(!this.executorAlert && !this.letterDateAlert && !this.startDateAlert && !this.endDateAlert){
                         if (result) {
                             var increaseTemp = [];
                             this.percentageIncreaseCategory.forEach(category => {
                                 category.percentage_increase.forEach(item => {
                                     var temp={};
                                     if(item.checked){
                                         temp.piId = item.id;
                                         temp.amount = item.amountInc;
                                         increaseTemp.push(temp);
                                     }
                                 });
                             });
                             var config = {
                                 allowLoading:true,
                             };
                             axios.post('/financial/request/contract/insert', {
                                 rId: this.requestId,
                                 subject: this.contractInput.subject,
                                 executor: this.contractInput.executor,
                                 baseAmount: parseInt(this.contractInput.amount.split(',').join(''),10),
                                 percentIncAndDec: this.contractInput.percentIncAndDec,
                                 coefficient: this.contractInput.coefficient,
                                 letterNumber: this.contractInput.letterNumber,
                                 letterDate: this.contractInput.letterDate,
                                 startDate: this.contractInput.startDate,
                                 endDate: this.contractInput.endDate,
                                 description: this.contractInput.description,
                                 increaseItems: increaseTemp,
                             } , config).then((response) => {
                                 this.$emit('updateReceiveRequestData', response.data);
                                 this.showInsertContractModal = false;
                                 this.$root.displayNotif(response.status);
                                 console.log(response);
                             }, (error) => {
                                 console.log(error);
                                 this.$root.displayNotif(error.response.status);
                             });
                        }
                    }
                });
            },

            openUpdateContractModal: function (index) {
                this.executorAlert=false;
                this.contractInput={};
                this.selectedContractIndex=index;
                this.selectedContract=this.contracts[this.selectedContractIndex];
                this.contractInput.id=this.contracts[this.selectedContractIndex].id;
                this.contractInput.subject=this.contracts[this.selectedContractIndex].cSubject;
                this.contractInput.executor=this.contracts[this.selectedContractIndex].executor.eSubject;
                this.contractInput.coefficient=this.contracts[this.selectedContractIndex].cCoefficient;
                this.contractInput.amount=this.$root.dispMoneyFormat(this.contracts[this.selectedContractIndex].cBaseAmount);
                this.contractInput.percentIncAndDec=this.contracts[this.selectedContractIndex].cPercentInAndDec;
                this.contractInput.letterNumber=this.contracts[this.selectedContractIndex].cLetterNumber;
                this.contractInput.letterDate=this.contracts[this.selectedContractIndex].cLetterDate;
                this.contractInput.startDate=this.contracts[this.selectedContractIndex].cStartDate;
                this.contractInput.endDate=this.contracts[this.selectedContractIndex].cEndDate;
                this.contractInput.description=this.contracts[this.selectedContractIndex].cDescription;

                this.finalAmount=0;
                this.increaseItems=[];
                this.increaseItemsValue=[];

                this.contracts[this.selectedContractIndex].increase_amount.forEach(item => {
                    this.percentageIncreaseCategory.forEach((category,index) =>{
                        category.percentage_increase.forEach(incItem =>{
                            if(item.percentage_increase.id == incItem.id){
                                this.contractInput['percentage' + category.id]=item.percentage_increase.id;
                                this.calculateAmount(this.contractInput['percentage' + category.id] ,index);
                                //Vue.set(this.percentageIncreaseCategory[index], "amountInc", item.icaAmount);
                                //this.calculateFinalContractAmount();
                                console.log(JSON.stringify(this.percentageIncreaseCategory));

                            }
                        });
                    });
                });

                this.showUpdateContractModal=true;
            },

            updateContract:function () {
                this.$validator.validateAll().then((result) => {
                    if (this.contractInput.executor == null)
                        this.executorAlert = true;
                    else {
                        if (result) {
                            var increaseTemp = [];
                            this.percentageIncreaseCategory.forEach(category => {
                                category.percentage_increase.forEach(item => {
                                    var temp = {};
                                    if (item.checked) {
                                        temp.piId = item.id;
                                        temp.amount = item.amountInc;
                                        increaseTemp.push(temp);
                                    }
                                });
                            });
                            var config = {
                                allowLoading:true,
                            };
                            axios.post('/financial/request/contract/update', {
                                id: this.contractInput.id,
                                rId: this.requestId,
                                subject: this.contractInput.subject,
                                executor: this.contractInput.executor,
                                baseAmount: parseInt(this.contractInput.amount.split(',').join(''), 10),
                                percentIncAndDec: this.contractInput.percentIncAndDec,
                                coefficient: this.contractInput.coefficient,
                                letterNumber: this.contractInput.letterNumber,
                                letterDate: this.contractInput.letterDate,
                                startDate: this.contractInput.startDate,
                                endDate: this.contractInput.endDate,
                                description: this.contractInput.description,
                                increaseItems: increaseTemp,
                            } , config).then((response) => {
                                this.$emit('updateReceiveRequestData', response.data);
                                this.showUpdateContractModal = false;
                                this.$root.displayNotif(response.status);
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                                this.$root.displayNotif(error.response.status);
                            });
                        }
                    }
                });
            },
        }
    }
</script>
