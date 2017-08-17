@extends('budget::layouts.master')
@section('content')
    <div style="z-index: 9999;" class="tiny reveal" id="modalInsert" data-reveal>
        <div class="modal-margin">
            <form data-abide novalidate>
                <div class="grid-x">
                    <div class="medium-6 cell padding-lr">
                        <label>شهرستان
                            <select id="selectCounty" onchange="getCountyRegions('{{ url('/admin/getCountyRegions') }}')" required>
                                <option value=""></option>
                                @foreach(\Modules\Admin\Entities\County::all() as $counties)
                                    <option value="{{ $counties->id }}">{{ $counties->coName }}</option>
                                @endforeach
                            </select>
                        </label>
                        <span class="form-error error-font" data-form-error-for="selectInput1">لطفا شهرستان مورد نظر را انتخاب نمایید</span>
                    </div>
                    <div class="medium-6 cell padding-lr">
                        <label>بخش
                            <select id="selectRegion" disabled>Disabled>
                                <option value=""></option>
                                <option value="volvo">همدان</option>
                                <option value="saab">ملایر</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="medium-6 cell padding-lr">
                        <label>دهستان
                            <select id="selectRuralDistrict" disabled>Disabled>
                                <option value=""></option>
                                <option value="volvo">همدان</option>
                                <option value="saab">ملایر</option>
                            </select>
                        </label>
                    </div>
                    <div class="medium-6 cell padding-lr">
                        <label>روستا
                            <select id="selectVillage" disabled>Disabled>
                                <option value=""></option>
                                <option value="volvo">همدان</option>
                                <option value="saab">ملایر</option>
                            </select>
                        </label>

                    </div>
                </div>
                <div class="medium-6 columns">
                    <label>شرح
                        <textarea style="min-height: 150px;"></textarea>
                    </label>
                </div>
                <button type="submit" value="submit" class="my-secondary button float-left"> ثبت </button>
            </form>
        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div style="padding: 30px;" class="medium-10 border-right-line">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div style="border-bottom:solid 1.7px #D8DEE2;" class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">بودجه و اعتباات</a></li>
                            <li><a href="#">توزیع اعتبار</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مناطق محروم
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x my-grid-margin">
            <div class="medium-12 padding-lr">

                <div class="clearfix">
                    <button type="button" class="my-secondary button small" data-open="modalInsert">جدید</button>
                    <div class="float-left">
                        <div class="input-group float-left">
                            <input class="input-group-field small-font" type="text">
                            <div class="input-group-button">
                                <button type="button" class="primary button"><i class="fi-magnifying-glass"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x dashboard-padding">
            <div class="medium-12 column">
                <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="example-tabs">
                    <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">استان</a></li>
                    <li class="tabs-title"><a href="#panel2">شهرستان</a></li>
                    <li class="tabs-title"><a href="#panel3">بخش</a></li>
                    <li class="tabs-title"><a href="#panel4">دهستان</a></li>
                    <li class="tabs-title"><a href="#panel5">روستا</a></li>
                </ul>

                <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="medium-12 padding-lrt">
                        <div class="clearfix border-btm-line">
                            <div class="button-group float-left report-mrg">
                                <a  class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                                    <i class="fi-page-edit size-30 secondry-color"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!--Tab 1 Start-->
                    <div class="tabs-panel is-active" id="panel1">
                        <div class="columns">
                            <table class="stacked small-font">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 1 End-->

                    <!--Tab 2 Start-->
                    <div class="tabs-panel" id="panel2">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>نام</th>
                                    <th width="650">شرح</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>همدان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 2 End-->

                    <!--Tab 3 Start-->
                    <div class="tabs-panel" id="panel3">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>نام</th>
                                    <th>شهرستان</th>
                                    <th width="450">شرح</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 3 End-->

                    <!--Tab 4 Start-->
                    <div class="tabs-panel" id="panel4">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>نام</th>
                                    <th>شهرستان</th>
                                    <th>بخش</th>
                                    <th width="450">شرح</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 4 End-->

                    <!--Tab 5 Start-->
                    <div class="tabs-panel" id="panel5">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>نام</th>
                                    <th>شهرستان</th>
                                    <th>بخش</th>
                                    <th>دهستان</th>
                                    <th width="350">شرح</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>پیر سلمان</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>قلقلرود</td>
                                    <td>تویسرکان</td>
                                    <td>قلقلرود</td>
                                    <td>قلقلرود</td>
                                    <td>روستای مناطق محروم</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 5 End-->

                    <div class="tabs-panel" id="panel2">
                        <p>two</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-7.jpg">
                    </div>
                    <div class="tabs-panel" id="panel3">
                        <p>three</p>
                        <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                    <div class="tabs-panel" id="panel4">
                        <p>four</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-2.jpg">
                    </div>
                    <div class="tabs-panel" id="panel5">
                        <p>five</p>
                        <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                    <div class="tabs-panel" id="panel6">
                        <p>six</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-8.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
