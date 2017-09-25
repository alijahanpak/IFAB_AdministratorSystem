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
                                            <strong>تاریخ</strong>
                                        </div>
                                        <div class="medium-2 table-border">
                                            <strong>شماره</strong>
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
                        <div style="border-bottom: 1px solid #C7CDD1;margin-bottom: -1px !important;padding-bottom: -1px !important;"  class="grid-x">
                            <div class="medium-2 table-contain-border1 cell-vertical-center">
                                1704002087- مطالفه و حفظ و احیا میراث فرهنگی شهرستان همدان
                            </div>
                            <div class="medium-10">
                                <div class="grid-x">
                                    <div class="medium-2 table-contain-border cell-vertical-center">
                                       951047- مرمت مسجدمرمت مسجد جامع همدان جامع همدان
                                    </div>
                                    <div class="medium-8">
                                        <div class="grid-x">
                                            <div class="medium-6 table-contain-border cell-vertical-center">
                                                سه درصدنفت وگاز
                                            </div>
                                            <div class="medium-2 table-contain-border cell-vertical-center">
                                                1395/07/21
                                            </div>
                                            <div class="medium-2 table-contain-border cell-vertical-center">
                                                215475
                                            </div>
                                            <div class="medium-2  table-contain-border cell-vertical-center">
                                                123456
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-right: 1px solid #C7CDD1;" class="medium-2 table-contain-border1 cell-vertical-center">
                                        123456
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

