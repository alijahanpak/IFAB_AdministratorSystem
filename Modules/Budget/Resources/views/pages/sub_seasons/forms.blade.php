<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="SS_ModalInsert" data-reveal data-animation-in="someAnimationIn">
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