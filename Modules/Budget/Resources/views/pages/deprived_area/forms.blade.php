<div style="z-index: 9999;" class="tiny reveal" id="modalInsertDeprivedArea" data-reveal data-animation-in="someAnimationIn">
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
            <button name="daFormSubmit" onmouseover="setCheckExistUrl('{{ url('/budget/admin/deprived_area/DAIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span><i id="registerSubmitActivityCircle">
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
                </i>
            </button>
        </div>
        {!! Form::close() !!}
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
{{--/////////////////////////////update form/////////////////////////////--}}
<div style="z-index: 9999;" class="tiny reveal" id="modalUpdateDeprivedArea" data-reveal data-animation-in="someAnimationIn">
    <div  class="modal-margin">
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
                <span class="form-error error-font" data-form-error-for="selectCounty">شهرستان را انتخاب کنید!</span>
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
            <button name="daFormSubmit" onmouseover="setCheckExistUrl('{{ url('/budget/admin/deprived_area/DAIsExistForUpdate') }}')" type="submit" value="submit" class="my-secondary button float-left small btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="updateSubmitActivityCircle">
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
        {!! Form::close() !!}
    </div>
    <button class="close-button" data-close aria-label="Close modal" data-close-on-click="false" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>