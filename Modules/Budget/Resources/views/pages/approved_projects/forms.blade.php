<!--Modal Insert End-->
<!-- use the modal component, pass in the prop -->
<modal-small v-if="showModal" @close="showModal = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'createApprovedProjects')) !!}
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
                <label>طرح
                    <select style="margin-bottom: 0px;" v-model="approvedProjectsInput.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                        <option value=""></option>
                            <option value="1">1</option>
                    </select>
                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-8 cell padding-lr">
                    <label>عنوان پروژه
                        <input type="text" name="projectTitle" v-model="approvedProjectsInput.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>کد پروژه
                    <input type="text" name="projectCode" v-model="approvedProjectsInput.apProjectCode" v-validate="'required|number'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 cell padding-lr">
                <label>سال شروع
                    <input type="text" name="startYear" v-model="approvedProjectsInput.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                </label>
                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>سال خاتمه
                    <input type="text" name="endYear" v-model="approvedProjectsInput.apEndYear" v-validate="'required|number'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                </label>
                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>نحوه اجرا
                    <select v-model="approvedProjectsInput.apHowToRun" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                        <option value=""></option>
                        <option value="1">1</option>
                    </select>
                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-4 cell padding-lr">
                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                    <input type="text" name="physicalProgress" v-model="approvedProjectsInput.apPhysicalProgress" v-validate="'required|number'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                </label>
                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>شهرستان
                    <select v-model="approvedProjectsInput.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                        <option value=""></option>
                        <option value="1">1</option>
                    </select>
                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
           <div class="medium-4 column padding-lr">
               <label>فصل
                   <select v-model="approvedProjectsInput.apSeason" name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                       <option value=""></option>
                       <option value="1">1</option>
                   </select>
                   <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
               </label>
           </div>
            <div class="medium-8 column padding-lr">
                <label>ریز فصل
                    <select v-model="approvedProjectsInput.apSubSeason" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                        <option value=""></option>
                        <option value="1">1</option>
                    </select>
                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-3 columns padding-lr">
                <p style="margin-top:3px;">سه درصد نفت وگاز</p>
            </div>
            <div class="medium-9 columns padding-lr">
                <label>
                    <input type="text" name="location" v-model="approvedProjectsInput.apLocation" v-validate="'required|number'" :class="{'input': true, 'error-border': errors.has('location')}">
                </label>
                <span v-show="errors.has('location')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsInput.apDescription"></textarea>
                </label>
            </div>
        </div>


        <div class="medium-6 columns padding-lr padding-bottom-modal">
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
</modal-small>
<!-- update modal -->
<modal-tiny v-if="showModalUpdate" @close="showModalUpdate = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'updateTinySeason')) !!}
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

                        <option value="1">1</option>
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
        <div class="medium-6 columns padding-lr padding-bottom-modal">
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
        <div class="grid-x">
            <div class="medium-12 column text-center">
                <button  class="button primary btn-large-w" v-on:click="deleteTinySeason">بله</button>
            </div>
        </div>
    </div>
</div>
</modal-tiny>

