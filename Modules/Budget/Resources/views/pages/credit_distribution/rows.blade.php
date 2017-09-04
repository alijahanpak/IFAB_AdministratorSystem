<div class="tabs-panel table-mrg-btm dynamic-height-level1" id="row_tab">
    <div id="dynamicParentId1">
    @if(count($cdPlan_rows) > 0)
        <div class="medium-12  bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="CDP_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
        <!--Table Start-->
        <div class="columns">
            <!--Header Start-->
            <div class="grid-x table-header">
                <div class="medium-2 table-border">
                    <strong>ردیف توزیع اعتبار</strong>
                </div>
                <div class="medium-10">
                    <div class="grid-x">
                        <div class="medium-2 table-border">
                            <strong>شماره طرح</strong>
                        </div>
                        <div class="medium-2  table-border">
                            <strong>عنوان طرح</strong>
                        </div>
                        <div class="medium-2  table-border">
                            <strong>فصل بودجه</strong>
                        </div>
                        <div class="medium-2  table-border">
                            <strong>سرجمع</strong>
                        </div>
                        <div class="medium-4  table-border">
                            <strong>شرح</strong>
                        </div>
                    </div>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain dynamic-height-level2" id="planRowsTable">
                <?php $rowColor = 0; ?>
                @foreach($cdPlan_rows as $cdPlan)
                    <?php
                        $rows = \Modules\Budget\Entities\CreditDistributionPlan::getAllPlan_rows($cdPlan->cdpCdrId);
                    ?>
                    <div class="grid-x">
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionRow->cdSubject }}</div>
                        <div class="medium-10">
                            @foreach($rows as $row)
                                <?php
                                    $cAmounts = \Modules\Budget\Entities\CreditDistributionPlan::getAllPlan($row->cdpCdtId , $row->cdpCdrId);
                                    $countyId = array();
                                    $i = 0;
                                    foreach ($cAmounts as $cAmount)
                                    {
                                        $countyId[$i++] = 'cdpCounty' . $cAmount->county->id . '_u';
                                    }

                                    $i = 0;
                                    foreach ($cAmounts as $cAmount)
                                    {
                                        $countyAmount[$i++] = \Modules\Admin\Entities\AmountUnit::convertDispAmountWithoutSplliter($cAmount->cdpCredit);
                                    }
                                ?>
                                <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ $row->creditDistributionTitle->cdtIdNumber }}</div>
                                    <div class="medium-2  table-contain-border cell-vertical-center">{{ $row->creditDistributionTitle->cdtSubject }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ $row->creditDistributionTitle->budgetSeason->bsSubject }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center">
                                        <a onclick="openTableRowAcc('countyPlanAmount_row{{ $row->cdpCdtId . $row->cdpCdrId }}' , 'planRowsTable')">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CreditDistributionPlan::getSumPlanAmount($row->cdpCdtId , $row->cdpCdrId)) }}</a>
                                    </div>
                                    <div class="medium-4 table-contain-border cell-vertical-center">
                                        <div class="grid-x">
                                            <div class="medium-11">
                                                {{ $row->cdpDescription }}
                                            </div>
                                            <div class="medium-1 cell-vertical-center">
                                                <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="planActionDropdown_row{{ $row->cdpCdtId . $row->cdpCdrId }}"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="planActionDropdown_row{{ $row->cdpCdtId . $row->cdpCdrId }}" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font">
                                                        <li><a data-open="preloaderModal"  onclick="CDPUpdateDialogOpen({{ json_encode($countyId) }} , {{ json_encode($countyAmount) }} , '{{ $row->cdpCdrId }}' , '{{ $row->cdpCdtId }}' , '{{ $row->cdpDescription }}')"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a data-open="CDP_modalDelete{{ $row->cdpCdtId . $row->cdpCdrId }}"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="countyPlanAmount_row{{ $row->cdpCdtId . $row->cdpCdrId }}" class="grid-x display-off {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} accordionRow">
                                    <div class="medium-12 table-contain-border horizontal-scroll">
                                        <table class="tbl-secondary-mrg small-font">
                                            <thead class="my-thead">
                                            <tr style="background-color: #F1F1F1 !important;">
                                                @foreach($cAmounts as $cAmount)
                                                    <th>{{ $cAmount->county->coName }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @foreach($cAmounts as $cAmount)
                                                    <td>{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($cAmount->cdpCredit) }}</td>
                                                @endforeach
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php $rowColor++; ?>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!--Panel nothing Insert Start-->
        <div class="column">
            <div class="card dynamic-height-notif">
                <div class="card-section text-center" style="margin-top:40%;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است!<span><a data-open="CDP_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>
<!--Table End-->
</div>