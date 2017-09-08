<!--Tab 1 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="CDR_ModalInsert" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerCDRForm' , 'url' => '/budget/admin/credit_distribution_def/rows/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
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
            <button name="Submit" onmouseover="setCDRCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/rows/CDRIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="registerSubmitActivityCircle">
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
<div style="z-index: 9999;" class="tiny reveal" id="CDR_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updateCDRForm' , 'url' => '/budget/admin/credit_distribution_def/rows/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
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
            <button name="Submit" onmouseover="setCDRCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/rows/CDRIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="updateSubmitActivityCircle">
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

<!--Tab 2 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="BS_ModalInsert" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerBSForm' , 'url' => '/budget/admin/credit_distribution_def/budget_season/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="BS_existErrorInRegForm" style="display: none">
            <div class="medium-12 columns">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این عنوان فصل بودجه قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns">
                <label>عنوان فصل بودجه
                    <input type="text" name="bsSubject" id="bsSubject" required pattern="text">
                    <span class="form-error font-wei">لطفا عنوان فصل بودجه را وارد نمایید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns">
                <label>شرح
                    <textarea name="bsDescription" id="bsDescription" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns">
            <button name="Submit" onmouseover="setBSCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/budget_season/BSIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="bsRegisterSubmitActivityCircle">
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
<div style="z-index: 9999;" class="tiny reveal" id="BS_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updateBSForm' , 'url' => '/budget/admin/credit_distribution_def/budget_season/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="BS_existErrorInUpForm" style="display: none">
            <div class="medium-12 columns">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <input type="hidden" name="bsId" id="bsId_u">
        <div class="grid-x">
            <div class="small-12 columns">
                <label>عنوان فصل بودجه
                    <input type="text" name="bsSubject" id="bsSubject_u" required pattern="text">
                    <span class="form-error font-wei">لطفا عنوان فصل بودجه را وارد نمایید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns">
                <label>شرح
                    <textarea name="bsDescription" id="bsDescription_u" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns">
            <button name="Submit" onmouseover="setBSCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/budget_season/BSIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="bsUpdateSubmitActivityCircle">
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

