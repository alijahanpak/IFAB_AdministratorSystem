<div class="tabs-panel table-mrg-btm" id="row_tab">
    @if(count($cdPlan_rows) > 0)
        <div class="medium-12  bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="حذف" data-position="top" data-alignment="center">
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
            <div class="table-contain">
                <?php $rowColor = 0; ?>
                @foreach($cdPlan_rows as $cdPlan)
                    <?php
                    $rows = \Modules\Budget\Entities\CreditDistributionPlan::getAllPlan_rows($cdPlan->cdpCdrId);
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
                    <div class="grid-x">
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cdPlan->creditDistributionRow->cdSubject }}</div>
                        <div class="medium-10">
                            <div class="grid-x">
                                <div class="medium-2 table-contain-border">
                                    مطالعه برای احداث ساختمان و مستحدثات
                                </div>
                                <div class="medium-2  table-contain-border">
                                    مطالعه برای احداث ساختمان و مستحدثات
                                </div>
                                <div class="medium-2 table-contain-border">
                                    مطالعه برای احداث ساختمان و مستحدثات
                                </div>
                                <div class="medium-2 table-contain-border">
                                    <a onclick="openTableRowAcc('rowTest')">sadfasdfgsdf</a>
                                </div>
                                <div class="medium-4 table-contain-border">
                                    مطالعه برای احداث ساختمان و مستحدثات
                                </div>
                            </div>
                            <div class="grid-x display-off table-contain-border horizontal-scroll" id="rowTest">
                                <table>
                                    <thead class="my-thead">
                                    <th class="tbl-rotate-txt">همدان</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    <th class="tbl-rotate-txt">1231234</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                        <td>23452345</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
<!--Table End-->
