@extends('budget::layouts.master')
@section('content')

    <!--Modal Delete Start-->
    <div style="z-index: 9999;" class="tiny reveal" id="modalDelete" data-reveal>
        <div class="modal-margin small-font">
            <p>علی جهان پاک</p>
            <p class="large-offset-1 modal-text">آیا مایل به فعال سازی سال <span>1397</span>هستید؟</p>
            <div class="grid-x dashboard-padding">
                <div class="medium-6 ">
                    <a class="button primary btn-large-w large-offset-3">بله</a>
                </div>
                <div class="medium-6">
                    <a class="button primary hollow btn-large-w large-offset-4">خیر</a>
                </div>
            </div>
        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">بودجه و اعتباات</a></li>
                            <li><a href="#">توزیع اعتبار</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>سال مالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x">
            <div class="medium-12 column">
                    <!--Tab 1 Start-->
                    <div class="tabs-panel is-active" id="panel1">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>سال مالی</th>
                                    <th>شرح</th>
                                    <th>وضعیت</th>
                                    <th width="100">مجوزها</th>
                                    <th width="100">فعال سازی</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1394</td>
                                    <td>تویسرکان</td>
                                    <td>غیرفعال</td>
                                    <td class="text-center"><a href="#" data-open="modalDelete"><i class="fi-clipboard-pencil size-21 blue-color"></i> </a></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>1395</td>
                                    <td>تویسرکان</td>
                                    <td>غیرفعال</td>
                                    <td class="text-center"><a href="#" data-open="modalDelete"><i class="fi-clipboard-pencil size-21 blue-color"></i> </a></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>1396</td>
                                    <td>تویسرکان</td>
                                    <td>فعال</td>
                                    <td></td>
                                    <td class="text-center"><a href="#" data-open="modalDelete"><i class="fi-checkbox size-21 edit-pencil"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 1 End-->
        </div>
    </div>
    <!--Inner body End-->
@stop
