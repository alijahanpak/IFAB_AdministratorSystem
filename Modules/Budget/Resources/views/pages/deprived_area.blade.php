@extends('budget::layouts.master')
@section('content')
    <div style="z-index: 9999;" class="tiny reveal" id="modalInsertDeprivedArea" data-reveal>
        <div class="modal-margin">
            {!! Form::open(array('id' => 'registerDAForm' , 'url' => '/budget/admin/deprived_area/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
            {!! csrf_field() !!}
                <div class="grid-x" id="existErrorInRegForm" style="display: none">
                    <div class="medium-12 columns padding-lr">
                        <div class="alert callout">
                            <p class="BYekan login-alert"><i class="fi-alert"></i> این منطقه محروم قبلا ثبت شده است!</p>
                        </div>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="medium-6 cell padding-lr">
                        <label>شهرستان
                            <select name="daCounty" id="selectCounty" onchange="getCountyRegions('{{ url('/admin/getCountyRegions') }}' , 'selectCounty' , 'selectRegion' , 'selectRuralDistrict' , 'selectVillage')" required>
                                <option value=""></option>
                                @foreach(\Modules\Admin\Entities\County::all() as $counties)
                                    <option value="{{ $counties->id }}">{{ $counties->coName }}</option>
                                @endforeach
                            </select>
                        </label>
                        <span class="form-error error-font" data-form-error-for="selectCounty">شهرستان را انتخاب کنید!</span>
                    </div>
                    <div class="medium-6 cell padding-lr">
                        <label>بخش
                            <select name="daRegion" id="selectRegion" onchange="getRegionRuralDistricts('{{ url('/admin/getRuralDistrictByRegionId') }}' , 'selectRegion' , 'selectRuralDistrict' , 'selectVillage' )" disabled>Disabled>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="medium-6 cell padding-lr">
                        <label>دهستان
                            <select name="daRuralDistrict" id="selectRuralDistrict" onchange="getRuralDistrictVillages('{{ url('/admin/getVillagesByRuralDistrictId') }}' , 'selectRuralDistrict' , 'selectVillage')" disabled>Disabled>
                            </select>
                        </label>
                    </div>
                    <div class="medium-6 cell padding-lr">
                        <label>روستا
                            <select name="daVillage" id="selectVillage" disabled>Disabled>
                            </select>
                        </label>

                    </div>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>شرح
                        <textarea name="daDescription" id="daDescription" style="min-height: 150px;"></textarea>
                    </label>
                </div>

                <div class="medium-6 columns padding-lr">
                    <button name="daFormSubmit" onmouseover="setCheckExistUrl('{{ url('/budget/admin/deprived_area/DAIsExist') }}')" type="submit" class="my-secondary button float-left"> <span>ثبت</span>    <i id="registerSubmitActivityCircle" class="fa fi-loop size-16 fa-spin icon-mar"></i> </button>
                </div>

            {!! Form::close() !!}

        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    {{--/////////////////////////////update form/////////////////////////////--}}
    <div style="z-index: 9999;" class="tiny reveal" id="modalUpdateDeprivedArea" data-reveal>
        <div class="modal-margin">
            {!! Form::open(array('id' => 'updateDAForm' , 'url' => '/budget/admin/deprived_area/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
            {!! csrf_field() !!}
            <div class="grid-x" id="existErrorInUpForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> این منطقه محروم قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="daId" id="daId_u">
            <div class="grid-x">
                <div class="medium-6 cell padding-lr">
                    <label>شهرستان
                        <select name="daCounty" id="selectCounty_u" onchange="getCountyRegions('{{ url('/admin/getCountyRegions') }}' , 'selectCounty_u' , 'selectRegion_u' , 'selectRuralDistrict_u' , 'selectVillage_u')" required>
                            <option value=""></option>
                            @foreach(\Modules\Admin\Entities\County::all() as $counties)
                                <option value="{{ $counties->id }}">{{ $counties->coName }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="selectCounty">شهرستان را انتخاب کنید</span>
                </div>
                <div class="medium-6 cell padding-lr">
                    <label>بخش
                        <select name="daRegion" id="selectRegion_u" onchange="getRegionRuralDistricts('{{ url('/admin/getRuralDistrictByRegionId') }}' , 'selectRegion_u' , 'selectRuralDistrict_u' , 'selectVillage_u')" disabled>Disabled>
                        </select>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 cell padding-lr">
                    <label>دهستان
                        <select name="daRuralDistrict" id="selectRuralDistrict_u" onchange="getRuralDistrictVillages('{{ url('/admin/getVillagesByRuralDistrictId') }}' , 'selectRuralDistrict_u' , 'selectVillage_u')" disabled>Disabled>
                        </select>
                    </label>
                </div>
                <div class="medium-6 cell padding-lr">
                    <label>روستا
                        <select name="daVillage" id="selectVillage_u" disabled>Disabled>
                        </select>
                    </label>

                </div>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>شرح
                    <textarea name="daDescription" id="daDescription_u" style="min-height: 150px;"></textarea>
                </label>
            </div>
            <div class="medium-6 columns padding-lr">
                <button name="daFormSubmit" onmouseover="setCheckExistUrl('{{ url('/budget/admin/deprived_area/DAIsExist') }}')" type="submit" value="submit" class="my-secondary button float-left small"> <span>ثبت</span>    <i id="updateSubmitActivityCircle" class="fa fi-loop size-16 fa-spin icon-mar"></i> </button>
            </div>
            {!! Form::close() !!}

        </div>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    {{--//////////////////////////////////////////////////////////////////--}}
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">داشبورد</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مدیریت
                            </li>
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
                    <button type="button" class="my-secondary button small" data-open="modalInsertDeprivedArea">جدید</button>
                    <div class="float-left">
                        <div class="input-group float-left">
                            <input class="input-group-field small-font" type="text">
                            <div class="input-group-button">
                                <button type="button" class="my-secondary button"><i class="fi-magnifying-glass"></i></button>
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
                                <thead class="my-thead">
                                <tr>
                                    <th>شهرستان</th>
                                    <th>بخش</th>
                                    <th>دهستان</th>
                                    <th>روستا</th>
                                    <th width="350">شرح</th>
                                    <th width="50">ویرایش</th>
                                    <th width="65">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dAreas as $dArea)
                                        <tr>
                                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                                            <td>{{ $dArea->daReId == '' ? '--' : \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</td>
                                            <td>{{ $dArea->daRdId == '' ? '--' : \Modules\Admin\Entities\RuralDistrict::find($dArea->daRdId)->rdName }}</td>
                                            <td>{{ $dArea->daViId == '' ? '--' : \Modules\Admin\Entities\Village::find($dArea->daViId)->viName }}</td>
                                            <td>{{ $dArea->daDescription }}</td>
                                            <td class="text-center"><a onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
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
                                        </tr>
                                    @endforeach
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
                                @foreach($dAreas as $dArea)
                                    @if($dArea->daCoId != '' && $dArea->daReId == '' && $dArea->daRdId == '' && $dArea->daViId == '')
                                        <tr>
                                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                                            <td>{{ $dArea->daDescription }}</td>
                                            <td class="text-center"><a onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                        </tr>
                                    @endif
                                @endforeach
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
                                @foreach($dAreas as $dArea)
                                    @if($dArea->daCoId != '' && $dArea->daReId != '' && $dArea->daRdId == '' && $dArea->daViId == '')
                                        <tr>
                                            <td>{{ \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</td>
                                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                                            <td>{{ $dArea->daDescription }}</td>
                                            <td class="text-center"><a onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                        </tr>
                                    @endif
                                @endforeach
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
                                @foreach($dAreas as $dArea)
                                    @if($dArea->daCoId != '' && $dArea->daReId != '' && $dArea->daRdId != '' && $dArea->daViId == '')
                                        <tr>
                                            <td>{{ \Modules\Admin\Entities\RuralDistrict::find($dArea->daRdId)->rdName }}</td>
                                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                                            <td>{{ \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</td>
                                            <td>{{ $dArea->daDescription }}</td>
                                            <td class="text-center"><a onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                        </tr>
                                    @endif
                                @endforeach
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
                                @foreach($dAreas as $dArea)
                                    @if($dArea->daCoId != '' && $dArea->daReId != '' && $dArea->daRdId != '' && $dArea->daViId != '')
                                        <tr>
                                            <td>{{ \Modules\Admin\Entities\Village::find($dArea->daViId)->viName }}</td>
                                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                                            <td>{{ \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</td>
                                            <td>{{ \Modules\Admin\Entities\RuralDistrict::find($dArea->daRdId)->rdName }}</td>
                                            <td>{{ $dArea->daDescription }}</td>
                                            <td class="text-center"><a onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i> </a></td>
                                            <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Tab 5 End-->
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
