<div class="tabs-panel is-active table-mrg-btm" id="credit_distribution_plan_all_tab">
    @if(count($cdPlans) > 0)
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
            </div>
        </div>
        <div class="columns">
            <div class="">
                <table class="unstriped small-font">
                    <tr class="head-color">
                        <td>شماره طرح</td>
                        <td>عنوان طرح</td>
                        <td>فصل بودجه</td>
                        <td>ردیف توزیع اعتبار</td>
                        <td>سرجمع</td>
                        <td>شرح</td>
                        <td>ویرایش</td>
                        <td>حذف</td>
                    </tr>
                    </thead>
                    <tbody>
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
                        <tr class="{{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }}">
                            <td>{{ $cdPlan->creditDistributionTitle->cdtIdNumber }}</td>
                            <td>{{ $cdPlan->creditDistributionTitle->cdtSubject }}</td>
                            <td>{{ $cdPlan->creditDistributionTitle->budgetSeason->bsSubject }}</td>
                            <td>{{ $cdPlan->creditDistributionRow->cdSubject }}</td>
                            <td class="text-center">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CreditDistributionPlan::getSumPlanAmount($cdPlan->cdpCdtId , $cdPlan->cdpCdrId)) }}</td>
                            <td>{{ $cdPlan->cdpDescription }}</td>
                            <td class="text-center"><a data-open="preloaderModal" onclick="CDPUpdateDialogOpen({{ json_encode($countyId) }} , {{ json_encode($countyAmount) }} , '{{ $cdPlan->cdpCdrId }}' , '{{ $cdPlan->cdpCdtId }}' , '{{ $cdPlan->cdpDescription }}')" ><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                            <td class="text-center"><a data-open="modalDeletePlan{{ $cdPlan->cdpCdtId . $cdPlan->cdpCdrId }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                            <!--Modal Delete Start-->
                            <div style="z-index: 9999;" class="tiny reveal" id="modalDeletePlan{{ $cdPlan->cdpCdtId . $cdPlan->cdpCdrId }}" data-reveal data-animation-in="someAnimationIn">
                                <div class="modal-margin small-font">
                                    <p>کاربر گرامی</p>
                                    <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                    <div class="grid-x dashboard-padding">
                                        <div class="medium-6 ">
                                            <a class="button primary btn-large-w large-offset-3" href="{{ url('/budget/credit_distribution/capital_assets/provincial/plans/delete/' . $cdPlan->cdpCdtId . '/' . $cdPlan->cdpCdrId) }}">بله</a>
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
                        </tr>
                        <tr id="countyPlanAmount{{ $cdPlan->cdpCdtId . $cdPlan->cdpCdrId }}" class="{{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }}">
                            <td colspan="8">
                                <div>
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
                            </td>
                        </tr>
                        <?php $rowColor++; ?>
                    @endforeach
                    </tbody>
                </table>
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