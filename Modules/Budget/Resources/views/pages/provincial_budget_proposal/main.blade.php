@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div  class="medium-10 border-right-line inner-body-pad main-margin">
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
            <div id="dynamicParentId1" class="medium-12 my-callout  dynamic-height-level1">
                @if(count($pbps) > 0)
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
                <div  class="grid-x">
                    <div class="medium-1 columns my-tab-attribute dynamic-height-level2">
                        <ul class="vertical tabs" data-tabs id="provincial_budget_proposal_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                            <?php
                                $isFirst = true;
                                $rowIndex = 0;
                            ?>
                            @foreach ($pbps as $key => $value)
                                <li class="tabs-title {{ $isFirst == true ? 'is-active' : '' }}"><a href="#county{{ $rowIndex }}_tab" aria-selected="true">{{ $key }}</a></li>
                                <?php
                                    $isFirst = false;
                                    $rowIndex++;
                                ?>
                            @endforeach
                        </ul>
                    </div>
                    <div id="dynamicParentId2" class="medium-11 columns my-tab-contain dynamic-height-level2-2">
                        <div  data-tabs-content="provincial_budget_proposal_tab_view">
                            <?php
                                $isFirst = true;
                                $rowIndex = 0;
                            ?>
                            @foreach ($pbps as $key => $value)
                                <div class="tabs-panel {{ $isFirst == true ? 'is-active' : '' }}" id="county{{ $rowIndex }}_tab">
                                    <div class="columns">
                                        <!--Header Start-->
                                        <div class="grid-x table-header">
                                            <div class="medium-2 table-border">
                                                <strong>طرح</strong>
                                            </div>
                                            <div class="medium-2 table-border">
                                                <strong>کد</strong>
                                            </div>
                                            <div class="medium-2 table-border">
                                                <strong>عنوان</strong>
                                            </div>
                                            <div class="medium-2  table-border">
                                                <strong>اعتبار</strong>
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
                                    <div class="table-contain dynamic-height-level3" id="pbpTable{{ $rowIndex }}">
                                        <?php $rowColor = 0; ?>
                                        @foreach ($value as $pbp)
                                            <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                                                <div class="medium-2 table-contain-border cell-vertical-center">
                                                    <a onclick="openTableRowAcc('pbpPlanInfo{{ $pbp->id }}' , 'pbpTable{{ $rowIndex }}')">{{ $pbp->creditDistributionPlan->creditDistributionTitle->cdtIdNumber }}</a>
                                                </div>
                                                <div class="medium-2 table-contain-border">{{ $pbp->pbpCode }}</div>
                                                <div class="medium-2  table-contain-border">{{ $pbp->pbpSubject }}</div>
                                                <div class="medium-2 table-contain-border">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($pbp->pbpAmount) }}</div>
                                                <div class="medium-4  table-contain-border">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ $pbp->pbpDescription }}
                                                        </div>
                                                        <div class="medium-1">
                                                            <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="pbpActionDropdown{{ $pbp->id }}"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="pbpActionDropdown{{ $pbp->id }}" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a data-open="preloaderModal"  onclick="TSUpdateDialogOpen"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                    <li><a data-open="PBP_modalDelete{{ $pbp->id  }}"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                            <!--Modal Delete Start-->
                                                            <div style="z-index: 9999;" class="tiny reveal" id="PBP_modalDelete{{ $pbp->id  }}" data-reveal>
                                                                <div class="modal-margin small-font">
                                                                    <p>کاربر گرامی</p>
                                                                    <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                                                    <div class="grid-x dashboard-padding">
                                                                        <div class="medium-6 ">
                                                                            <a href="{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/delete/' . $pbp->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
                                                                        </div>
                                                                        <div class="medium-6">
                                                                            <a data-close aria-label="Close modal" class="button primary hollow btn-large-w large-offset-4">خیر</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="close-button" data-close aria-label="Close modal" type="button">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <!--Modal Delete End-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="pbpPlanInfo{{ $pbp->id }}" class="grid-x display-off {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} accordionRow">
                                                <div class="medium-12 table-contain-border horizontal-scroll">
                                                    <table class="tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                            <th>عنوان طرح</th>
                                                            <th>ردیف توزیع اعتبار</th>
                                                            <th>فصل بودجه</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $pbp->creditDistributionPlan->creditDistributionTitle->cdtSubject }}</td>
                                                                <td>{{ $pbp->creditDistributionPlan->creditDistributionRow->cdSubject }}</td>
                                                                <td>{{ $pbp->creditDistributionPlan->creditDistributionTitle->budgetSeason->bsSubject }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php $rowColor++; ?>
                                        @endforeach
                                    </div>
                                </div>
                                <?php
                                    $isFirst = false;
                                    $rowIndex++;
                                ?>
                            @endforeach
                            <!--Header End-->
                        </div>
                    </div>
                </div>
                @else
                    <!--Panel nothing Insert Start-->
                    <div class="column">
                        <div class="card dynamic-height-notif">
                            <div class="card-section text-center" style="margin-top:40%;">
                                <span>کاربر گرامی، </span><span class="login-txt small-font">پیشنهاد بودجه تملک داریی های سرمایه ای استانی ثبت نشده است!<span><a data-open="PBP_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                            </div>
                        </div>
                    </div>
                    <!--Panel nothing Insert End-->
                @endif
            </div>
        </div>
    </div>
@stop
