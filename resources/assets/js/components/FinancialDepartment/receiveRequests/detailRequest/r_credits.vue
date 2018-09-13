<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12">
            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="credit_tab_view">
                <li class="tabs-title is-active"><a href="#creditCapitalAssetsTab" aria-selected="true">تملک دارایی های سرمایه ای</a></li>
                <li class="tabs-title"><a href="#creditCostTab">هزینه ای </a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="credit_tab_view">
                <div class="grid-x">
                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                        <span class="cost-label">مبالغ : ریال</span>
                    </div>
                </div>
                <!--Tab 1-->
                <div class="tabs-panel is-active table-mrg-btm" id="creditCapitalAssetsTab">
                    <div class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="200px"/>
                                    <col width="120px"/>
                                    <col width="250px"/>
                                    <col width="320px"/>
                                    <col width="150px"/>
                                    <col width="120px"/>
                                    <col v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" width="60px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">شماره طرح</th>
                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                    <th class="tbl-head-style-cell">عنوان پروژه</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell">مبلغ رزرو شده</th>
                                    <th class="tbl-head-style-cell">وضعیت</th>
                                    <th v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" class="tbl-head-style-cell">عملیات</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                            </table>
                            <div class="tbl_body_style dynamic-height-level-modal2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="120px"/>
                                        <col width="250px"/>
                                        <col width="320px"/>
                                        <col width="150px"/>
                                        <col width="120px"/>
                                        <col v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" width="60px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <tr v-for="capFinancing in requestCapFinancing">
                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.capital_assets_approved_plan.credit_distribution_title.cdtSubject}}</td>
                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpCode}}</td>
                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpSubject}}</td>
                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpDescription}}</td>
                                        <template v-if="capFinancing.allocation.credit_source == null">
                                            <td colspan="4" class="text-center"><span class="user-verifier-label">تنخواه</span></td>
                                        </template>
                                        <td class="text-center">{{$root.dispMoneyFormat(capFinancing.cafAmount)}}</td>
                                        <td v-show="capFinancing.cafAccepted == 1"><span class="success-label">تایید شده</span></td>
                                        <td v-show="capFinancing.cafAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                                        <td v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" class="text-center"><a @click="openDeleteFinancingModal(capFinancing,1)"><i class="far fa-trash-alt size-21 btn-red"></i></a></i></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Table Body End-->
                    </div>
                    <div class="grid-x">
                        <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                            <div class="grid-x">
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ برآورد : <span class="btn-red"> {{$root.dispMoneyFormat(baseAmount)}} </span></p>
                                </div>
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ رزرو شده : <span class="btn-red"> {{$root.dispMoneyFormat(_reservedAmount)}} </span></p>
                                </div>
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ تامین اعتبار شده : <span class="btn-red"> {{$root.dispMoneyFormat(_financingAmount)}} </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tab 1-->

                <!--Tab 2-->
                <div class="tabs-panel table-mrg-btm" id="creditCostTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="350px"/>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" width="60px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">شماره برنامه</th>
                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell">مبلغ رزرو شده</th>
                                    <th class="tbl-head-style-cell">وضعیت</th>
                                    <th v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" class="tbl-head-style-cell">عملیات</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level-modal2">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="350px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" width="60px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <tr v-for="costFinancing in requestCostFinancing">
                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.credit_distribution_title.cdtIdNumber}}</td>
                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.cost_agreement.caLetterNumber}}</td>
                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.cost_agreement.caDescription}}</td>
                                        <template v-if="costFinancing.allocation.credit_source == null">
                                            <td colspan="3" class="text-center"><span class="user-verifier-label">تنخواه</span></td>
                                        </template>
                                        <td class="text-center">{{$root.dispMoneyFormat(costFinancing.cfAmount)}}</td>
                                        <td v-show="costFinancing.cfAccepted == 1"><span class="success-label">تایید شده</span></td>
                                        <td v-show="costFinancing.cfAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                                        <td v-if="$can('FINANCIAL_REMOVE_FINANCING_ITEM')" class="text-center"><a @click="openDeleteFinancingModal(costFinancing,2)"><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Table Body End-->
                    </div>
                    <div class="grid-x">
                        <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                            <div class="grid-x">
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ برآورد : <span class="btn-red"> {{$root.dispMoneyFormat(baseAmount)}} </span></p>
                                </div>
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ رزرو شده : <span class="btn-red"> {{$root.dispMoneyFormat(_reservedAmount)}} </span></p>
                                </div>
                                <div class="large-4 medium-4 small-12">
                                    <p class="p-margin-btm"> مبلغ تامین اعتبار شده : <span class="btn-red"> {{$root.dispMoneyFormat(_financingAmount)}} </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tab 2-->
            </div>
        </div>
        <div style="padding: 0 17px 0 17px;" class="large-12 medium-12 small-12 small-top-m">
            <div style="margin-bottom:-10px;margin-top: 5px" class="stacked-for-small button-group float-left">
                <button v-show='$can("FINANCIAL_ACCEPT_FINANCING") && acceptBtn' @click="acceptFinancing()"  class="my-button my-success float-left"><span class="btn-txt-mrg">تایید تامین اعتبار</span></button>
                <button v-show='$can("FINANCIAL_CAPITAL_ASSETS_FINANCING")' @click="openCapitalAssetsModal()" class="my-button toolbox-btn float-left"><span class="btn-txt-mrg">  اعتبارات تملک دارایی های سرمایه ای</span></button>
                <button v-show='$can("FINANCIAL_COST_FINANCING")' @click="openCostCreditsModal()" class="my-button toolbox-btn float-left"><span class="btn-txt-mrg">  اعتبارات هزینه ای</span></button>
            </div>
        </div>


        <!-- Cost Credits Modal Start -->
        <modal-full-screen v-if="showCostCreditsModal" @close="showCostCreditsModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="cost_credit_tab_view">
                                <li class="tabs-title is-active"><a href="#programTab" aria-selected="true">برنامه</a></li>
                                <li class="tabs-title"><a href="#creditDistributionResourcesTab">منابع تامین اعتبار </a></li>
                                <li class="tabs-title"><a href="#allocationTab">تخصیص </a></li>
                                <li class="tabs-title"><a href="#fundTab">تنخواه </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="cost_credit_tab_view">
                                <div class="grid-x">
                                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                                        <span class="cost-label">مبالغ : ریال</span>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="programTab">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">مجموع تخصیص</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار شده</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr class="table-row" v-for="plan in completeCostAgrement">
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{plan.caLetterNumber}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.caSumOfAllocation)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.caSumOfReserved)}}
                                                            <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'plan' + plan.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font">
                                                                    <div class="grid-x">
                                                                        <!--Table Start-->
                                                                        <div class="tbl_body_style dynamic-height-level-modal3">
                                                                            <table class="stack">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                    <td>{{plan.caLetterNumber}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                    <td>{{plan.caLetterDate}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                    <td v-show="plan.caProvinceOrNational == 0">استانی</td>
                                                                                    <td v-show="plan.cpProvinceOrNational == 1">ملی</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                    <td class="text-justify">{{plan.caDescription}}</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <!--Table Body End-->
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.caSumOfFinancing)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.caSumOfCommitment)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.caSumOfCost)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{plan.caDescription}}</td>
                                                        <td>
                                                            <input :disabled="plan.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan, plan, 0, plan.amount)" style="margin-bottom:0px;" v-if="plan.selected == true" type="text"  v-model="plan.amount" :name="plan.id" :value="plan.amount"  v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(plan , 1) + parseInt(plan.amount , 10))" :class="{'input': true, 'error-border': errors.has(plan.id)}" />
                                                            <span v-show="errors.has(plan.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="plan.isHistory" v-on:change="setTextBoxValueCost(plan,plan,0)" v-model="plan.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="creditDistributionResourcesTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="100"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">مجموع تخصیص</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="100"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCostAgrement">
                                                        <tr class="table-row" v-for="creditSource in plan.ca_credit_source_has_allocation">
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsSumOfAllocation) }}</td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsSumOfReserved) }}</td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsSumOfFinancing) }}
                                                                <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'creditSource' + creditSource.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <!--Table Start-->
                                                                            <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                <table class="stack">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                        <td>{{plan.caLetterNumber}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                        <td>{{plan.caLetterDate}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                        <td v-show="plan.caProvinceOrNational == 0">استانی</td>
                                                                                        <td v-show="plan.cpProvinceOrNational == 1">ملی</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                        <td class="text-justify">{{plan.caDescription}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">طرح :</td>
                                                                                        <td class="text-justify">{{creditSource.credit_distribution_title.cdtIdNumber}} - {{creditSource.credit_distribution_title.cdtSubject}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">ردیف :</td>
                                                                                        <td class="text-justify">{{creditSource.credit_distribution_row.cdSubject}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">فصل :</td>
                                                                                        <td class="text-justify">{{creditSource.tiny_season.season_title.season.sSubject}} - {{creditSource.tiny_season.season_title.cstSubject}} - {{creditSource.tiny_season.ctsSubject}}</td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <!--Table Body End-->
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsSumOfCommitment) }}</td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsSumOfCost) }}</td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{ $root.dispMoneyFormat(creditSource.ccsAmount) }}</td>
                                                            <td :data-toggle="'creditSource' + creditSource.id" class="text-justify">{{creditSource.ccsDescription}}</td>
                                                            <td>
                                                                <input :disabled="creditSource.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan, creditSource, 1, creditSource.amount)" style="margin-bottom:0px;" v-if="creditSource.selected == true" type="text" v-model="creditSource.amount"  :value="creditSource.amount" :name="creditSource.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(creditSource , 2) + parseInt(creditSource.amount , 10))" :class="{'input': true, 'error-border': errors.has(creditSource.id)}" />
                                                                <span v-show="errors.has(creditSource.id)" class="error-font"></span>
                                                            </td>
                                                            <td><input :disabled="creditSource.isHistory" v-on:change="setTextBoxValueCost(plan,creditSource,1)" v-model="creditSource.selected" type="checkbox"></td>
                                                        </tr>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 2-->
                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="allocationTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">تاریخ نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCostAgrement">
                                                        <template v-for="creditSource in plan.ca_credit_source_has_allocation">
                                                            <tr class="table-row"  v-for="allocation in creditSource.allocation">
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{allocation.caLetterNumber}}</td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{allocation.caLetterDate}}</td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{$root.dispMoneyFormat(allocation.caSumOfReserved)}}
                                                                    <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'allocation' + allocation.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font">
                                                                            <div class="grid-x">
                                                                                <!--Table Start-->
                                                                                <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                    <table class="stack">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                            <td>{{plan.caLetterNumber}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                            <td>{{plan.caLetterDate}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                            <td v-show="plan.caProvinceOrNational == 0">استانی</td>
                                                                                            <td v-show="plan.cpProvinceOrNational == 1">ملی</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                            <td class="text-justify">{{plan.caDescription}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">طرح :</td>
                                                                                            <td class="text-justify">{{creditSource.credit_distribution_title.cdtIdNumber}} - {{creditSource.credit_distribution_title.cdtSubject}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">ردیف :</td>
                                                                                            <td class="text-justify">{{creditSource.credit_distribution_row.cdSubject}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">فصل :</td>
                                                                                            <td class="text-justify">{{creditSource.tiny_season.season_title.season.sSubject}} - {{creditSource.tiny_season.season_title.cstSubject}} - {{creditSource.tiny_season.ctsSubject}}</td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <!--Table Body End-->
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{$root.dispMoneyFormat(allocation.caSumOfFinancing)}}</td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{$root.dispMoneyFormat(allocation.caSumOfCommitment)}}</td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-center">{{$root.dispMoneyFormat(allocation.caSumOfCost)}}</td>
                                                                <td :data-toggle="'allocation' + allocation.id" class="text-justify">{{allocation.caDescription}}</td>
                                                                <td>
                                                                    <input :disabled="allocation.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan,allocation,2,allocation.amount)" style="margin-bottom:0px;" v-if="allocation.selected == true" type="text" v-model="allocation.amount" :value="allocation.amount" :name="allocation.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(allocation , 3)  + parseInt(allocation.amount , 10))" :class="{'input': true, 'error-border': errors.has(allocation.id)}"/>
                                                                    <span v-show="errors.has(allocation.id)" class="error-font"></span>
                                                                </td>
                                                                <td><input :disabled="allocation.isHistory" v-on:change="setTextBoxValueCost(plan,allocation,2)" v-model="allocation.selected" type="checkbox"></td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 3-->

                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="fundTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">تاریخ نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr  v-for="found in costFound">
                                                        <td class="text-center">{{found.caLetterNumber}}</td>
                                                        <td class="text-center">{{found.caLetterDate}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caSumOfReserved)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caSumOfFinancing)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caSumOfCommitment)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caSumOfCost)}}</td>
                                                        <td class="text-justify">{{found.caDescription}}</td>
                                                        <td>
                                                            <input :disabled="found.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(null,found,3,found.amount)" style="margin-bottom:0px;" v-if="found.selected == true" type="text" v-model="found.amount" :value="found.amount" :name="found.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(found , 3) + parseInt(found.amount , 10))" :class="{'input': true, 'error-border': errors.has(found.id)}" />
                                                            <span v-show="errors.has(found.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input  :disabled="found.isHistory" v-on:change="setTextBoxValueCost(null,found,3)" v-model="found.selected" type="checkbox"></td>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 4-->

                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ برآورد : <span class="btn-red"> {{$root.dispMoneyFormat(baseAmount)}} </span></p>
                                        </div>
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ تامین اعتبار : <span class="btn-red"> {{$root.dispMoneyFormat(costReservedAmount)}} </span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <div class="stacked-for-small button-group float-left">
                                                <button @click="reserveCostFinance()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-full-screen>
        <!-- Cost Credits Modal End -->

        <!-- Capital Assets Modal Start -->
        <modal-full-screen v-if="showCapitalAssetsModal" @close="showCapitalAssetsModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="capital_assets_tab_view">
                                <li class="tabs-title is-active"><a href="#caPlaneTab" aria-selected="true">طرح</a></li>
                                <li class="tabs-title"><a href="#caProjectTab">پروژه </a></li>
                                <li class="tabs-title"><a href="#caCreditDistributionResourcesTab">منابع تامین اعتبار </a></li>
                                <li class="tabs-title"><a href="#caAllocationTab">تخصیص </a></li>
                                <li class="tabs-title"><a href="#caFundTab">تنخواه </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="capital_assets_tab_view">
                                <div class="grid-x">
                                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                                        <span class="cost-label">مبالغ : ریال</span>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="caPlaneTab">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره طرح</th>
                                                    <th class="tbl-head-style-cell">مجموع تخصیص</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار شده</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr class="table-row"  v-for="plan in completeCapitalAssetsAgrement">
                                                        <td :data-toggle="'plan' + plan.id">{{plan.credit_distribution_title.cdtIdNumber}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfAllocation)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfReserved)}}
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'plan' + plan.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <!--Table Start-->
                                                                            <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                <table class="stack text-right">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                        <td>{{plan.capLetterNumber}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                        <td>{{plan.capLetterDate}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                        <td>{{plan.capLetterDate}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                        <td v-show="plan.capProvinceOrNational == 0">استانی</td>
                                                                                        <td v-show="plan.capProvinceOrNational == 1">ملی</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                        <td class="text-justify">{{plan.capDescription}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color"> طرح :</td>
                                                                                        <td>{{plan.credit_distribution_title.cdtIdNumber}} - {{plan.credit_distribution_title.cdtSubject}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">عنوان فصل بودجه:</td>
                                                                                        <td>{{plan.credit_distribution_title.budget_season.bsSubject}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شرح فصل بودجه:</td>
                                                                                        <td class="text-justify">{{plan.credit_distribution_title.budget_season.bsDescription}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="150" class="black-color">شرح طرح :</td>
                                                                                        <td class="text-justify">{{plan.credit_distribution_title.cdtDescription}}</td>
                                                                                    </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <!--Table Body End-->
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfFinancing)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfCommitment)}}</td>
                                                        <td :data-toggle="'plan' + plan.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfCost)}}</td>
                                                        <td :data-toggle="'plan' + plan.id">{{plan.capDescription}}</td>
                                                        <td>
                                                            <input :disabled="plan.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, plan, 0, plan.amount)" style="margin-bottom:0px;" v-if="plan.selected == true" type="text"  v-model="plan.amount" :value="plan.amount" :name="'plan'+plan.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(plan , 1) + parseInt(plan.amount , 10))" :class="{'input': true, 'error-border': errors.has('plan' + plan.id)}"/>
                                                            <span v-show="errors.has('plan'+plan.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="plan.isHistory" v-on:change="setTextBoxValueCap(plan,plan,0)" v-model="plan.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 1-->

                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="caProjectTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">عنوان</th>
                                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                                    <th class="tbl-head-style-cell">مجموع تخصیص</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <tr class="table-row" v-for="project in plan.capital_assets_project_has_credit_source">
                                                            <td :data-toggle="'project' + project.id">{{project.cpSubject}}</td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{project.cpCode}}</td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfAllocation)}}
                                                                <div class="clearfix tool-bar">
                                                                    <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true" data-h-offset="100px"  data-hover="true" data-hover-pane="true"  data-position="top" data-alignment="right" :id="'project' + project.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font">
                                                                            <div class="grid-x">
                                                                                <!--Table Start-->
                                                                                <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                    <table class="stack text-right">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">عنوان پروژه :</td>
                                                                                            <td>{{project.cpSubject}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">کد پروژه :</td>
                                                                                            <td>{{project.cpCode}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">تاریخ شروع پروژه :</td>
                                                                                            <td>{{project.cpStartYear}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">تاریخ پایان پروژه :</td>
                                                                                            <td>{{project.cpEndOfYear}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">پیشرفت فیزیکی پروژه :</td>
                                                                                            <td>{{project.cpPhysicalProgress}} <span> درصد</span></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">شرح پروژه :</td>
                                                                                            <td class="text-justify">{{project.cpDescription}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color"> طرح :</td>
                                                                                            <td>{{plan.credit_distribution_title.cdtIdNumber}} - {{plan.credit_distribution_title.cdtSubject}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">عنوان فصل بودجه:</td>
                                                                                            <td>{{plan.credit_distribution_title.budget_season.bsSubject}}</td>
                                                                                        </tr>
                                                                                        <tr class="text-justify">
                                                                                            <td width="150" class="black-color">شرح فصل بودجه:</td>
                                                                                            <td class="text-justify">{{plan.credit_distribution_title.budget_season.bsDescription}}</td>
                                                                                        </tr>
                                                                                        <tr class="text-justify">
                                                                                            <td width="150" class="black-color">شرح طرح :</td>
                                                                                            <td>{{plan.credit_distribution_title.cdtDescription}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                            <td>{{plan.capLetterNumber}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                            <td>{{plan.capLetterDate}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                            <td v-show="plan.capProvinceOrNational == 0">استانی</td>
                                                                                            <td v-show="plan.capProvinceOrNational == 1">ملی</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                            <td class="text-justify">{{plan.capDescription}}</td>
                                                                                        </tr>

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <!--Table Body End-->
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{$root.dispMoneyFormat(project.cpSumOfReserved)}}</td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{$root.dispMoneyFormat(project.cpSumOfFinancing)}}</td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{$root.dispMoneyFormat(project.cpSumOfCommitment)}}</td>
                                                            <td :data-toggle="'project' + project.id" class="text-center">{{$root.dispMoneyFormat(project.cpSumOfCost)}}</td>
                                                            <td :data-toggle="'project' + project.id">{{project.cpDescription}}</td>
                                                            <td>
                                                                <input :disabled="project.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, project, 1, project.amount)" style="margin-bottom:0px;" v-if="project.selected == true" type="text" v-model="project.amount"  :value="project.amount" :name="'project'+project.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(project , 2) + parseInt(project.amount , 10))" :class="{'input': true, 'error-border': errors.has('project'+project.id)}"/>
                                                                <span v-show="errors.has('project'+project.id)" class="error-font"></span>
                                                            </td>
                                                            <td><input :disabled="project.isHistory" v-on:change="setTextBoxValueCap(plan,project,1)" v-model="project.selected" type="checkbox"></td>
                                                        </tr>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 2-->

                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="caCreditDistributionResourcesTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره طرح</th>
                                                    <th class="tbl-head-style-cell">مجموع تخصیص</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <template v-for="project in plan.capital_assets_project_has_credit_source">
                                                            <tr class="table-row" v-for="creditSource in project.credit_source_has_allocation">
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{plan.credit_distribution_title.cdtIdNumber}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(plan.capSumOfAllocation)}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(creditSource.ccsSumOfReserved)}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(creditSource.ccsSumOfFinancing)}}
                                                                    <div class="clearfix tool-bar">
                                                                        <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true" data-h-offset="100px"  data-hover="true" data-hover-pane="true"  data-position="top" data-alignment="right" :id="'creditSource' + creditSource.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font">
                                                                                <div class="grid-x">
                                                                                    <!--Table Start-->
                                                                                    <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                        <table class="stack text-right">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">عنوان پروژه :</td>
                                                                                                <td>{{project.cpSubject}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">کد پروژه :</td>
                                                                                                <td>{{project.cpCode}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">نحوه انجام پروژه :</td>
                                                                                                <td>{{creditSource.how_to_run.htrSubject}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">تاریخ شروع پروژه :</td>
                                                                                                <td>{{project.cpStartYear}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">تاریخ پایان پروژه :</td>
                                                                                                <td>{{project.cpEndOfYear}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">پیشرفت فیزیکی پروژه :</td>
                                                                                                <td>{{project.cpPhysicalProgress}} <span> درصد</span></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">شرح پروژه :</td>
                                                                                                <td class="text-justify">{{project.cpDescription}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color"> طرح :</td>
                                                                                                <td>{{plan.credit_distribution_title.cdtIdNumber}} - {{plan.credit_distribution_title.cdtSubject}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">عنوان فصل بودجه:</td>
                                                                                                <td>{{plan.credit_distribution_title.budget_season.bsSubject}}</td>
                                                                                            </tr>
                                                                                            <tr class="text-justify">
                                                                                                <td width="150" class="black-color">شرح فصل بودجه:</td>
                                                                                                <td class="text-justify">{{plan.credit_distribution_title.budget_season.bsDescription}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">عنوان ریز فصل :</td>
                                                                                                <td>{{creditSource.tiny_season.catsSubject}}</td>
                                                                                            </tr>
                                                                                            <tr class="">
                                                                                                <td width="150" class="black-color">شرح ریز فصل :</td>
                                                                                                <td class="text-justify">{{creditSource.tiny_season.catsDescription}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">شرح طرح :</td>
                                                                                                <td class="text-justify">{{plan.credit_distribution_title.cdtDescription}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                                <td class="text-justify">{{plan.capLetterNumber}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                                <td>{{plan.capLetterDate}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                                <td>{{plan.capLetterDate}}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                                <td v-show="plan.capProvinceOrNational == 0">استانی</td>
                                                                                                <td v-show="plan.capProvinceOrNational == 1">ملی</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                                <td>{{plan.capDescription}}</td>
                                                                                            </tr>

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <!--Table Body End-->
                                                                                </div>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(creditSource.ccsSumOfCommitment)}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(creditSource.ccsSumOfCost)}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id" class="text-center">{{$root.dispMoneyFormat(creditSource.ccsAmount)}}</td>
                                                                <td :data-toggle="'creditSource' + creditSource.id">{{creditSource.ccsDescription}}</td>
                                                                <td>
                                                                    <input :disabled="creditSource.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, creditSource, 2, creditSource.amount)" style="margin-bottom:0px;" v-if="creditSource.selected == true" type="text" v-model="creditSource.amount"  :value="creditSource.amount" :name="'creditSource'+creditSource.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(creditSource , 3) + parseInt(creditSource.amount , 10))" :class="{'input': true, 'error-border': errors.has('creditSource'+creditSource.id)}" />
                                                                    <span v-show="errors.has('creditSource'+creditSource.id)" class="error-font"></span>
                                                                </td>
                                                                <td><input :disabled="creditSource.isHistory" v-on:change="setTextBoxValueCap(plan,creditSource,2)" v-model="creditSource.selected" type="checkbox"></td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 3-->


                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="caAllocationTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <template v-for="creditSource in plan.capital_assets_project_has_credit_source">
                                                            <template v-for="allocations in creditSource.credit_source_has_allocation">
                                                                <tr class="table-row" v-for="alloc in allocations.allocation">
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{alloc.caaLetterNumber}}</td>
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{$root.dispMoneyFormat(alloc.caaSumOfReserved)}}</td>
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{$root.dispMoneyFormat(alloc.caaSumOfFinancing)}}
                                                                        <div class="clearfix tool-bar">
                                                                            <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true" data-h-offset="100px" data-hover="true" data-hover-pane="true"  data-position="top" data-alignment="right" :id="'allocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                                <ul class="my-menu small-font">
                                                                                    <div class="grid-x">
                                                                                        <!--Table Start-->
                                                                                        <div class="tbl_body_style dynamic-height-level-modal2">
                                                                                            <table class="stack text-right">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">عنوان پروژه :</td>
                                                                                                    <td>{{creditSource.cpSubject}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">کد پروژه :</td>
                                                                                                    <td>{{creditSource.cpCode}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color"> طرح :</td>
                                                                                                    <td>{{plan.credit_distribution_title.cdtIdNumber}} - {{plan.credit_distribution_title.cdtSubject}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">عنوان فصل بودجه:</td>
                                                                                                    <td>{{plan.credit_distribution_title.budget_season.bsSubject}}</td>
                                                                                                </tr>
                                                                                                <tr class="text-justify">
                                                                                                    <td width="150" class="black-color">شرح فصل بودجه:</td>
                                                                                                    <td class="text-justify">{{plan.credit_distribution_title.budget_season.bsDescription}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">عنوان ریز فصل :</td>
                                                                                                    <td>{{allocations.tiny_season.catsSubject}}</td>
                                                                                                </tr>
                                                                                                <tr class="">
                                                                                                    <td width="150" class="black-color">شرح ریز فصل :</td>
                                                                                                    <td class="text-justify">{{allocations.tiny_season.catsDescription}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">شرح طرح :</td>
                                                                                                    <td class="text-justify">{{plan.credit_distribution_title.cdtDescription}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">شماره موافقتنامه :</td>
                                                                                                    <td class="text-justify">{{plan.capLetterNumber}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                                    <td>{{plan.capLetterDate}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">تاریخ موافقتنامه :</td>
                                                                                                    <td>{{plan.capLetterDate}}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">نوع موافقتنامه :</td>
                                                                                                    <td v-show="plan.capProvinceOrNational == 0">استانی</td>
                                                                                                    <td v-show="plan.capProvinceOrNational == 1">ملی</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="150" class="black-color">شرح موافقتنامه :</td>
                                                                                                    <td>{{plan.capDescription}}</td>
                                                                                                </tr>

                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <!--Table Body End-->
                                                                                    </div>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{$root.dispMoneyFormat(alloc.caaSumOfCommitment)}}</td>
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{$root.dispMoneyFormat(alloc.caaSumOfCost)}}</td>
                                                                    <td :data-toggle="'allocation' + alloc.id" class="text-center">{{$root.dispMoneyFormat(alloc.caaAmount)}}</td>
                                                                    <td :data-toggle="'allocation' + alloc.id" >{{alloc.caaDescription}}</td>
                                                                    <td>
                                                                        <input :disabled="alloc.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, alloc, 3, alloc.amount)" style="margin-bottom:0px;" v-if="alloc.selected == true" type="text" v-model="alloc.amount"  :value="alloc.amount" :name="'alloc'+alloc.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(alloc , 4) + parseInt(alloc.amount , 10))" :class="{'input': true, 'error-border': errors.has('alloc'+alloc.id)}" />
                                                                        <span v-show="errors.has('alloc'+alloc.id)" class="error-font"></span>
                                                                    </td>
                                                                    <td><input :disabled="alloc.isHistory" v-on:change="setTextBoxValueCap(plan,alloc,3)" v-model="alloc.selected" type="checkbox"></td>
                                                                </tr>
                                                            </template>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 4-->

                                <!--Tab 5-->
                                <div class="tabs-panel table-mrg-btm" id="caFundTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr v-for="found in capitalAssetsFound">
                                                        <td class="text-center">{{found.caaLetterNumber}}</td>
                                                        <td class="text-center">{{found.caaSumOfReserved}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caaSumOfFinancing)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caaSumOfCommitment)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caaSumOfCost)}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(found.caaAmount)}}</td>
                                                        <td>{{found.caaDescription}}</td>
                                                        <td>
                                                            <input :disabled="found.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(null, found, 4, found.amount)" style="margin-bottom:0px;" v-if="found.selected == true" type="text" v-model="found.amount"  :value="found.amount" :name="'found'+found.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(found , 4) + parseInt(found.amount , 10))" :class="{'input': true, 'error-border': errors.has('found'+found.id)}"/>
                                                            <span v-show="errors.has('found'+found.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="found.isHistory" v-on:change="setTextBoxValueCap(null,found,4)" v-model="found.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 5-->

                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ برآورد : <span class="btn-red"> {{$root.dispMoneyFormat(baseAmount)}} </span></p>
                                        </div>
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ تامین اعتبار : <span class="btn-red"> {{$root.dispMoneyFormat(capReservedAmount)}} </span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <div class="stacked-for-small button-group float-left">
                                                <button @click="reserveCapitalAssetsFinance()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-full-screen>
        <!-- Capital Assets Modal End -->

        <!-- delete Financing modal -->
        <modal-tiny v-if="showDeleteFinancingModal" @close="showDeleteFinancingModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deleteFinancing"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- delete Financing modal -->

        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>
    </div>


</template>
<script>

export default{
    props:['baseAmount','UserIsVerifier','requestFill','requestId','receiveRequests'],

    data () {
        return {
            showCostCreditsModal:false,
            showCapitalAssetsModal:false,
            requestCostFinancing:[],
            requestCapFinancing:[],
            acceptBtn:false,
            dialogMessage:'',
            showDialogModal:false,
            showDeleteFinancingModal:false,

            /*credits*/
            completeCostAgrement:[],
            costFound:[],
            costReservedAmount:0,
            capReservedAmount:0,
            lastCostReservedAmount:0,
            lastCapReservedAmount:0,
            amountInput:{},
            allocations:[],
            _financingAmount: 0,
            _reservedAmount: 0,
            /*credits*/

            /*capital assets*/
            completeCapitalAssetsAgrement:[],
            capitalAssetsFound:[],
            capitalAssetsAllocations:[],
            /*capital assets*/

            delId:'',
            deleteType:'',
        }

    },

    created: function () {
        $(this.$el).foundation(); //WORKS!
        this.fetchRequestFinancing();

    },
    updated: function () {
        $(this.$el).foundation(); //WORKS!
        this.myResizeModal();
    },

    mounted: function () {

    },

    methods : {
        fetchRequestFinancing: function (){
            axios.get('/financial/request/financing' , {params:{rId:this.requestId}})
                .then((response) => {
                    this.requestCostFinancing = response.data.costFinancing;
                    this.requestCapFinancing = response.data.capFinancing;
                    this.checkAcceptFinancingVisible();
                    this.getFinancingAmount();
                    console.log(this.requestCostFinancing);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });
        },

        getCompleteCostAgrement: function () {
            axios.get('/budget/approved_plan/cost/fetchCompleteData')
                .then((response) => {
                    this.completeCostAgrement = response.data.costAgreement;
                    this.costFound = response.data.costFound;

                    this.addNewFieldInCollection();
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });

        },

        addNewFieldInCollection:function(){
            this.completeCostAgrement.forEach(cost => {
                Vue.set(cost,"selected",false);
                Vue.set(cost,"amount",0);
                Vue.set(cost,"isHistory",false);
                cost.ca_credit_source_has_allocation.forEach(cs =>{
                    Vue.set(cs,"selected",false);
                    Vue.set(cs,"amount",0);
                    Vue.set(cs,"isHistory",false);
                    cs.allocation.forEach(alloc =>{
                        var isExist = false;
                        var tempAmount = 0;
                        this.requestCostFinancing.forEach(costFin => {
                            if (costFin.allocation.id == alloc.id)
                            {
                                isExist = true;
                                tempAmount = costFin.cfAmount;
                                costFin.stop = true;
                            }
                        });
                        if (isExist)
                        {
                            Vue.set(alloc,"selected",true);
                            Vue.set(alloc,"amount",tempAmount);
                            Vue.set(alloc,"isHistory",true);
                        }else{
                            Vue.set(alloc,"selected",false);
                            Vue.set(alloc,"amount",0);
                            Vue.set(alloc,"isHistory",false);
                        }
                    });
                });
            });

            this.completeCostAgrement.forEach(ca => {
                this.calculationOfCostCreditEdit(ca);
            });

            this.costFound.forEach(found => {
                var isExist = false;
                var tempAmount = 0;
                this.requestCostFinancing.forEach(costFin => {
                    if (costFin.allocation.id == found.id)
                    {
                        isExist = true;
                        tempAmount = costFin.cfAmount;
                        costFin.stop = true;
                    }
                });
                if (isExist)
                {
                    Vue.set(found,"selected",true);
                    Vue.set(found,"amount",tempAmount);
                    Vue.set(found,"isHistory",true);

                }else{
                    Vue.set(found,"selected",false);
                    Vue.set(found,"amount",0);
                    Vue.set(found,"isHistory",false);
                }
            });

            this.calculateCostReservedAmount();
        },

        getCompleteCapitalAssetsApproved: function () {
            axios.get('/budget/approved_plan/capital_assets/fetchCompleteData')
                .then((response) => {
                    this.completeCapitalAssetsAgrement = response.data.caApprovedPlan;
                    this.capitalAssetsFound = response.data.capFound;
                    this.addNewFieldInCapitalAssetsCollection();
                    console.log(JSON.stringify(this.completeCapitalAssetsAgrement));
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });
        },

        addNewFieldInCapitalAssetsCollection:function(){
            this.completeCapitalAssetsAgrement.forEach(ca => {
                Vue.set(ca,"selected",false);
                Vue.set(ca,"amount",0);
                Vue.set(ca,"isHistory",false);
                ca.capital_assets_project_has_credit_source	.forEach(project =>{
                    Vue.set(project,"selected",false);
                    Vue.set(project,"amount",0);
                    Vue.set(project,"isHistory",false);
                    project.credit_source_has_allocation.forEach(cs =>{
                        Vue.set(cs,"selected",false);
                        Vue.set(cs,"amount",0);
                        Vue.set(cs,"isHistory",false);
                        cs.allocation.forEach(alloc =>{
                            var isExist = false;
                            var tempAmount = 0;
                            this.requestCapFinancing.forEach(capFin => {
                                if (capFin.allocation.id == alloc.id)
                                {
                                    isExist = true;
                                    tempAmount = capFin.cafAmount;
                                    capFin.stop = true;
                                }
                            });
                            if (isExist)
                            {
                                Vue.set(alloc,"selected",true);
                                Vue.set(alloc,"amount",tempAmount);
                                Vue.set(alloc,"isHistory",true);
                            }else{
                                Vue.set(alloc,"selected",false);
                                Vue.set(alloc,"amount",0);
                                Vue.set(alloc,"isHistory",false);
                            }
                        });
                    });
                });
            });

            this.completeCapitalAssetsAgrement.forEach(ca => {
                this.calculationOfCapCreditEdit(ca);
            });

            this.capitalAssetsFound.forEach(found => {
                var isExist = false;
                var tempAmount = 0;
                this.requestCapFinancing.forEach(capFin => {
                    if (capFin.allocation.id == found.id)
                    {
                        isExist = true;
                        tempAmount = capFin.cafAmount;
                        capFin.stop = true;
                    }
                });
                if (isExist)
                {
                    Vue.set(found,"selected",true);
                    Vue.set(found,"amount",tempAmount);
                    Vue.set(found,"isHistory",true);
                }else{
                    Vue.set(found,"selected",false);
                    Vue.set(found,"amount",0);
                    Vue.set(found,"isHistory",false);
                }
            });

            this.calculateCapReservedAmount();
        },

        openCostCreditsModal:function () {
            this.completeCostAgrement= [];
            this.costFound = [];
            this.costReservedAmount = 0;
            if (this.UserIsVerifier.length == 0 && (this.requestFill.rLetterNumber != '' && this.requestFill.rLetterDate != ''))
            {
                this.getFinancingAmount();
                this.getCompleteCostAgrement();
                this.showCostCreditsModal=true;
            }else{
                this.dialogMessage = 'با توجه به اینکه درخواست تایید نهایی یا ثبت دبیرخانه نشده است! امکان تامین اعتبار وجود ندارد.';
                this.showDialogModal = true;
            }
        },

        openCapitalAssetsModal:function () {
            this.completeCapitalAssetsAgrement = [];
            this.capitalAssetsFound = [];
            this.capReservedAmount = 0;
            if (this.UserIsVerifier.length == 0 && (this.requestFill.rLetterNumber != '' && this.requestFill.rLetterDate != ''))
            {
                this.getFinancingAmount();
                this.getCompleteCapitalAssetsApproved ();
                this.showCapitalAssetsModal=true;
            }else{
                this.dialogMessage = 'با توجه به اینکه درخواست تایید نهایی یا ثبت دبیرخانه نشده است! امکان تامین اعتبار وجود ندارد.';
                this.showDialogModal = true;
            }
        },

        getFinancingAmount: function(){
            this._financingAmount = 0;
            this._reservedAmount = 0;
            this.lastCostReservedAmount = 0;
            this.lastCapReservedAmount = 0;
            this.requestCapFinancing.forEach(item => {
                if (item.cafAccepted == 1)
                    this._financingAmount += parseInt(item.cafAmount , 10);
                else
                {
                    this._reservedAmount += parseInt(item.cafAmount , 10);
                }
                this.lastCapReservedAmount += parseInt(item.cafAmount , 10);
            });

            this.requestCostFinancing.forEach(item => {
                if (item.cfAccepted == 1)
                    this._financingAmount += parseInt(item.cfAmount , 10);
                else
                    this._reservedAmount += parseInt(item.cfAmount , 10);

                this.lastCostReservedAmount += parseInt(item.cfAmount , 10);
            });
        },

        /////////////////////// cost financing //////////////////////////////
        calculationOfCostCredit: function(rootData,data,type,value){
            var aCount=0;
            var piceOfAmount=0;
            var piceOfDivRemAmount=0;
            var allocIsNotExist = true;
            if (!isNaN(value))
            {
                if(type == 0){ //plan level
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        aCount += cs.allocation.length;
                    });
                    piceOfAmount = (value / aCount) >> 0;
                    piceOfDivRemAmount = value % aCount;
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        cs.selected = true;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            var remainingAmount = parseInt(alloc.caAmount) - (parseInt(alloc.caSumOfCost) + parseInt(alloc.caSumOfReserved) + parseInt(alloc.caSumOfFinancing) + parseInt(alloc.caSumOfCommitment));
                            if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                piceOfDivRemAmount = 0;
                                allocIsNotExist = false;
                            }
                            else if (remainingAmount >= piceOfAmount){
                                alloc.amount = piceOfAmount;
                                allocIsNotExist = false;
                            }else{
                                if (remainingAmount <= 0)
                                {
                                    alloc.amount = 0;
                                }else{
                                    alloc.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                            console.log(JSON.stringify(alloc));
                        });
                    });
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();

                }
                else if(type == 1){ //credit source level
                    aCount = data.allocation.length;
                    piceOfAmount = (value / aCount)  >> 0;
                    piceOfDivRemAmount = value % aCount;
                    data.allocation.forEach( alloc =>{
                        alloc.selected = true;
                        var remainingAmount = parseInt(alloc.caAmount) - (parseInt(alloc.caSumOfCost) + parseInt(alloc.caSumOfReserved) + parseInt(alloc.caSumOfFinancing) + parseInt(alloc.caSumOfCommitment));
                        if (remainingAmount > 0) {
                            if (remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                piceOfDivRemAmount = 0;
                                allocIsNotExist = false;
                            }
                            else if (remainingAmount >= piceOfAmount) {
                                alloc.amount = piceOfAmount;
                                allocIsNotExist = false;
                            } else {
                                if (remainingAmount <= 0)
                                {
                                    alloc.amount = 0;
                                }else{
                                    alloc.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                        }
                    });
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();
                }
                else if(type == 2){ //allocation level
                    data.selected = true;
                    var remainingAmount = parseInt(data.caAmount) - (parseInt(data.caSumOfCost) + parseInt(data.caSumOfReserved) + parseInt(data.caSumOfFinancing) + parseInt(data.caSumOfCommitment));
                    if (remainingAmount > 0) {
                        if (remainingAmount >= value) {
                            data.amount = value;
                            allocIsNotExist = false;
                        }
                        else {
                            if (remainingAmount <= 0)
                            {
                                data.amount = 0;
                            }else{
                                data.amount = remainingAmount;
                                allocIsNotExist = false;
                            }
                        }
                    }
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();
                }else if(type == 3) //found level
                {
                    data.selected = true;
                    var remainingAmount = parseInt(data.caAmount) - (parseInt(data.caSumOfCost) + parseInt(data.caSumOfReserved) + parseInt(data.caSumOfFinancing) + parseInt(data.caSumOfCommitment));
                    if (remainingAmount > 0)
                    {
                        if(remainingAmount >= value) {
                            data.amount = value;
                            allocIsNotExist = false;
                        }
                        else{
                            if (remainingAmount <= 0)
                            {
                                data.amount = 0;
                            }else{
                                data.amount = remainingAmount;
                                allocIsNotExist = false;
                            }
                        }
                    }

                    if (data.amount == 0)
                    {
                        data.amount = 0;
                        data.selected = false;
                    }
                    this.calculateCostReservedAmount();
                }else{
                    allocIsNotExist = false;
                }

                if (allocIsNotExist)
                    this.$root.displayNotif(1);
            }
        },

        calculationOfCostCreditEdit: function(data){
            var sumOfPlanAmount=0;
            var csIsHistory = false;
            if (data != null)
            {
                data.ca_credit_source_has_allocation.forEach(cs => {
                    var sumOfAlloc= 0 ;
                    var isHistory = false;
                    cs.allocation.forEach( alloc =>{
                        sumOfAlloc += parseInt(alloc.amount , 10);
                        if (parseInt(alloc.amount , 10) != 0)
                            alloc.selected = true;
                        else
                            alloc.selected = false;

                        if (alloc.isHistory)
                            isHistory = true;
                    });
                    cs.amount = sumOfAlloc;
                    cs.isHistory = isHistory;
                    sumOfPlanAmount += sumOfAlloc;
                    if (sumOfAlloc != 0)
                        cs.selected = true;
                    else
                        cs.selected = false;

                    if (isHistory)
                        csIsHistory = isHistory;
                });
                if (sumOfPlanAmount != 0)
                    data.selected = true;
                else
                    data.selected = false;
                data.amount = sumOfPlanAmount;
                data.isHistory = csIsHistory;
                console.log(JSON.stringify(data));
            }
        },

        setTextBoxValueCost: function (rootData,data,type) {
            if (data.selected == true)
            {
                this.calculationOfCostCredit(rootData,data,type,(this.baseAmount - this.costReservedAmount));
            }else{
                if (type == 0)
                {
                    data.amount = 0;
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        cs.selected = false;
                        cs.amount = 0;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = false;
                            alloc.amount = 0;
                        });
                    });
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();
                }else if (type == 1)
                {
                    data.amount = 0;
                    cs.allocation.forEach( alloc =>{
                        alloc.selected = true;
                        alloc.amount = 0;
                    });
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();
                }else if (type == 2)
                {
                    data.amount = 0;
                    data.selected = false;
                    this.calculationOfCostCreditEdit(rootData);
                    this.calculateCostReservedAmount();
                } else if (type == 3)
                {
                    data.amount = 0;
                    data.selected = false;
                    this.calculateCostReservedAmount();
                }
            }

        },

        ///////////////////// capital assets fainancing /////////////////////////////
        calculationOfCapCredit: function(rootData,data,type,value){
            var aCount=0;
            var piceOfAmount=0;
            var piceOfDivRemAmount=0;
            var allocIsNotExist = true;

            if (!isNaN(value))
            {
                if(type == 0){ //plan level
                    data.capital_assets_project_has_credit_source.forEach(project => {
                        project.credit_source_has_allocation.forEach(cs => {
                            aCount += cs.allocation.length;
                        });
                    });
                    piceOfAmount = (value / aCount) >> 0;
                    piceOfDivRemAmount = value % aCount;
                    data.capital_assets_project_has_credit_source.forEach(project => {
                        project.selected = true;
                        project.credit_source_has_allocation.forEach(cs => {
                            cs.selected = true;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = true;
                                var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                                if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                    alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                    piceOfDivRemAmount = 0;
                                    allocIsNotExist = false;
                                }
                                else if (remainingAmount >= piceOfAmount){
                                    alloc.amount = piceOfAmount;
                                    allocIsNotExist = false;
                                }else{
                                    if (remainingAmount <= 0)
                                    {
                                        alloc.amount = 0;
                                    }else{
                                        alloc.amount = remainingAmount;
                                        allocIsNotExist = false;
                                    }
                                }
                                console.log(JSON.stringify(alloc));
                            });
                        });
                    });
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }
                else if(type == 1){ //credit source level
                    data.credit_source_has_allocation.forEach(cs => {
                        aCount += cs.allocation.length;
                    });
                    piceOfAmount = (value / aCount)  >> 0;
                    piceOfDivRemAmount = value % aCount;
                    data.credit_source_has_allocation.forEach(cs => {
                        cs.selected = true;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                            if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                piceOfDivRemAmount = 0;
                                allocIsNotExist = false;
                            }
                            else if (remainingAmount >= piceOfAmount){
                                alloc.amount = piceOfAmount;
                                allocIsNotExist = false;
                            }else{
                                if (remainingAmount <= 0)
                                {
                                    alloc.amount = 0;
                                }else{
                                    alloc.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                            console.log(JSON.stringify(alloc));
                        });
                    });
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }
                else if(type == 2) { //allocation level
                    aCount += data.allocation.length;
                    piceOfAmount = (value / aCount)  >> 0;
                    piceOfDivRemAmount = value % aCount;
                    data.allocation.forEach( alloc =>{
                        alloc.selected = true;
                        var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                        if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                            alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                            piceOfDivRemAmount = 0;
                            allocIsNotExist = false;
                        }
                        else if (remainingAmount >= piceOfAmount){
                            alloc.amount = piceOfAmount;
                            allocIsNotExist = false;
                        }else{
                            if (remainingAmount <= 0)
                            {
                                alloc.amount = 0;
                            }else{
                                alloc.amount = remainingAmount;
                                allocIsNotExist = false;
                            }
                        }
                        console.log(JSON.stringify(alloc));
                    });

                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }
                else if(type == 3){ //allocation level
                    data.selected = true;
                    var remainingAmount = parseInt(data.caaAmount) - (parseInt(data.caaSumOfCost) + parseInt(data.caaSumOfReserved) + parseInt(data.caaSumOfFinancing) + parseInt(data.caaSumOfCommitment));
                    if (remainingAmount > 0) {
                        if (remainingAmount >= value) {
                            data.amount = value;
                            allocIsNotExist = false;
                        }
                        else {
                            if (remainingAmount <= 0)
                            {
                                data.amount = 0;
                            }else{
                                data.amount = remainingAmount;
                                allocIsNotExist = false;
                            }
                        }
                    }
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }else if(type == 4) //found level
                {
                    data.selected = true;
                    var remainingAmount = parseInt(data.caaAmount) - (parseInt(data.caaSumOfCost) + parseInt(data.caaSumOfReserved) + parseInt(data.caaSumOfFinancing) + parseInt(data.caaSumOfCommitment));
                    if (remainingAmount > 0)
                    {
                        if(remainingAmount >= value) {
                            data.amount = value;
                            allocIsNotExist = false;
                        }
                        else{
                            if (remainingAmount <= 0)
                            {
                                data.amount = 0;
                            }else{
                                data.amount = remainingAmount;
                                allocIsNotExist = false;
                            }
                        }
                    }

                    if (data.amount == 0)
                    {
                        data.amount = 0;
                        data.selected = false;
                    }
                    this.calculateCapReservedAmount();
                }else{
                    allocIsNotExist = false;
                }

                if (allocIsNotExist)
                    this.$root.displayNotif(1);
            }
        },

        calculateCostReservedAmount: function(){
            this.costReservedAmount = this.lastCapReservedAmount; // sum with last cap
            this.completeCostAgrement.forEach(plan => {
                plan.ca_credit_source_has_allocation.forEach(cs => {
                    cs.allocation.forEach( alloc =>{
                        this.costReservedAmount += parseInt(alloc.amount , 10);
                    });
                });
            });

            this.costFound.forEach(found => {
                this.costReservedAmount += parseInt(found.amount , 10);
            });
        },

        calculateCapReservedAmount: function(){
            this.capReservedAmount = this.lastCostReservedAmount; // sum with last cost
            this.completeCapitalAssetsAgrement.forEach(plan => {
                plan.capital_assets_project_has_credit_source.forEach(project => {
                    project.credit_source_has_allocation.forEach(cs => {
                        cs.allocation.forEach( alloc =>{
                            this.capReservedAmount += parseInt(alloc.amount , 10);
                        });
                    });
                });
            });


            this.capitalAssetsFound.forEach(found => {
                this.capReservedAmount += parseInt(found.amount , 10);
            });
        },

        calculationOfCapCreditEdit: function(data){
            var sumOfProjectAmount=0;
            var sumOfCsAmount=0;
            var projectIsHistory = false;
            var csIsHistory = false;

            if (data != null)
            {
                data.capital_assets_project_has_credit_source.forEach(project => {
                    sumOfCsAmount=0;
                    project.credit_source_has_allocation.forEach(cs => {
                        var sumOfAlloc= 0 ;
                        var isHistory = false;
                        cs.allocation.forEach( alloc =>{
                            sumOfAlloc += parseInt(alloc.amount , 10);
                            if (parseInt(alloc.amount , 10) != 0)
                                alloc.selected = true;
                            else
                                alloc.selected = false;

                            if (alloc.isHistory == true)
                                isHistory = true;
                        });
                        cs.isHistory = isHistory;
                        cs.amount = sumOfAlloc;
                        sumOfCsAmount += sumOfAlloc;
                        if (sumOfAlloc != 0)
                            cs.selected = true;
                        else
                            cs.selected = false;

                        if (isHistory)
                            csIsHistory = isHistory;
                    });
                    project.amount = sumOfCsAmount;
                    project.isHistory = csIsHistory;
                    sumOfProjectAmount += sumOfCsAmount;
                    if (sumOfCsAmount != 0)
                        project.selected = true;
                    else
                        project.selected = false;

                    if (csIsHistory)
                        projectIsHistory = csIsHistory;
                });

                if (sumOfProjectAmount != 0)
                    data.selected = true;
                else
                    data.selected = false;
                data.amount = sumOfProjectAmount;
                if (projectIsHistory)
                    data.isHistory = projectIsHistory;
                console.log(JSON.stringify(data));
            }
        },

        setTextBoxValueCap: function (rootData,data,type) {
            if (data.selected == true)
            {
                this.calculationOfCapCredit(rootData,data,type,this.baseAmount - this.capReservedAmount);
            }else{
                if (type == 0)
                {
                    data.amount = 0;
                    data.capital_assets_project_has_credit_source.forEach(project => {
                        project.selected = false;
                        project.amount = 0;
                        project.credit_source_has_allocation.forEach(cs => {
                            cs.selected = false;
                            cs.amount = 0;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = false;
                                alloc.amount = 0;
                            });
                        });
                    });
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }else if (type == 1)
                {
                    data.amount = 0;
                    data.credit_source_has_allocation.forEach(cs => {
                        cs.selected = false;
                        cs.amount = 0;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = false;
                            alloc.amount = 0;
                        });
                    });
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }else if (type == 2)
                {
                    data.amount = 0;
                    data.allocation.forEach(cs => {
                        alloc.selected = false;
                        alloc.amount = 0;
                    });
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                }else if (type == 3)
                {
                    data.amount = 0;
                    data.selected = false;
                    this.calculationOfCapCreditEdit(rootData);
                    this.calculateCapReservedAmount();
                } else if (type == 4)
                {
                    data.amount = 0;
                    data.selected = false;
                    this.calculateCapReservedAmount();
                }
            }

        },

        reserveCostFinance: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    var costFinancing= [];
                    this.completeCostAgrement.forEach(cost => {
                        cost.ca_credit_source_has_allocation.forEach(alloc =>{
                            alloc.allocation.forEach(item =>{
                                if(item.selected == true){
                                    var obj={};
                                    Vue.set(obj,"aId",item.id);
                                    Vue.set(obj,"amount",item.amount);
                                    costFinancing.push(obj);
                                }
                            });
                        });
                    });

                    this.costFound.forEach(found => {
                        if(found.selected == true) {
                            var obj = {};
                            Vue.set(obj, "aId", found.id);
                            Vue.set(obj, "amount", found.amount);
                            costFinancing.push(obj);
                        }
                    });
                    console.log(JSON.stringify(costFinancing));
                    axios.post('/financial/request/financing/reservation', {
                        rId: this.requestId,
                        costFinancing: costFinancing,
                    }).then((response) => {
                        this.requestCostFinancing = response.data.costFinancing;
                        this.showCostCreditsModal = false;
                        this.$root.displayNotif(response.status);
                        this.getFinancingAmount();
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                        this.$root.displayNotif(error.response.status);
                    });
                }
            });
        },

        reserveCapitalAssetsFinance: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    var capitalAssetsFinancing= [];
                    this.completeCapitalAssetsAgrement.forEach(ca => {
                        ca.capital_assets_project_has_credit_source	.forEach(project =>{
                            project.credit_source_has_allocation.forEach(cs =>{
                                cs.allocation.forEach(alloc => {
                                    if (alloc.selected == true) {
                                        var obj = {};
                                        Vue.set(obj, "aId", alloc.id);
                                        Vue.set(obj, "amount", alloc.amount);
                                        capitalAssetsFinancing.push(obj);
                                    }

                                });
                            });
                        });
                    });
                    this.capitalAssetsFound.forEach(found => {
                        if(found.selected == true) {
                            var obj = {};
                            Vue.set(obj, "aId", found.id);
                            Vue.set(obj, "amount", found.amount);
                            capitalAssetsFinancing.push(obj);
                        }
                    });
                    console.log(JSON.stringify(capitalAssetsFinancing));
                    axios.post('/financial/request/financing/reservation', {
                        rId: this.requestId,
                        capFinancing: capitalAssetsFinancing,
                    }).then((response) => {
                        this.requestCapFinancing = response.data.capFinancing;
                        this.showCapitalAssetsModal = false;
                        this.$root.displayNotif(response.status);
                        this.getFinancingAmount();
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                        this.$root.displayNotif(error.response.status);
                    });
                }
            });
        },

        getRemainingCostAmount: function (data, type) {
            var remainingAmount= 0;
            if (type == 1)
            {
                data.ca_credit_source_has_allocation.forEach(alloc =>{
                    alloc.allocation.forEach(item =>{
                        remainingAmount = item.caAmount - (parseInt(item.caSumOfCost , 10) + parseInt(item.caSumOfReserved , 10) + parseInt(item.caSumOfFinancing , 10) + parseInt(item.caSumOfCommitment , 10));

                    });
                });
            }else if(type == 2)
            {
                data.allocation.forEach(item =>{
                    remainingAmount = item.caAmount - (parseInt(item.caSumOfCost , 10) + parseInt(item.caSumOfReserved , 10) + parseInt(item.caSumOfFinancing , 10) + parseInt(item.caSumOfCommitment , 10));
                });
            }else if(type == 3){
                remainingAmount = data.caAmount - (parseInt(data.caSumOfCost , 10) + parseInt(data.caSumOfReserved , 10) + parseInt(data.caSumOfFinancing , 10) + parseInt(data.caSumOfCommitment , 10));
            }

            var temp = (this.baseAmount - this.costReservedAmount);
            return  (remainingAmount < temp ? remainingAmount : temp);
        },

        getRemainingCapitalAssetsAmount: function (data, type) {
            var remainingCapAmount= 0;
            if (type == 1)
            {
                data.capital_assets_project_has_credit_source.forEach(project =>{
                    project.credit_source_has_allocation.forEach(cs => {
                        cs.allocation.forEach(alloc => {
                            remainingCapAmount += alloc.caaAmount - (parseInt(alloc.caaSumOfCost ,10) + parseInt(alloc.caaSumOfReserved , 10)+ parseInt(alloc.caaSumOfFinancing , 10) + parseInt(alloc.caaSumOfCommitment , 10));
                        });
                    });
                });
            }else if(type == 2)
            {
                data.credit_source_has_allocation.forEach(cs => {
                    cs.allocation.forEach(alloc => {
                        remainingCapAmount += alloc.caaAmount - (parseInt(alloc.caaSumOfCost ,10) + parseInt(alloc.caaSumOfReserved , 10)+ parseInt(alloc.caaSumOfFinancing , 10) + parseInt(alloc.caaSumOfCommitment , 10));
                    });
                });

            }else if(type == 3){
                data.allocation.forEach(alloc => {
                    remainingCapAmount += alloc.caaAmount - (parseInt(alloc.caaSumOfCost , 10) + parseInt(alloc.caaSumOfReserved , 10) + parseInt(alloc.caaSumOfFinancing , 10) + parseInt(alloc.caaSumOfCommitment));
                });
            }else if(type == 4){
                remainingCapAmount += data.caaAmount - (parseInt(data.caaSumOfCost , 10) + parseInt(data.caaSumOfReserved , 10) + parseInt(data.caaSumOfFinancing,10) + parseInt(data.caaSumOfCommitment , 10));
            }

            var temp = (this.baseAmount - this.capReservedAmount);
            return  (remainingCapAmount < temp ? remainingCapAmount : temp);
        },

        checkAcceptFinancingVisible:function(){
            this.requestCostFinancing.forEach(item =>{
                if(item.cfAccepted == 0){
                    this.acceptBtn=true;
                }
            });

            this.requestCapFinancing.forEach(item =>{
                if(item.cafAccepted == 0){
                    this.acceptBtn=true;
                }
            });

            /*if(((this._reservedAmount + this._financingAmount) - this.$parent.baseAmount) != 0){
                this.acceptBtn=
            }*/
        },

        acceptFinancing: function(){
            if(((this._reservedAmount + this._financingAmount) - this.baseAmount) != 0 || (this.requestCostFinancing.length < 0 && this.requestCapFinancing.length < 0)){
                this.dialogMessage = 'تامین اعتبار به طور کامل انجام نشده است. لطفا به امور مالی ارجاع نمایید.';
                this.showDialogModal=true;
            }
            else {
                axios.post('/financial/request/financing/accept', {
                    rId: this.requestId,
                }).then((response) => {
                    this.receiveRequests = response.data.data;
                    this.$emit('closeModal');
                    this.$root.displayNotif(response.status);
                    this.getFinancingAmount();
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            }

        },

        openDeleteFinancingModal:function(item,type){
          this.showDeleteFinancingModal=true;
          this.delId=item.id;
          this.deleteType=type;

        },

        deleteFinancing:function(){
            if(this.deleteType == 1){
                axios.post('/financial/request/financing/cap/delete', {
                    id:this.delId,
                    rId:this.requestId,
                }).then((response) => {
                    if (response.status != 204) {
                        this.requestCapFinancing = response.data.capFinancing;
                        this.getFinancingAmount();
                    }
                    this.showDeleteFinancingModal = false;
                    console.log(response);
                    this.$root.displayNotif(response.status);
                }, (error) => {
                });

            }
            if(this.deleteType == 2){
                axios.post('/financial/request/financing/cost/delete', {
                    id:this.delId,
                    rId:this.requestId,
                }).then((response) => {
                    if (response.status != 204) {
                        this.requestCostFinancing = response.data.costFinancing;
                        this.getFinancingAmount();

                    }
                    this.showDeleteFinancingModal = false;
                    console.log(response);
                    this.$root.displayNotif(response.status);
                }, (error) => {
                });
            }

        },

        myResizeModal: function() {
            var x = $.w.outerHeight();
            $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
            $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
            $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
        },
    }
}
</script>
