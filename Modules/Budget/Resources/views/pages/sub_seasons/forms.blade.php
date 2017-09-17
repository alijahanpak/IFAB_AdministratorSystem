{{--<!--Modal Insert Start-->
<div style="z-index: 9999;" class="tiny reveal" id="SS_ModalInsert" data-reveal
     data-animation-in="slide-in-down fast bounce" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                    <span class="form-error error-font" data-form-error-for="sId">فصل را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns padding-lr">
                    <label>ریز فصل
                        <input type="text" name="tsSubject" id="tsSubject" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="tsSubject">ریز فصل فراموش شده است!</span>
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
<div style="z-index: 9999;" class="tiny reveal" id="SS_ModalUpdate" data-reveal data-animation-in="slide-in-down fast bounce">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('id' => 'updateTSForm' , 'url' => '/budget/admin/sub_seasons/update' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
            <div class="grid-x" id="existErrorInUpForm" style="display: none">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i> ریز فصل با این مشخصات قبلا ثبت شده است!</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tsId" id="tsId_u">
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>فصل
                        <select name="sId" id="sId_u" required>
                            <option value=""></option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->sSubject }}</option>
                            @endforeach
                        </select>
                    </label>
                    <span class="form-error error-font" data-form-error-for="sId_u">فصل را انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 columns padding-lr">
                    <label>ریز فصل
                        <input type="text" name="tsSubject" id="tsSubject_u" required pattern="text">
                    </label>
                    <span class="form-error error-font" data-form-error-for="tsSubject_u">ریز فصل فراموش شده است!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="tsDescription" id="tsDescription_u" style="min-height: 150px;"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr">
                <button name="Submit" onmouseover="setTSCheckExistUrl('{{ url('/budget/admin/sub_seasons/SSIsExist') }}')"  type="submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="updateSubmitActivityCircle">
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
<!--Modal update End-->--}}
<!--Modal Insert Start-->
{{--<div style="z-index: 9999;" class="tiny reveal" id="SSC_ModalInsert" data-reveal data-animation-in="slide-in-down fast bounce" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="modal-margin small-font  padding-lr">
        {!! Form::open(array('v-on:submit.prevent' => 'createTinySeason(1)' , 'class' => 'form' , 'data-abide novalidate')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" id="sscexistErrorInRegForm" style="display: none">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i> ریز فصل با این مشخصات قبلا ثبت شده است!</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 cell padding-lr">
                <label>فصل
                    <select name="sId" id="sscsId" required v-model="tinySeasonsInput.tsSId">
                        <option value=""></option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->sSubject }}</option>
                        @endforeach
                    </select>
                </label>
                <span class="form-error error-font" data-form-error-for="sscsId">فصل را انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>ریز فصل
                    <input type="text" name="tsSubject" id="ssctsSubject" required pattern="text" v-model="tinySeasonsInput.tsSubject">
                </label>
                <span class="form-error error-font" data-form-error-for="ssctsSubject">ریز فصل فراموش شده است!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="tsDescription" id="ssctsDescription" style="min-height: 150px;" v-model="tinySeasonsInput.tsDescription"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
            <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>    <i id="registerSubmitActivityCircle">
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
<<<<<<< HEAD
<!--Modal Insert End-->
<!--Modal Update cost Start-->
<div style="z-index: 9999;" class="tiny reveal" id="SSC_ModalInsert" data-reveal
     data-animation-in="slide-in-down fast bounce" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div id="add-product" class="modal-margin small-font  padding-lr">
        {!! Form::open(array('v-on:submit.prevent' => 'createProduct','id' => 'registerTSCForm' , 'url' => '' , 'class' => 'form' , 'data-abide novalidate')) !!}
=======
<!--Modal Insert End-->--}}
<!-- use the modal component, pass in the prop -->
<modal-tiny v-if="showModal" @close="showModal = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'createTinySeason(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 cell padding-lr">
                <label>فصل
                    <select name="sId" v-model="tinySeasonsInput.tsSId">
                        <option value=""></option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->sSubject }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>ریز فصل
                    <input type="text" name="tsSubject" v-model="tinySeasonsInput.tsSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsInput.tsDescription"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
            <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>
                <i id="registerSubmitActivityCircle">
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
</modal-tiny>
<!-- update modal -->
<modal-tiny v-if="showModalUpdate" @close="showModalUpdate = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'updateTinySeason(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage_update">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage_update }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 cell padding-lr">
                <label>فصل
                    <select name="sId" v-model="tinySeasonsFill.tsSId">
                        <option value=""></option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->sSubject }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>ریز فصل
                    <input type="text" name="tsSubject" v-model="tinySeasonsFill.tsSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsFill.tsDescription"></textarea>
                </label>
            </div>
        </div>
        <div class="medium-6 columns padding-lr">
            <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>
                <i id="registerSubmitActivityCircle">
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
</modal-tiny>
<!-- delete modal -->
<modal-tiny v-if="showModalDelete" @close="showModalDelete = false">
<div  slot="body">
    <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <p>کاربر گرامی</p>
        <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
        <div class="medium-12 text-center">
            <a  class="button primary btn-large-w" v-on:click="deleteTinySeason">بله</a>
        </div>
    </div>
</div>
</modal-tiny>

