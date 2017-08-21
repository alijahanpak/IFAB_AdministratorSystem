@extends('budget::layouts.master')
@section('content')
    <!--Modal Insert Start-->
    <div style="z-index: 9999;" class="tiny reveal" id="modalInsert" data-reveal>
        <div class="modal-margin small-font">
            <form data-abide novalidate>
                <div class="grid-x" id="existErrorInRegForm" style="display: none">
                    <div class="medium-12 columns padding-lr">
                        <div class="alert callout">
                            <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                        </div>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="small-12 columns">
                        <label>عنوان
                            <input type="text" aria-describedby="exampleHelpText" required pattern="number">
                            <span class="form-error font-wei">لطفا عنوان مورد نظر را وارد نمایید</span>
                        </label>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="small-12 columns">
                        <label>شرح
                            <textarea name="daDescription" id="daDescription" style="min-height: 150px;"></textarea>
                        </label>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <button name="Submit"  type="submit" class="my-secondary button float-left btn-for-load"> <span>ثبت</span>    <i id="registerSubmitActivityCircle" class="fa fi-loop  fa-spin icon-mar"></i> </button>
                </div>
            </form>
        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!--Modal Insert End-->

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
                                    <span class="show-for-sr">Current: </span>تعاریف توزیع اعتبار
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="grid-x dashboard-padding">
                <div class="medium-12 column">
                    <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="example-tabs">
                        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">ردیف توزیع اعتبار</a></li>
                    </ul>

                    <div class="tabs-content" data-tabs-content="example-tabs">
                        <div class="medium-12 padding-lr-rep">
                            <div class="clearfix border-btm-line ">
                                <div class="button-group float-left report-mrg">
                                    <a  class="clear button"  data-open="modalInsert"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                                        <i class="fi-plus size-30 secondry-color"></i>
                                    </a>
                                    <a  class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                                        <i class="fi-clipboard-notes size-30 secondry-color"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--Tab 1 Start-->
                        <div class="tabs-panel is-active table-mrg-btm" id="panel1">
                            @if(count($creditDDs) > 0)
                            <div class="columns">
                                <table class="stacked small-font">
                                    <thead class="my-thead">
                                    <tr>
                                        <th>عنوان</th>
                                        <th>توضیحات</th>
                                        <th width="50">ویرایش</th>
                                        <th width="65">حذف</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                            <!--Modal Delete Start-->
                                            <div style="z-index: 9999;" class="tiny reveal" id="modalDelete" data-reveal>
                                                <div class="modal-margin small-font">
                                                    <p>کاربر گرامی</p>
                                                    <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                                    <div class="grid-x dashboard-padding">
                                                        <div class="medium-6 ">
                                                            <a href="#" class="button primary btn-large-w large-offset-3">بله</a>
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
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <!--Panel nothing Insert Start-->
                            <div class="column">
                                <div style="height: 200px;" class="card">
                                    <div class="card-section text-center" style="margin-top:70px;">
                                        <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است<span><button name="submit" type="submit" value="submit" class="custom-btn-pos my-secondary button tiny">ثبت</button></span></span>
                                    </div>
                                </div>
                            </div>
                            <!--Panel nothing Insert End-->
                            @endif
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
@stop

