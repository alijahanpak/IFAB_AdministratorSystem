<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="CDP_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerCDPForm' , 'url' => '/budget/credit_distribution/capital_assets/provincial/plans/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> طرح توزیع اعتبار با این مشخصات قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-8 cell padding-lr">
                    <label>عنوان طرح
                        <select name="cdpTitle" id="cdpTitle" required>
                            <option value=""></option>
                            @foreach($creditDTs as $creditDT)
                                <option value="{{ $creditDT->id }}">{{ $creditDT->cdtIdNumber . ' - ' . $creditDT->cdtSubject }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="cdpTitle">طرح توزیع اعتبار را انتخاب کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>ردیف توزیع اعتبار
                        <select name="cdpRow" id="cdpRow" required>
                            <option value=""></option>
                            @foreach($creditDRs as $creditDR)
                                <option value="{{ $creditDR->id }}">{{ $creditDR->cdSubject }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="cdpRow">ردیف توزیع اعتبار را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x" style="margin-top: 1rem">
                <div class="medium-12 columns">
                    <div class="grid-x">
                        <span class="padding-lr">مبالغ</span><span style="color: #D9534F;">({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns">
                    <div class="grid-x">
                        @foreach($counties as $county)
                            <div class="medium-3 padding-lr">
                                <label>{{ $county->coName }}
                                    <input type="text" name="cdpCounty{{ $county->id }}" id="cdpCounty{{ $county->id }}" required pattern="number">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="cdpDescription" id="cdpDescription" style="min-height: 150px;"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr">
                <button name="Submit" onmouseover="setCDPCheckExistUrl('{{ url('/budget/credit_distribution/capital_assets/provincial/plans/CDPIsExist') }}')" type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
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
<!--Modal Insert End-->
<!--Modal update Start-->
<div style="z-index: 9999;" class="small reveal" id="CDP_ModalUpdate" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updateCDPForm' , 'url' => '/budget/credit_distribution/capital_assets/provincial/plans/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x">
            <input type="hidden" name="cdtId" id="cdtId_u">
            <input type="hidden" name="cdrId" id="cdrId_u">
            <div class="medium-8 cell padding-lr">
                <label>عنوان طرح
                    <select name="cdpTitle" id="cdpTitle_u" disabled required>
                        <option value=""></option>
                        @foreach($creditDTs as $creditDT)
                            <option value="{{ $creditDT->id }}">{{ $creditDT->cdtIdNumber . ' - ' . $creditDT->cdtSubject }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>ردیف توزیع اعتبار
                    <select name="cdpRow" id="cdpRow_u" disabled required>
                        <option value=""></option>
                        @foreach($creditDRs as $creditDR)
                            <option value="{{ $creditDR->id }}">{{ $creditDR->cdSubject }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="grid-x" style="margin-top: 1rem">
            <div class="medium-12 columns">
                <div class="grid-x">
                    <span class="padding-lr">مبالغ</span><span style="color: #D9534F;">({{ \Modules\Admin\Entities\User::find(Auth::user()->id)->first()->inPutAmountUnit->auSubject }})</span>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns">
                <div class="grid-x">
                    @foreach($counties as $county)
                        <div class="medium-3 padding-lr">
                            <label>{{ $county->coName }}
                                <input type="text" name="cdpCounty{{ $county->id }}" id="cdpCounty{{ $county->id }}_u" required pattern="number">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="cdpDescription" id="cdpDescription_u" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
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
                </i>
            </button>
        </div>
        {!! Form::close() !!}
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->