<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="SS_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'registerTSForm' , 'url' => '/budget/admin/sub_seasons/register' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> ریز فصل با این مشخصات قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>فصل
                        <select name="sId" id="sId" required>
                            <option value=""></option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->sSubject }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="cdpTitle">طرح توزیع اعتبار را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns padding-lr">
                    <label>ریز فصل
                        <input type="text" name="tsSubject" id="tsSubject" required pattern="text">
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="tsDescription" id="tsDescription" style="min-height: 150px;"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr">
                <button name="Submit" onmouseover="setTSCheckExistUrl('{{ url('/budget/admin/sub_seasons/SSIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
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
<div style="z-index: 9999;" class="small reveal" id="SS_ModalUpdate" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        <form>
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> ریز فصل با این مشخصات قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>فصل
                        <select name="cdpTitle" id="cdpTitle" required>
                            <option value=""></option>

                            <option value=""></option>

                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="cdpTitle">طرح توزیع اعتبار را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns padding-lr">
                    <label>ریز فصل
                        <input type="text" name="cdpCounty" id="subSeason" required pattern="number">
                    </label>
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
                <button name="Submit"  type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
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
        </form>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->
<!--Modal Delete Start-->
<div style="z-index: 9999;" class="tiny reveal" id="modalDelete" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font">
        <p>کاربر گرامی</p>
        <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
        <div class="grid-x dashboard-padding">
            <div class="medium-6 ">
                <a class="button primary btn-large-w large-offset-3" href="">بله</a>
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