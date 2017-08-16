@extends('budget::layouts.master')
@section('content')
    <div style="padding: 30px;" class="medium-10 border-right-line">
        <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
            <div class="medium-12">
                <div style="border-bottom:solid 1.7px #D8DEE2;" class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">بودجه و اعتباات</a></li>
                            <li><a href="#">توزیع اعتبار</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مدیریت مناطق محروم
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x my-grid-margin">
            <div class="medium-4 cell dashboard-padding">
                <!--<button type="button" class="my-secondary button tiny float-left">اطلاعات بیشتر</button>-->
                <div class="input-group">
                    <input class="input-group-field small-font float-left" type="text">
                    <div class="input-group-button">
                        <button type="button" class="primary button"><i class="fi-magnifying-glass"></i></button>
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
                    <div style="padding-right: 20px;padding-left: 20px;" class="medium-12">
                        <div class="clearfix border-btm-line">
                            <div class="button-group float-left">
                                <a style="cursor: pointer;" class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="ایجاد نمودار" data-position="top" data-alignment="center">
                                    <i style="color: #01aef0;" class="fi-page-edit size-30"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-panel is-active" id="panel1">
                        <div class="columns">
                            <table class="stacked small-font">
                                <thead class="my-thead">
                                <tr>
                                    <th>شهرستان</th>
                                    <th>بخش</th>
                                    <th>دهستان</th>
                                    <th>روستا</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="border-left: solid 1px #D8DEE2;">همدان</td>
                                    <td>مرکزی</td>
                                    <td>قاسم آباد</td>
                                    <td>قسم آباد</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>مرکزی</td>
                                    <td>قاسم آباد</td>
                                    <td>قسم آباد</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>مرکزی</td>
                                    <td>قاسم آباد</td>
                                    <td>قسم آباد</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>مرکزی</td>
                                    <td>قاسم آباد</td>
                                    <td>قسم آباد</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                <tr>
                                    <td>همدان</td>
                                    <td>مرکزی</td>
                                    <td>قاسم آباد</td>
                                    <td>قسم آباد</td>
                                    <td class="text-center"><a href="#"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                    <td class="text-center"><a href="#"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tabs-panel" id="panel2">

                    </div>
                    <div class="tabs-panel" id="panel3">

                    </div>
                    <div class="tabs-panel" id="panel4">

                    </div>
                    <div class="tabs-panel" id="panel5">

                    </div>
                    <div class="tabs-panel" id="panel6">

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
