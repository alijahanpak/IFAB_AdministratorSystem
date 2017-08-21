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
                        <!--Modal Insert Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="CDR_ModalInsert" data-reveal>
                            <div class="modal-margin small-font  padding-lr">
                                {!! Form::open(array('id' => 'registerCDRForm' , 'url' => '/budget/admin/credit_distribution_def/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
                                {!! csrf_field() !!}
                                <div class="grid-x" id="existErrorInRegForm" style="display: none">
                                    <div class="medium-12 columns">
                                        <div class="alert callout">
                                            <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="small-12 columns">
                                        <label>عنوان
                                            <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                            <span class="form-error font-wei">لطفا عنوان مورد نظر را وارد نمایید!</span>
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
                                    <button name="Submit" onmouseover="setCDRCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/CDRIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>ثبت</span>    <i id="registerSubmitActivityCircle" class="fa fi-loop  fa-spin icon-mar"></i> </button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!--Modal Insert End-->
                        <!--Modal update Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="CDR_ModalUpdate" data-reveal>
                            <div class="modal-margin small-font  padding-lr">
                                {!! Form::open(array('id' => 'updateCDRForm' , 'url' => '/budget/admin/credit_distribution_def/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
                                {!! csrf_field() !!}
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
                                        <label>عنوان
                                            <input type="text" name="cdrSubject" id="cdrSubject_u" required pattern="text">
                                            <span class="form-error font-wei">لطفا عنوان مورد نظر را وارد نمایید!</span>
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
                                    <button name="Submit" onmouseover="setCDRCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/CDRIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>ثبت</span>    <i id="updateSubmitActivityCircle" class="fa fi-loop  fa-spin icon-mar"></i> </button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!--Modal update End-->
                        <div class="medium-12 padding-lr-rep">
                            <div class="clearfix border-btm-line ">
                                <div class="button-group float-left report-mrg">
                                    <a  class="clear button"  data-open="CDR_ModalInsert"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                            @if(count($creditDRs) > 0)
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
                                            @foreach($creditDRs as $creditDR)
                                            <tr>
                                                <td>{{ $creditDR->cdSubject }}</td>
                                                <td>{{ $creditDR->cdDescription }}</td>
                                                <td class="text-center"><a href="#" onclick="CDRUpdateDialogOpen('{{ url('/admin') }}' , '{{ $creditDR->cdSubject }}' , '{{ $creditDR->cdDescription }}' , '{{ $creditDR->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                                <td class="text-center"><a href="#" data-open="modalDelete{{ $creditDR->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                                <!--Modal Delete Start-->
                                                <div style="z-index: 9999;" class="tiny reveal" id="modalDelete{{ $creditDR->id }}" data-reveal>
                                                    <div class="modal-margin small-font">
                                                        <p>کاربر گرامی</p>
                                                        <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                                        <div class="grid-x dashboard-padding">
                                                            <div class="medium-6 ">
                                                                <a href="{{ url('/budget/admin/credit_distribution_def/delete/' . $creditDR->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                            <!--Panel nothing Insert Start-->
                            <div class="column">
                                <div style="height: 200px;" class="card">
                                    <div class="card-section text-center" style="margin-top:60px;">
                                        <span>کاربر گرامی، </span><span class="login-txt small-font">ردیف توزیع اعتباری ثبت نشده است!<span><a data-open="CDR_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
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