<!--Tab 3 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="CDPT_ModalInsert" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerCDPTForm' , 'url' => '/budget/admin/credit_distribution_def/plan_title/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="CDPT_existErrorInRegForm" style="display: none">
            <div class="medium-12 columns">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این شماره یا عنوان طرح قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 cell padding-lr">
                <label>فصل بودجه
                    <select name="cdptSelectSeason" id="cdptSelectSeason" required>
                        <option value=""></option>
                        @foreach($bSeasons as $bSeason)
                            <option value="{{ $bSeason->id }}">{{ $bSeason->bsSubject }}</option>
                        @endforeach
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="cdptSelectSeason">فصل بودجه را انتخاب کنید!</span>
            </div>
            <div class="small-6 columns padding-lr">
                <label>شماره طرح
                    <input type="text" name="cdptIdNumber" id="cdptIdNumber" required pattern="text">
                    <span class="form-error font-wei">لطفا شماره طرح مورد نظر را وارد نمایید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>عنوان طرح
                    <input type="text" name="cdptSubject" id="cdptSubject" required pattern="text">
                    <span class="form-error font-wei">لطفا عنوان طرح مورد نظر را وارد نمایید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div style="padding-left: 14px;margin-bottom: 10px;" class="medium-12 column ">
                <ul style="margin-right: 0;" class="vertical menu accordion-menu" data-accordion-menu>
                    <li>
                        <a href="#">کد طرح در سطح شهرستان</a>
                        <ul class="vertical nested">
                        <div class="grid-x">
                            <div class="medium-12 column my-callout">
                                <div class="grid-x">
                                    @foreach(\Modules\Admin\Entities\County::all() as $county)
                                        <div class="medium-4 padding-lr">
                                            <label>{{ $county->coName }}
                                                <div class="input-group">
                                                    <input class="input-group-field" type="text" name="cdptCounty{{ $county->id }}" id="cdptCounty{{ $county->id }}">
                                                    <span class="input-group-label" style="padding-right: 4px;padding-left: 4px">-</span>
                                                    <span class="input-group-label" style="padding-right: 2px;padding-left: 2px">1704002</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-8 padding-lr">
                                            <label>شرح
                                                <input type="text" name="cdptCountyDesc{{ $county->id }}" id="cdptCountyDesc{{ $county->id }}">
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="cdptDescription" id="cdptDescription" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 column padding-lr">
        <button name="cdptFormSubmit" onmouseover="setCDPTCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/plan_title/CDPTIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"><span style="margin-left: 3px;">  ثبت</span><i id="cdptRegisterSubmitActivityCircle">
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
        </div>
        {!! Form::close() !!}
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal Insert End-->
<!--Modal update Start-->
<div style="z-index: 9999;" class="small reveal" id="CDPT_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updateCDPTForm' , 'url' => '/budget/admin/credit_distribution_def/plan_title/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
            <div class="grid-x" id="CDPT_existErrorInUpForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>عنوان طرح با این مشخصات قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="cdptId" id="cdptId_u">
            <div class="grid-x">
                <div class="medium-6 cell padding-lr">
                    <label>فصل بودجه
                        <select name="cdptSelectSeason" id="cdptSelectSeason_u" required>
                            <option value=""></option>
                            @foreach($bSeasons as $bSeason)
                                <option value="{{ $bSeason->id }}" >{{ $bSeason->bsSubject }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="cdptSelectSeason_u">فصل بودجه را انتخاب کنید!</span>
                </div>
                <div class="small-6 columns padding-lr">
                    <label>شماره طرح
                        <input type="text" name="cdptIdNumber" id="cdptIdNumber_u" required pattern="text">
                        <span class="form-error font-wei">لطفا شماره طرح مورد نظر را وارد نمایید!</span>
                    </label>
                </div>
            </div>
            <div class="grid-x">

                <div class="small-12 columns padding-lr">
                    <label>عنوان طرح
                        <input type="text" name="cdptSubject" id="cdptSubject_u" required pattern="text">
                        <span class="form-error font-wei">لطفا عنوان طرح مورد نظر را وارد نمایید!</span>
                    </label>
                </div>
            </div>
        <div class="grid-x">
            <div style="padding-left: 14px;margin-bottom: 10px;" class="medium-12 column padding-lr">
                <ul style="margin-right: 0;" class="vertical menu accordion-menu" data-accordion-menu>
                    <li>
                        <a href="#">سطح شهرستان</a>
                        <ul class="vertical nested">
                            <div class="grid-x">
                                <div class="medium-12 column my-callout">
                                    <div class="grid-x">
                                        <div class="medium-4 padding-lr">
                                            <label>همدان
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>
                                        <div class="medium-8 padding-lr">
                                            <label>شرح
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>

                                        <div class="medium-4 padding-lr">
                                            <label>همدان
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>
                                        <div class="medium-8 padding-lr">
                                            <label>شرح
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>

                                        <div class="medium-4 padding-lr">
                                            <label>همدان
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>
                                        <div class="medium-8 padding-lr">
                                            <label>شرح
                                                <input type="text" name="cdptSubject" id="cdptSubject" pattern="text">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="cdptDescription" id="cdptDescription_u" style="min-height: 150px;"></textarea>
                    </label>
                </div>
            </div>
        <div class="grid-x">
            <div class="medium-12 column padding-lr">
            <button name="cdptUpFormSubmit" onmouseover="setCDPTCheckExistUrl('{{ url('/budget/admin/credit_distribution_def/plan_title/CDPTIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"><span style="margin-left: 3px;">  ثبت</span><i id="cdptUpdateSubmitActivityCircle">
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
        </div>
        {!! Form::close() !!}
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->