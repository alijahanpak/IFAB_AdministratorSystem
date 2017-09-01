@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>توزیع اعتبار
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>تملک داریی های سرمایه ای
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>استانی
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>پیشنهاد دستگاه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @include('budget::pages.provincial_budget_proposal.forms')
        <div class="grid-x dashboard-padding">
            <div class="medium-12 my-callout">
                <div class="medium-12  bottom-mrg">
                    <div class="clearfix border-btm-line ">
                        <div class="button-group float-left report-mrg">
                            <a  class="clear button"  data-open="PBP_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                </div>
                <div  class="grid-x collapse">
                    <div  class="medium-1 columns my-tab-attribute">
                        <ul style="min-height: 300px;" class="vertical tabs" data-tabs id="provincial_budget_proposal_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                            <li class="tabs-title is-active"><a href="#city1_tab" aria-selected="true">همدان</a></li>
                            <li class="tabs-title"><a href="#city2_tab">همدان</a></li>
                            <li class="tabs-title"><a href="#city3_tab">همدان</a></li>
                            <li class="tabs-title"><a href="#city4_tab">همدان</a></li>
                            <li class="tabs-title"><a href="#city5_tab">همدان</a></li>
                            <li class="tabs-title"><a href="#city6_tab">همدان</a></li>
                            <li class="tabs-title"><a href="#city7_tab">همدان</a></li>

                        </ul>
                    </div>
                    <div class="medium-11 columns my-tab-contain">
                        <div data-tabs-content="provincial_budget_proposal_tab_view">
                            <div class="tabs-panel is-active" id="city1_tab">
                                <div class="columns">
                                    <!--Header Start-->
                                    <div class="grid-x table-header">
                                        <div class="medium-2 table-border">
                                            <strong>کد</strong>
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x">
                                                <div class="medium-4 table-border">
                                                    <strong>عنوان</strong>
                                                </div>
                                                <div class="medium-4  table-border">
                                                    <strong>اعتبار پیشنهادی</strong>
                                                </div>
                                                <div class="medium-4  table-border">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            <strong>شرح</strong>
                                                        </div>
                                                        <div class="medium-1">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-contain">
                                        <div class="grid-x">
                                            <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                            <div class="medium-10">

                                                    <div class="grid-x">
                                                        <div class="medium-4 table-contain-border">dfd</div>
                                                        <div class="medium-4  table-contain-border">dfsdf</div>
                                                        <div class="medium-4  table-contain-border">
                                                            <div class="grid-x">
                                                                <div class="medium-11">
dfddf
                                                                </div>
                                                                <div class="medium-1">
                                                                    <a class="dropdown small sm-btn-align"  type="button" data-toggle="tsActionDropdown"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="tsActionDropdown" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a data-open="preloaderModal"  onclick="TSUpdateDialogOpen"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                            <li><a data-open="TS_modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
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
                                    <!--Header End-->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>
@stop
