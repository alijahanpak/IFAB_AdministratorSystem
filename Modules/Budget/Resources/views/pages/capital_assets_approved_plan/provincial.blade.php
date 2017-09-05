<div class="tabs-panel is-active table-mrg-btm dynamic-height-level1" id="provincial">
    @if(count($provinceCaps) > 0)
        <div class="medium-12  bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="CAP_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                    <strong>طرح</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>شماره</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>تاریخ</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>تاریخ مبادله</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>نوع</strong>
                </div>
                <div class="medium-2  table-border">
                    <strong>ردیف</strong>
                </div>
                <div class="medium-3  table-border">
                    <strong>شرح</strong>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain" id="provincialCapTable">
                <?php $rowColor = 0; ?>
                @foreach($provinceCaps as $cap)
                    <?php
                        $cAmounts = \Modules\Budget\Entities\CdrCap::where('ccCapId' , '=' , $cap->id)->get();
                        $cdRowId = array();
                        $i = 0;
                        foreach ($cAmounts as $cAmount)
                        {
                            $cdRowId[$i++] = 'capCdRow' . $cAmount->creditDistributionRow->id . '_u';
                        }

                        $i = 0;
                        foreach ($cAmounts as $cAmount)
                        {
                            $cdRowAmount[$i++] = \Modules\Admin\Entities\AmountUnit::convertDispAmountWithoutSplliter($cAmount->ccAmount);
                        }
                    ?>
                    <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cap->creditDistributionTitle->cdtIdNumber . ' - ' . $cap->creditDistributionTitle->cdtSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $cap->capLetterNumber }}</div>
                        <div class="medium-1 table-contain-border cell-vertical-center small-font-xx">{{ $cap->capLetterDate }}</div>
                        <div class="medium-1 table-contain-border cell-vertical-center small-font-xx">{{ $cap->capExchangeDate }}</div>
                        <div class="medium-1 table-contain-border cell-vertical-center">{{ $cap->planType->ptSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            <a onclick="openTableRowAcc('cdrCapAmount{{ $cap->id }}' , 'provincialCapTable')">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CapitalAssetsApprovedPlan::getTotalAmount($cap->id)) }}</a>
                        </div>
                        <div class="medium-3 table-contain-border cell-vertical-center">
                            <div class="grid-x">
                                <div class="medium-11">
                                    {{ $cap->capDescription }}
                                </div>
                                <div class="medium-1 cell-vertical-center">
                                    <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="capActionDropdown{{ $cap->id }}"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="capActionDropdown{{ $cap->id }}" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <li><a data-open="preloaderModal"  onclick="CAPUpdateDialogOpen({{ json_encode($cdRowId) }} , {{ json_encode($cdRowAmount) }} , '{{ $cap->capCdtId }}' , '{{ $cap->capLetterNumber }}' , '{{ $cap->capLetterDate }}' , '{{ $cap->capExchangeDate }}' , '{{ $cap->capPtId }}' , '{{ $cap->id }}' , '{{ $cap->capDescription }}')"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                            <li><a data-open="CAP_modalDelete{{ $cap->id }}"><i class="fi-trash size-16"></i>  حذف</a></li>
                                        </ul>
                                    </div>
                                    <!--Modal Delete Start-->
                                    <div style="z-index: 9999;" class="tiny reveal" id="CAP_modalDelete{{ $cap->id }}" data-reveal>
                                        <div class="modal-margin small-font">
                                            <p>کاربر گرامی</p>
                                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                            <div class="grid-x dashboard-padding">
                                                <div class="medium-6 ">
                                                    <a href="{{ url('/budget/plan/capital_assets/plans/delete/' . $cap->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                    <div id="cdrCapAmount{{ $cap->id }}" class="grid-x display-off {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} accordionRow">
                        <div class="medium-12 table-contain-border horizontal-scroll">
                            <table class="tbl-secondary-mrg small-font">
                                <thead class="my-thead">
                                    <tr class="" style="background-color: #F1F1F1 !important;">
                                        @foreach(\Modules\Budget\Entities\CreditDistributionRow::all() as $cdRow)
                                            <th>{{ $cdRow->cdSubject }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach(\Modules\Budget\Entities\CreditDistributionRow::all() as $cdRow)
                                            <td>{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CdrCap::getCapCdrAmount($cap->id , $cdRow->id)) }}</td>
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
                <div class="card dynamic-height-notif">
                    <div class="card-section text-center" style="margin-top:40%;">
                        <span>کاربر گرامی، </span><span class="login-txt small-font">طرح مصوب استانی ثبت نشده است!<span><a data-open="CAP_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                    </div>
                </div>
            </div>
        <!--Panel nothing Insert End-->
        @endif
</div>