<!--Modal Insert End-->
<!-- use the modal component, pass in the prop -->
<modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                    <select  class="form-element-margin-btm"  v-model="approvedProjectsInput.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                        <option value=""></option>
                        <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                    </select>
                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-8 cell padding-lr">
                    <label>عنوان پروژه
                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsInput.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>کد پروژه
                    <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsInput.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 cell padding-lr">
                <label>سال شروع
                    <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsInput.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                </label>
                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>سال خاتمه
                    <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsInput.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                </label>
                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>نحوه اجرا
                    <select class="form-element-margin-btm" v-model="approvedProjectsInput.apHowToRun" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                        <option value=""></option>
                        <option v-for="howToRun in howToRuns" :value="howToRun.id">@{{ howToRun.htrSubject }}</option>
                    </select>
                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-4 cell padding-lr">
                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                    <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-model="approvedProjectsInput.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                    <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                        <div class="progress-meter" style="width: 75%"></div>
                    </div>
                </label>
                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>شهرستان
                    <select class="form-element-margin-btm" v-model="approvedProjectsInput.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                        <option value=""></option>
                        <option v-for="county in counties" :value="county.id">@{{ county.coName }}</option>
                    </select>
                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
           <div class="medium-4 column padding-lr">
               <label>فصل
                   <select class="form-element-margin-btm" v-model="selectedSeasons" v-on:change="getTinySeasons" name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                       <option value=""></option>
                       <option v-for="season in seasons" :value="season.id">@{{ season.sSubject }}</option>
                   </select>
                   <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
               </label>
           </div>
            <div class="medium-8 column padding-lr">
                <label>ریز فصل
                    <select class="form-element-margin-btm" v-model="approvedProjectsInput.apSubSeason" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                        <option value=""></option>
                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">@{{ tinySeason.tsSubject }}</option>
                    </select>
                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div v-for="creditDistributionRow in creditDistributionRows" style="margin-top: 20px;" class="grid-x">
            <div class="medium-4 columns padding-lr">
                <p style="margin-top:5px;">@{{ creditDistributionRow.cdSubject }}</p>
            </div>
            <div  class="medium-4 columns padding-lr">
                <label>
                    <input class="form-element-margin-btm" type="text" :name="'apCdr' + creditDistributionRow.id" v-model="creditDistributionRowInput['apCdr' + creditDistributionRow.id]" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('apCdr' + creditDistributionRow.id)}">
                </label>
                <span v-show="errors.has('apCdr' + creditDistributionRow.id)" class="error-font">لطفا مبلغ اعتبار را وارد کنید (حداقل ۰)!</span>
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
<modal-small v-if="showModalUpdate" @close="showModalUpdate = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'updateApprovedProjects')) !!}
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
                    <select class="form-element-margin-btm"  v-model="approvedProjectsFill.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                        <option value=""></option>
                        <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                    </select>
                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-8 cell padding-lr">
                <label>عنوان پروژه
                    <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsFill.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>کد پروژه
                    <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsFill.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 cell padding-lr">
                <label>سال شروع
                    <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsFill.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                </label>
                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>سال خاتمه
                    <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsFill.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                </label>
                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>نحوه اجرا
                    <select class="form-element-margin-btm" v-model="approvedProjectsFill.apHowToRun" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                        <option value=""></option>
                        <option v-for="howToRun in howToRuns" :value="howToRun.id">@{{ howToRun.htrSubject }}</option>
                    </select>
                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-4 cell padding-lr">
                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                    <input  type="number" min="0" max="100" value="0"  name="physicalProgress" v-model="approvedProjectsFill.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                </label>
                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
            </div>
            <div class="medium-4 cell padding-lr">
                <label>شهرستان
                    <select class="form-element-margin-btm" v-model="approvedProjectsFill.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                        <option value=""></option>
                        <option v-for="county in counties" :value="county.id">@{{ county.coName }}</option>
                    </select>
                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-4 column padding-lr">
                <label>فصل
                    <select class="form-element-margin-btm" v-model="selectedSeasons" v-on:change="getTinySeasons" name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                        <option value=""></option>
                        <option v-for="season in seasons" :value="season.id">@{{ season.sSubject }}</option>
                    </select>
                    <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-8 column padding-lr">
                <label>ریز فصل
                    <select class="form-element-margin-btm" v-model="approvedProjectsFill.apSubSeason" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                        <option value=""></option>
                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">@{{ tinySeason.tsSubject }}</option>
                    </select>
                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                </label>
            </div>
        </div>
        <div v-for="creditDistributionRow in creditDistributionRows" style="margin-top: 20px;" class="grid-x">
            <div class="medium-4 columns padding-lr">
                <p style="margin-top:5px;">@{{ creditDistributionRow.cdSubject }}</p>
            </div>
            <div  class="medium-4 columns padding-lr">
                <label>
                    <input class="form-element-margin-btm" type="text" :name="'apCdr' + creditDistributionRow.id" v-model="creditDistributionRowInput['apCdr' + creditDistributionRow.id]" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('apCdr' + creditDistributionRow.id)}">
                </label>
                <span v-show="errors.has('apCdr' + creditDistributionRow.id)" class="error-font">لطفا مبلغ اعتبار را وارد کنید (حداقل ۰)!</span>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsFill.apDescription"></textarea>
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

