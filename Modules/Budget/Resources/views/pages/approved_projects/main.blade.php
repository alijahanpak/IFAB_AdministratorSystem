@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="">داشبورد</a></li>
                            <li>
                                <a class="disabled">موافقتنامه</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>پروژه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="approvedProjects" class="grid-x dashboard-padding">
            @include('budget::pages.approved_projects.forms')
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
                            <strong>کد طرح</strong>
                        </div>
                        <div class="medium-10">
                            <div class="grid-x">
                                <div class="medium-1 table-border">
                                    <strong>کد</strong>
                                </div>
                                <div class="medium-4 table-border">
                                    <strong>عنوان</strong>
                                </div>
                                <div class="medium-1 table-border">
                                    <strong>نحوه اجرا</strong>
                                </div>
                                <div class="medium-2 table-border">
                                    <strong>اعتبار</strong>
                                </div>
                                <div class="medium-4  table-border">
                                    <strong>شرح</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Header End-->
                    <div class="table-contain dynamic-height-level2">
                        <div class="grid-x" v-for="projects in approvedProjects">
                            <div class="medium-2 table-contain-border cell-vertical-center">
                                @{{ projects.apPlan }}
                            </div>
                            <div class="medium-10">
                                <div class="grid-x selectAbleRow" v-for="approvedProjects in projects.approved_projects">
                                    <div class="medium-2 table-contain-border cell-vertical-center">
                                        @{{ approvedProjects.apProjectCode }}
                                    </div>
                                    <div class="medium-2 table-contain-border cell-vertical-center">
                                        @{{ approvedProjects.apProjectTitle }}
                                    </div>
                                    <div class="medium-3 table-contain-border cell-vertical-center">
                                        @{{ approvedProjects.apCredit }}
                                    </div>
                                    <div class="medium-5  table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">
                                                @{{ approvedProjects.apDescription }}
                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'apApprovedProjects' + approvedProjects.id"><img width="15px" height="15px" src="{{ asset('pic/menu.svg') }}"></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'apApprovedProjects' + approvedProjects.id" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a v-on:click.prevent="approvedProjectsUpdateDialog(approvedProjects , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a v-on:click.prevent="openDeleteApprovedProjectsConfirm(approvedProjects)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="medium-12 table-contain-border cell-vertical-center">
                                <a class="text-center" href="#">مشخصات طرح</a>
                            </div>
                            <div class="medium-12 table-contain-border cell-vertical-center">
                                <a class="text-center" href="#">مشخصات پروژه</a>
                            </div>
                            <div class="medium-12 table-contain-border cell-vertical-center">
                                <a class="text-center" href="#">ردیف های توزیع اعتبار</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

