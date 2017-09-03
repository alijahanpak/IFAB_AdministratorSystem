<!--Tab 1 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="PBP_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerPBPForm' , 'url' => '/budget/credit_distribution/capital_assets/provincial/proposal/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="existErrorInRegForm" style="display: none">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این پیشنهاد بودجه قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 cell padding-lr">
                <label>شهرستان
                    <select name="pbpCounty" id="pbpCounty" onchange="getCDPWithCoId('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/getPlans') }}' , 'pbpCounty' , 'pbpPlanCode')" required>
                        <option value=""></option>
                        @foreach(\Modules\Admin\Entities\County::all() as $counties)
                            <option value="{{ $counties->id }}">{{ $counties->coName }}</option>
                        @endforeach
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="pbpCounty">شهرستان را انتخاب کنید!</span>
            </div>
            <div class="medium-8 cell padding-lr">
                <label>طرح
                    <select name="pbpPlanCode" id="pbpPlanCode" onchange="getRemianingAmount('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/getPlanRemainingAmount') }}' , 'pbpPlanCode' , 'pbpPlanAmount')" required>
                        <option value=""></option>
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="pbpPlanCode">کد طرح مورد نظر را انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 column padding-lr">
                    <div class="grid-x my-callout-bg-color">
                    <div class="medium-2">
                        <p>اعتبار باقیمانده :</p>
                    </div>
                    <div class="medium-10 btn-red">
                        <strong id="pbpPlanAmount" style="margin-bottom: 0;">0 </strong><span>({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>عنوان پروژه
                    <input type="text" name="pbpProjectTitle" id="pbpProjectTitle" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="pbpProjectTitle">عنوان پروژه فراموش شده است!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 columns padding-lr">
                <label>کد پروژه
                    <input type="text" name="pbpProjectCode" id="pbpProjectCode" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="pbpProjectCode">کد پروژه فراموش شده است!</span>
            </div>
            <div class="medium-6 columns padding-lr">
                <label><span>مبلغ اعتبار</span><span style="color: #D9534F;">({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                    <input type="text" name="pbpAmount" id="pbpAmount" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="pbpAmount">مبلغ اعتبار فراموش شده است!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="pbpDescription" id="pbpDescription" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
            <button name="Submit" onmouseover="setPBPCheckExistUrl('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/PBPIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="registerSubmitActivityCircle">
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
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal Insert End-->

<!--Modal update Start-->
<div style="z-index: 9999;" class="small reveal" id="PBP_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updatePBPForm' , 'url' => '/budget/credit_distribution/capital_assets/provincial/proposal/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
            <div class="grid-x" id="existErrorInUpForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این پیشنهاد بودجه قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="pbpId" id="pbpId_u">
            <div class="grid-x">
                <div class="medium-4 cell padding-lr">
                    <label>شهرستان
                        <select name="pbpCounty" id="pbpCounty_u" onchange="getCDPWithCoId('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/getPlans') }}' , 'pbpCounty_u' , 'pbpPlanCode_u')" required>
                            <option value=""></option>
                            @foreach(\Modules\Admin\Entities\County::all() as $counties)
                                <option value="{{ $counties->id }}">{{ $counties->coName }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpCity">شهرستان مورد نظر را انتخاب کنید!</span>
                </div>
                <div class="medium-8 cell padding-lr">
                    <label>کد طرح
                        <select name="pbpPlanCode" id="pbpPlanCode_u" onchange="getRemianingAmount('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/getPlanRemainingAmount') }}' , 'pbpPlanCode_u' , 'pbpPlanAmount_u')" required>
                            <option value=""></option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpProjectCode">کد طرح مورد نظر را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 column padding-lr">
                    <div class="grid-x my-callout-bg-color">
                        <div class="medium-2">
                            <p>اعتبار باقیمانده :</p>
                        </div>
                        <div class="medium-10 btn-red">
                            <strong id="pbpPlanAmount_u" style="margin-bottom: 0;">0 </strong><span>({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns padding-lr">
                    <label>عنوان پروژه
                        <input type="text" name="pbpProjectTitle" id="pbpProjectTitle_u" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpProjectTitle_u">عنوان پروژه فراموش شده است!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 columns padding-lr">
                    <label>کد پروژه
                        <input type="text" name="pbpProjectCode" id="pbpProjectCode_u" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpProjectCode_u">کد پروژه فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label><span>مبلغ اعتبار</span><span style="color: #D9534F;">({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                        <input type="text" name="pbpAmount" id="pbpAmount_u" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpAmount_u">مبلغ اعتبار فراموش شده است!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="pbpDescription" id="pbpDescription_u" style="min-height: 150px;"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr">
                <button name="Submit" onmouseover="setPBPCheckExistUrl('{{ url('/budget/credit_distribution/capital_assets/provincial/proposal/PBPIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="updateSubmitActivityCircle">
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
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->
