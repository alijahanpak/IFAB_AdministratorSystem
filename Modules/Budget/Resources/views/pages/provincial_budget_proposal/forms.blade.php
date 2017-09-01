<!--Tab 1 Start-->
<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="PBP_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        <form data-abide novalidate>
        <div class="grid-x" id="existErrorInRegForm" style="display: none">
            <div class="medium-12 columns">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>این پیشنهاد بودجه قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 cell padding-lr">
                <label>شهرستان
                    <select name="pbpCity" id="pbpCity" required>
                        <option value=""></option>

                            <option value=""></option>

                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="pbpCity">شهرستان مورد نظر را انتخاب کنید!</span>
            </div>
            <div class="medium-8 cell padding-lr">
                <label>کد طرح
                    <select name="pbpProjectCode" id="pbpProjectCode" required>
                        <option value=""></option>

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
                        <strong style="margin-bottom: 0;">12345678 <span>میلیون ریال</span></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 columns padding-lr">
                <label>عنوان پروژه
                    <input type="text" name="projectTitle" id="projectTitle" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="projectTitle">عنوان پروژه فراموش شده است!</span>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>کد پروژه
                    <input type="text" name="projectCode" id="projectCode" required pattern="text">
                </label>
                <span class="form-error error-font" data-form-error-for="projectCode">کد پروژه فراموش شده است!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="cdrDescription" id="cdrDescription" style="min-height: 150px;"></textarea>
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
<div style="z-index: 9999;" class="tiny reveal" id="PBP_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        <form data-abide novalidate>
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این پیشنهاد بودجه قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 cell padding-lr">
                    <label>شهرستان
                        <select name="pbpCity" id="pbpCity" required>
                            <option value=""></option>

                            <option value=""></option>

                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="pbpCity">شهرستان مورد نظر را انتخاب کنید!</span>
                </div>
                <div class="medium-8 cell padding-lr">
                    <label>کد طرح
                        <select name="pbpProjectCode" id="pbpProjectCode" required>
                            <option value=""></option>

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
                            <strong style="margin-bottom: 0;">12345678 <span>میلیون ریال</span></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-6 columns padding-lr">
                    <label>عنوان پروژه
                        <input type="text" name="projectTitle" id="projectTitle" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="projectTitle">عنوان پروژه فراموش شده است!</span>
                </div>
                <div class="medium-6 columns padding-lr">
                    <label>کد پروژه
                        <input type="text" name="projectCode" id="projectCode" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="projectCode">کد پروژه فراموش شده است!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="cdrDescription" id="cdrDescription" style="min-height: 150px;"></textarea>
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
