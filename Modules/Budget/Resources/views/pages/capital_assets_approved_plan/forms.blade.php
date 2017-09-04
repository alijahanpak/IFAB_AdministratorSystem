<!--Tab 1 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="CAP_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerCAPForm' , 'url' => '/budget/plan/capital_assets/plans/provincial/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="existErrorInRegForm" style="display: none">
            <div class="medium-12 columns">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این طرح قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 cell padding-lr">
                <label>طرح
                    <select name="capPtitle" id="capPtitle" onchange="" required>
                        <option value=""></option>
                        @foreach(\Modules\Budget\Entities\CreditDistributionTitle::all() as $pTitle)
                            <option value="{{ $pTitle->id }}">{{ $pTitle->cdtIdNumber . ' - ' . $pTitle->cdtSubject }}</option>
                        @endforeach
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="capPtitle">طرح را انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            @foreach(\Modules\Budget\Entities\CreditDistributionRow::all() as $cdRow)
                <div class="medium-4 columns padding-lr">
                    <label>{{ $cdRow->cdSubject }}
                        <input type="text" name="capCdRow{{ $cdRow->id }}" id="capCdRow{{ $cdRow->id }}" required pattern="number">
                    </label>
                    <span class="form-error error-font" data-form-error-for="capCdRow{{ $cdRow->id }}">عنوان یک فراموش شده است!</span>
                </div>
            @endforeach
        </div>
        <div class="grid-x">
            <div class="medium-6 columns padding-lr">
                <label>شماره
                    <input type="text" name="capTitleNumber" id="capTitleNumber" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="capTitleNumber">شماره فراموش شده است!</span>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>تاریخ
                    <input type="text" name="capTitleDate" id="capTitleDate" onfocus="datePicker(this.id)" required pattern="text">

                </label>
                <span class="form-error error-font" data-form-error-for="capTitleDate">تاریخ فراموش شده است!</span>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>تاریخ مبادله
                    <input type="text" name="capExchangeDate" id="capExchangeDate" onfocus="datePicker(this.id)"   required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="capExchangeDate">تاریخ مبادله فراموش شده است!</span>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>نوع طرح
                    <select name="capPlanType" id="capPlanType" onchange="" required>
                        <option value=""></option>
                        @foreach(\Modules\Budget\Entities\PlanType::all() as $pType)
                            <option value="{{ $pType->id }}">{{ $pType->ptSubject }}</option>
                        @endforeach
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="capPlanType">نوع طرح را انتخاب کنید!</span>
            </div>

        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="capDescription" id="capDescription" style="min-height: 150px;"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
            <button name="Submit" onmouseover="setCAPCheckExistUrl('{{ url('/budget/plan/capital_assets/plans/provincial/PCAPIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="registerSubmitActivityCircle">
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
<div style="z-index: 9999;" class="small reveal" id="CAP_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        <form data-abide novalidate>
            <div class="grid-x" id="existErrorInUpForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این طرح مصب عمرانی بودجه قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>طرح
                        <select name="title" id="title" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>

                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpCounty">طرح موافقتنامه را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 columns padding-lr">
                    <label>عنوان یک
                        <input type="text" name="Title1" id="Title1" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="Title1">عنوان یک فراموش شده است!</span>
                </div>
                <div class="medium-4 columns padding-lr">
                    <label>عنوان دو
                        <input type="text" name="Title2" id="Title2" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="Title2">عنوان دو فراموش شده است!</span>
                </div>
                <div class="medium-4 columns padding-lr">
                    <label>عنوان سه
                        <input type="text" name="Title3" id="Title3" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="Title3">عنوان سه فراموش شده است!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 columns padding-lr">
                    <label>شماره
                        <input type="text" name="num" id="num" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="num">شماره فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ
                        <input type="text" name="date" id="date" onfocus="datePicker(this.id)" required pattern="text">

                    </label>
                    <span class="form-error error-font" data-form-error-for="date">تاریخ فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ مبادله
                        <input type="text" name="planData" id="planData" onfocus="datePicker(this.id)"   required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="planData">تاریخ مبادله فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>نوع طرح
                        <select name="planKind" id="planKind" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="planKind">نوع طرح را انتخاب کنید!</span>
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
                <button name="Submit" onmouseover="setCDRCheckExistUrl"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="updateSubmitActivityCircle">
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
        </form>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->

<!--Tab 2 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="CAP_national_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        <form data-abide novalidate>
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این طرح مصب عمرانی بودجه قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>طرح
                        <select name="title" id="title" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>

                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpCounty">طرح موافقتنامه را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 columns padding-lr">
                    <label>شماره
                        <input type="text" name="num" id="num" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="num">شماره فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ
                        <input type="text" name="date" id="date" onfocus="datePicker(this.id)" required pattern="text">

                    </label>
                    <span class="form-error error-font" data-form-error-for="date">تاریخ فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ مبادله
                        <input type="text" name="planData" id="planData" onfocus="datePicker(this.id)"   required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="planData">تاریخ مبادله فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>نوع طرح
                        <select name="planKind" id="planKind" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="planKind">نوع طرح را انتخاب کنید!</span>
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
                <button name="Submit" onmouseover="setCDRCheckExistUrl"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="registerSubmitActivityCircle">
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
        </form>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal Insert End-->

<!--Modal update Start-->
<div style="z-index: 9999;" class="tiny reveal" id="CAP_national_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        <form data-abide novalidate>
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این طرح مصب عمرانی بودجه قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>طرح
                        <select name="title" id="title" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>

                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpCounty">طرح موافقتنامه را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 columns padding-lr">
                    <label>شماره
                        <input type="text" name="num" id="num" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="num">شماره فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ
                        <input type="text" name="date" id="date" onfocus="datePicker(this.id)" required pattern="text">

                    </label>
                    <span class="form-error error-font" data-form-error-for="date">تاریخ فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>تاریخ مبادله
                        <input type="text" name="planData" id="planData" onfocus="datePicker(this.id)"   required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="planData">تاریخ مبادله فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>نوع طرح
                        <select name="planKind" id="planKind" onchange="" required>
                            <option value=""></option>
                            <option value="1">a</option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="planKind">نوع طرح را انتخاب کنید!</span>
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
                <button name="Submit" onmouseover="setCDRCheckExistUrl"  type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span><i id="registerSubmitActivityCircle">
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
        </form>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->


