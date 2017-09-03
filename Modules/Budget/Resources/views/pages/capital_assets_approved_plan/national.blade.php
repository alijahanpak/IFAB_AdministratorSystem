<div class="tabs-panel table-mrg-btm dynamic-height-level1" id="national">
        <div class="medium-12  bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="CAAP_national_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                <div class="medium-2  table-border">
                    <strong>تاریخ</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>تاریخ مبادله</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>نوع</strong>
                </div>
                <div class="medium-1  table-border">
                    <strong>ردیف</strong>
                </div>
                <div class="medium-3  table-border">
                    <strong>شرح</strong>
                </div>
            </div>
            <!--Header End-->
            <div class="table-contain dynamic-height-level2" id="plansTable">
                <div class="grid-x">
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            ghhfg
                        </div>
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            kghjgh
                        </div>
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            hjghj
                        </div>
                        <div class="medium-1 table-contain-border cell-vertical-center">
                            yjugyj
                        </div>
                        <div class="medium-1 table-contain-border cell-vertical-center">
                            ghkghkgk
                        </div>
                        <div class="medium-1 table-contain-border cell-vertical-center">
                            <a onclick="">link</a>
                        </div>
                        <div class="medium-3 table-contain-border cell-vertical-center">
                            <div class="grid-x">
                                <div class="medium-11">
                                    gdfgdg
                                </div>
                                <div class="medium-1 cell-vertical-center">
                                    <a class="dropdown small sm-btn-align"  type="button" data-toggle="planActionDropdown"><img width="15px" height="15px"  src="{{ asset('pic/menu.svg') }}"></a>
                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="planActionDropdown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <li><a data-open="preloaderModal"  onclick="CDPUpdateDialogOpen"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                            <li><a data-open="CDP_modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                        </ul>
                                    </div>
                                    <!--Modal Delete Start-->
                                    <div style="z-index: 9999;" class="tiny reveal" id="CDP_modalDelete" data-reveal>
                                        <div class="modal-margin small-font">
                                            <p>کاربر گرامی</p>
                                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                            <div class="grid-x dashboard-padding">
                                                <div class="medium-6 ">
                                                    <a href="" class="button primary btn-large-w large-offset-3">بله</a>
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
                    <div id="countyPlanAmount" class="grid-x display-off">
                        <div class="medium-12 table-contain-border horizontal-scroll">
                            <table class="tbl-secondary-mrg small-font">
                                <thead class="my-thead">
                                <tr class="" style="background-color: #F1F1F1 !important;">

                                        <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                   <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

       {{-- <!--Panel nothing Insert Start-->
        <div class="column">
            <div style="height: 200px;" class="card">
                <div class="card-section text-center" style="margin-top:60px;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است!<span><a data-open="CDP_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->--}}

</div>