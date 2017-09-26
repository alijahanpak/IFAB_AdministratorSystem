@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li>
                                <a class="disabled">تخصیص اعتبار</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>استانی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="registerOfCreditAllocationAssets" class="grid-x dashboard-padding">
            @include('budget::pages.register_of_credit_allocation_assets.forms')
            <div  class="medium-12 column my-callout dynamic-height-level1">
                <div id="dynamicParentId1">
                <div class="clearfix border-btm-line bottom-mrg">
                    <div class="button-group float-left report-mrg">
                        <a  class="clear button" id="show-modal" @click="showModal = true; errorMessage = ''" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                            <i class="fi-plus size-30 secondry-color"></i>
                        </a>
                        <a  class="clear button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                            <i class="fi-clipboard-notes size-30 secondry-color"></i>
                        </a>
                    </div>
                    <div class="float-right">
                        <div class="input-group float-left">
                            <input class="input-group-field small-font" type="text">
                            <div class="input-group-button">
                                <button type="button" class="my-secondary button"><i class="fi-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Table Start-->
                <div class="columns">
                    <!--Header Start-->
                    <div class="grid-x table-header">
                        <div class="medium-2 table-border">
                            <strong>طرح</strong>
                        </div>
                        <div class="medium-10">
                            <div class="grid-x">
                                <div class="medium-2 table-border">
                                    <strong>پروژه</strong>
                                </div>
                                <div class="medium-8">
                                    <div class="grid-x">
                                        <div class="medium-6 table-border">
                                            <strong>ردیف اعتبار</strong>
                                        </div>
                                        <div class="medium-2 table-border">
                                            <strong>شماره</strong>
                                        </div>
                                        <div class="medium-2 table-border">
                                            <strong>تاریخ</strong>
                                        </div>
                                        <div class="medium-2  table-border">
                                            <strong>مبلغ</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>سرجمع</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Header End-->
                    <div class="table-contain dynamic-height-level2">
                        <div class="grid-x row-bottom-border" v-for="project in registerOfCreditAllocationAssets">
                            <div class="medium-2 table-contain-border1 cell-vertical-center">
                               @{{ project.rocaaPlan }}
                            </div>
                            <div class="medium-10">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center" v-for="registerOfCreditAllocationAssets in project.register_of_credit_allocation_assets">
                                        @{{ registerOfCreditAllocationAssets.rocaaProject }}
                                    </div>
                                    <div class="medium-8">
                                        <div class="grid-x">
                                            <div class="medium-6 table-contain-border cell-vertical-center">
                                                @{{ registerOfCreditAllocationAssets.rocaaRow }}                                 سه درصدنفت وگاز
                                            </div>
                                            <div class="medium-2 table-contain-border cell-vertical-center">
                                                @{{ registerOfCreditAllocationAssets.rocaaNumber }}
                                            </div>
                                            <div class="medium-2 table-contain-border cell-vertical-center">
                                                @{{ registerOfCreditAllocationAssets.rocaaDate }}
                                            </div>
                                            <div class="medium-2  table-contain-border cell-vertical-center">
                                                123456
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-right: 1px solid #C7CDD1;" class="medium-2 table-contain-border1 cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">
                                                @{{ tinySeason.tsDescription }}
                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rocaaRegisterOfCreditAllocationAssets' + registerOfCreditAllocationAssets.id"><img width="15px" height="15px" src="{{ asset('pic/menu.svg') }}"></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rocaaRegisterOfCreditAllocationAssets' + registerOfCreditAllocationAssets.id" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a v-on:click.prevent="registerOfCreditAllocationAssetsUpdateDialog(tinySeason , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a v-on:click.prevent="openDeleteRegisterOfCreditAllocationAssetsConfirm(registerOfCreditAllocationAssets)"><i class="fi-trash size-16"></i>  حذف</a></li>
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
        </div>
    </div>
    </div>
@stop

