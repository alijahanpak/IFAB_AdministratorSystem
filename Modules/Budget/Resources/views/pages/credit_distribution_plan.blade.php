@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
        <div class="medium-10 border-right-line inner-body-pad">
            <div class="grid-x padding-lr">
                <div class="medium-12">
                    <div class="grid-x border-btm-line">
                        <nav aria-label="You are here:" role="navigation">
                            <ul class="breadcrumbs">
                                <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                                <li>
                                    <span class="show-for-sr">Current: </span>مدیریت
                                </li>
                                <li>
                                    <span class="show-for-sr">Current: </span>ثبت طرح های توزیع اعتبار
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="grid-x dashboard-padding">
                <div class="medium-12 column">
                    <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="credit_distribution_plan_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                        <li class="tabs-title is-active"><a href="#credit_distribution_plan_all_tab" aria-selected="true">طرح های توزیع اعتبار</a></li>
                        <li class="tabs-title"><a href="#row_tab">ردیف</a></li>
                        <li class="tabs-title"><a href="#budget_season_tab">فصل بودجه</a></li>
                        <li class="tabs-title"><a href="#city_tab">شهرستان</a></li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="credit_distribution_plan_tab_view">
                        <!--Tab 1 Start-->
                        <!--Modal Insert Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="CDP_ModalInsert" data-reveal>
                            <div class="modal-margin small-font  padding-lr">
                                <form>
                                <div class="grid-x" id="existErrorInRegForm" style="display: none">
                                    <div class="medium-12 columns">
                                        <div class="alert callout">
                                            <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="small-12 columns">
                                        <label>عنوان ردیف توزیع اعتبار
                                            <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                            <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="small-12 columns">
                                        <label>شرح
                                            <textarea name="cdrDescription" id="cdrDescription" style="min-height: 150px;"></textarea>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-6 columns">
                                    <button name="Submit" type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
                                            <div class="la-line-spin-clockwise-fade-rotating la-sm float-left">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </i> </button>
                                </div>
                                </form>
                            </div>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!--Modal Insert End-->
                        <!--Modal update Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="CDP_ModalUpdate" data-reveal>
                            <div class="modal-margin small-font  padding-lr">
                                <form>
                                <div class="grid-x" id="existErrorInUpForm" style="display: none">
                                    <div class="medium-12 columns">
                                        <div class="alert callout">
                                            <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="cdrId" id="cdrId_u">
                                <div class="grid-x">
                                    <div class="small-12 columns">
                                        <label>عنوان ردیف توزیع اعتبار
                                            <input type="text" name="cdrSubject" id="cdrSubject_u" required pattern="text">
                                            <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="small-12 columns">
                                        <label>شرح
                                            <textarea name="cdrDescription" id="cdrDescription_u" style="min-height: 150px;"></textarea>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-6 columns">
                                    <button name="Submit" type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="updateSubmitActivityCircle">
                                            <div class="la-line-spin-clockwise-fade-rotating la-sm float-left">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </i> </button>
                                </div>
                                </form>
                            </div>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!--Modal update End-->

                        <div class="tabs-panel is-active table-mrg-btm" id="credit_distribution_plan_all_tab">
                            <div class="medium-12  bottom-mrg">
                                <div class="clearfix border-btm-line ">
                                    <div class="button-group float-left report-mrg">
                                        <a  class="clear button"  data-open="CDR_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                                                <ul class="accordion" data-accordion data-allow-all-closed="true">
                                                    <li class="accordion-item is-active" data-accordion-item>
                                                        <a href="#" class="accordion-title">234234234</a>
                                                        <div class="accordion-content" data-tab-content >
                                                            <div class="table-scroll">
                                                            <table class="small-font">
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
                                                                    <td>2313</td>
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
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="text-center"><a ><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                            <td class="text-center"><a data-open="modalDelete"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                        </tr>

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
                        <!--Tab 1 End-->

                    </div>
                </div>
            </div>
        </div>
        <script>
            $('[data-loading-start]').click(function() {
                $(this).addClass('hide')
                $('[data-loading-end]').removeClass('hide')
            });
        </script>
    <script>


       // var theTbl = document.getElementById('myTable').rows[0].cells.length;
        //alert(theTbl);


    </script>
@stop

