<div class="tabs-panel is-active table-mrg-btm" id="credit_distribution_plan_all_tab">
    @if(count($cdPlans) > 0)
        <div class="medium-12  bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button" data-open="modalDelete" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="حذف" data-position="top" data-alignment="center">
                        <i class="fi-trash size-30 trash-t"></i>
                    </a>
                    <a  class="clear button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="ویرایش" data-position="top" data-alignment="center">
                        <i class="fi-pencil size-30 edit-pencil"></i>
                    </a>
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
        <div class="columns">
            <!--Header Start-->
            <div class="grid-x table-header">
                <div class="medium-2  table-border">
                    <strong>شماره طرح</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>عنوان طرح</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>فصل بودجه</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>ردیف</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>سرجمع</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>شرح</strong>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain" id="plansTable">
                <?php $rowColor = 0; ?>
                @foreach($cdPlans as $cdPlan)
                    <?php
                    $cAmounts = \Modules\Budget\Entities\CreditDistributionPlan::getAllPlan($cdPlan->cdpCdtId , $cdPlan->cdpCdrId);
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
                    <div class="grid-x {{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }} selectAbleRow">
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionTitle->cdtIdNumber }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionTitle->cdtSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionTitle->budgetSeason->bsSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionRow->cdSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            <a onclick="openTableRowAcc('countyPlanAmount{{ $cdPlan->cdpCdtId . $cdPlan->cdpCdrId }}' , 'plansTable')">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CreditDistributionPlan::getSumPlanAmount($cdPlan->cdpCdtId , $cdPlan->cdpCdrId)) }}</a>
                        </div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->cdpDescription }}</div>
                        <span class="display-off deleteUrl">{{ url('/budget/credit_distribution/capital_assets/provincial/plans/delete/' . $cdPlan->cdpCdtId . '/' . $cdPlan->cdpCdrId) }}</span>
                    </div>
                    <div id="countyPlanAmount{{ $cdPlan->cdpCdtId . $cdPlan->cdpCdrId }}" class="grid-x display-off {{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }} accordionRow">
                        <div class="medium-12 table-contain-border horizontal-scroll">
                            <table class="tbl-secondary-mrg small-font">
                                <thead class="my-thead">
                                <tr class="{{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }}" style="background-color: #F1F1F1 !important;">
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
    @else
        <!--Panel nothing Insert Start-->
        <div class="column">
            <div style="height: 200px;" class="card">
                <div class="card-section text-center" style="margin-top:60px;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است!<span><a data-open="CDP_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>