<div class="tabs-panel table-mrg-btm dynamic-height-level1" id="rural_district">
    <div id="dynamicParentId1">
    @if(\Modules\Budget\Entities\DeprivedArea::isExistRuralDistrict())
        <div class="medium-12 bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="modalInsertDeprivedArea"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                    <strong>نام</strong>
                </div>
                <div class="medium-2 table-border">
                    <strong>شهرستان</strong>
                </div>
                <div class="medium-2 table-border">
                    <strong>بخش</strong>
                </div>
                <div class="medium-6 table-border">
                    <strong>شرح</strong>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain dynamic-height-level2">
                <?php $rowColor = 0; ?>
                @foreach($dAreas as $dArea)
                    @if($dArea->daCoId != '' && $dArea->daReId != '' && $dArea->daRdId != '' && $dArea->daViId == '')
                        <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                            <div class="medium-2 table-contain-border cell-vertical-center">{{ \Modules\Admin\Entities\RuralDistrict::find($dArea->daRdId)->rdName }}</div>
                            <div class="medium-2 table-contain-border cell-vertical-center">{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</div>
                            <div class="medium-2 table-contain-border cell-vertical-center">{{ \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</div>
                            <div class="medium-6 table-contain-border cell-vertical-center">
                                <div class="grid-x">
                                    <div class="medium-11">
                                        {{ $dArea->daDescription }}
                                    </div>
                                    <div class="medium-1 cell-vertical-center text-left">
                                        <a class="dropdown small sm-btn-align display-off"  type="button" data-toggle="daActionDropdown_ruralDistrict{{ $dArea->id }}"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="daActionDropdown_ruralDistrict{{ $dArea->id }}" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font text-right">
                                                <li><a data-open="preloaderModal"  onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                <li><a data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-16"></i>  حذف</a></li>
                                            </ul>
                                        </div>
                                        <!--Modal Delete Start-->
                                        <div style="z-index: 9999;" class="tiny reveal" id="modalDelete{{ $dArea->id }}" data-reveal>
                                            <div class="modal-margin small-font">
                                                <p>کاربر گرامی</p>
                                                <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                                <div class="grid-x dashboard-padding">
                                                    <div class="medium-6 ">
                                                        <a href="{{ url('/budget/admin/deprived_area/delete/' . $dArea->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                        <?php $rowColor++; ?>
                    @endif
                @endforeach
            </div>
        </div>
    @else
    <!--Panel nothing Insert Start-->
        <div class="column">
            <div class="card dynamic-height-notif">
                <div class="card-section text-center" style="margin-top:40%;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font">دهستان محروم ثبت نشده است!<span><a data-open="modalInsertDeprivedArea" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>
</div>