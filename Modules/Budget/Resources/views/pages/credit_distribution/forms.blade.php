<!--Modal Insert Start-->
<div style="z-index: 9999;" class="small reveal" id="CDP_ModalInsert" data-reveal data-animation-in="someAnimationIn">
    <div class="modal-margin small-font  padding-lr">
        <form class="data-abide novalidate">
            <div class="grid-x" id="existErrorInRegForm" style="display: none">
                <div class="medium-12 columns">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>این ردیف توزیع اعتبار قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-8 cell padding-lr">
                    <label>عنوان طرح
                        <select name="" id="selectProjectTitle" required>
                            <option value="1"></option>
                            <option value="2"></option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="selectProjectTitle">لطفا عنوان فصل را انتخاب کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>عنوان فصل
                        <select name="" id="selectSeasonTitle" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="selectSeasonTitle">لطفا عنوان فصل را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns">
                    <div class="grid-x">
                        <div class="medium-3 padding-lr">
                            <label>همدان
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>ملایر
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>نهاوند
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>تویسرکان
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>کبودرآهنگ
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>اسدآباد
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>رزن
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>بهار
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                        <div class="medium-3 padding-lr">
                            <label>فامنین
                                <input type="text" name="cdrSubject" id="cdrSubject" required pattern="text">
                                <span class="form-error font-wei">لطفا عنوان ردیف توزیع اعتبار را وارد نمایید!</span>
                            </label>
                        </div>
                    </div>
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
                <button name="Submit" type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
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
<div style="z-index: 9999;" class="tiny reveal" id="CDP_ModalUpdate" data-reveal>
    <div class="modal-margin small-font  padding-lr">
        <form>
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
                    </i> </button>
            </div>
        </form>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--Modal update End-->