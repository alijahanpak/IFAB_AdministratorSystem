<div class="tabs-panel is-active table-mrg-btm" id="credit_distribution_plan_all_tab">
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
        <div  class="my-table-scroll">
            <table class="stack small-font">
                <thead class="my-thead">
                <tr>
                    <th>شماره طرح</th>
                    <th>عنوان طرح</th>
                    <th>سرجمع شهرستان ها (میلیون ریال)</th>
                    <th width="65px">ویرایش</th>
                    <th width="65px">حذف</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>17323000000</td>
                    <td>فصل حمایت از فعالیتهای فرهنگی، هنری، دینی استانها</td>
                    <td>
                        <a onclick="openRow()">123546</a>
                    </td>
                    <td class="text-center"><a ><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                    <td class="text-center"><a data-open="modalDelete"><i class="fi-trash size-21 trash-t"></i> </a></td>

                    <!--Modal Delete Start-->
                    <div style="z-index: 9999;" class="tiny reveal" id="modalDelete" data-reveal>
                        <div class="modal-margin small-font">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x dashboard-padding">
                                <div class="medium-6 ">
                                    <a class="button primary btn-large-w large-offset-3">بله</a>
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
                <tr id="myRow">
                    <td colspan="5">
                        <div>
                            <table class="tbl-secondary-mrg small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>همدان</th>
                                    <th>ملایر</th>
                                    <th>نهاوند</th>
                                    <th>تویسرکان</th>
                                    <th>اسدآباد</th>
                                    <th>کبودرآهنگ</th>
                                    <th>رزن</th>
                                    <th>فامنین</th>
                                    <th>بهار</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>23/120.12</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                    <td>2313</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--Panel nothing Insert Start-->
    <div class="column">
        <div style="height: 200px;" class="card">
            <div class="card-section text-center" style="margin-top:60px;">
                <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است!<span><a data-open="CDR_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
            </div>
        </div>
    </div>
    <!--Panel nothing Insert End-->

</div>