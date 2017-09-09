<div class="tabs-panel table-mrg-btm dynamic-height-level1" id="plan_title_tab">
    <div id="dynamic-height-level1">
    @if(count($creditDPs) > 0)
        <div class="medium-12 bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="CDPT_ModalInsert"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                        <i class="fi-plus size-30 secondry-color"></i>
                    </a>
                    <a  class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
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
                <div class="medium-2 table-border">
                    <strong>شماره</strong>
                </div>
                <div class="medium-3 table-border">
                    <strong>عنوان</strong>
                </div>
                <div class="medium-2 table-border">
                    <strong>فصل بودجه</strong>
                </div>
                <div class="medium-2 table-border">
                    <strong>سطح شهرستان</strong>
                </div>
                <div class="medium-3 table-border">
                    <strong>شرح</strong>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain dynamic-height-level2" id="planTitleTable">
                <?php $rowColor = 0; ?>
                @foreach($creditDPs as $creditDP)
                    <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $creditDP->cdtIdNumber }}</div>
                        <div class="medium-3 table-contain-border cell-vertical-center">{{ $creditDP->cdtSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">{{ $creditDP->budgetSeason->bsSubject }}</div>
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            <a onclick="openTableRowAcc('privincePlanCodes{{ $creditDP->id }}' , 'planTitleTable')">مشاهده</a>
                        </div>
                        <div class="medium-3 table-contain-border cell-vertical-center">
                            <div class="grid-x">
                                <div class="medium-11">
                                    {{ $creditDP->cdtDescription }}
                                </div>
                                <div class="medium-1 cell-vertical-center text-left">
                                    <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="cdptActionDropdown{{ $creditDP->id }}"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="cdptActionDropdown{{ $creditDP->id }}" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font text-right">
                                            <li><a data-open="preloaderModal"  onclick="CDPTUpdateDialogOpen({{ json_encode($planCodeLabelId_u) }} , {{ json_encode(\Modules\Budget\Entities\CreditDistributionTitle::where('cdtCdtId' , $creditDP->id)->get()) }} , '{{ \Modules\Admin\Entities\PublicSetting::getProvincePlanLebel() }}' , '{{ $creditDP->cdtBsId }}' , '{{ $creditDP->cdtIdNumber }}' , '{{ $creditDP->cdtSubject }}' , '{{ $creditDP->cdtDescription }}' , '{{ $creditDP->id }}')"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                            <li><a data-open="CDPT_modalDelete{{ $creditDP->id }}"><i class="fi-trash size-16"></i>  حذف</a></li>
                                        </ul>
                                    </div>
                                    <!--Modal Delete Start-->
                                    <div style="z-index: 9999;" class="tiny reveal" id="CDPT_modalDelete{{ $creditDP->id }}" data-reveal>
                                        <div class="modal-margin small-font">
                                            <p>کاربر گرامی</p>
                                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                            <div class="grid-x dashboard-padding">
                                                <div class="medium-6 ">
                                                    <a href="{{ url('/budget/admin/credit_distribution_def/plan_title/delete/' . $creditDP->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                    <div id="privincePlanCodes{{ $creditDP->id }}" class="grid-x display-off {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} accordionRow">
                        <div class="medium-12 table-contain-border horizontal-scroll">
                            <table class="unstriped tbl-secondary-mrg small-font">
                                <thead class="my-thead">
                                <tr class="{{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }}" style="background-color: #F1F1F1 !important;">
                                    <th>شهرستان</th>
                                    <th>کد</th>
                                    <th>شرح</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach(\Modules\Budget\Entities\CreditDistributionTitle::where('cdtCdtId' , '=' , $creditDP->id)->get() as $cdt_p)
                                        <tr>
                                            <td>{{ $cdt_p->county->coName }}</td>
                                            <td>{{ $cdt_p->cdtIdNumber }}</td>
                                            <td>{{ $cdt_p->cdtDescription }}</td>
                                        </tr>
                                    @endforeach
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
                    <span>کاربر گرامی، </span><span class="login-txt small-font"> عنوان طرح ثبت نشده است!<span><a data-open="CDPT_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>
</div>