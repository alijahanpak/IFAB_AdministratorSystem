<!--Modal Insert End-->
<!-- use the modal component, pass in the prop -->
<modal-large v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'createRegisterOfCreditAllocationAssets')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-2 padding-lr">
                <label>شماره نامه
                    <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="registerOfCreditAllocationAssetsInput.rocaaNumber">
                </label>
            </div>
            <div class="medium-2 padding-lr">
                <label>تاریخ نامه
                    <input class="form-element-margin-btm" type="text" name="letterDate" v-model="registerOfCreditAllocationAssetsInput.rocaaDate">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 cell padding-lr">
                <label>طرح
                    <select class="form-element-margin-btm"  v-model="selectedPlan" v-on:change="getProjects" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                        <option value=""></option>
                        <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                    </select>
                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-6 cell padding-lr">
                <label>عنوان پروژه
                    <select class="form-element-margin-btm"  v-model="registerOfCreditAllocationAssetsInput.rocaaProject" name="projectTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                        <option value=""></option>
                        <option v-for="project in approvedProjects" :value="project.id">@{{ project.cpCode + ' - ' + project.cpSubject }}</option>
                    </select>
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
            </div>
        </div>
        <div style="margin-top: 15px;" class="grid-x padding-lr">
            <div class="medium-12 my-callout-bg-color">
                <div class="grid-x">
                    <div class="medium-4">
                        <p class="btn-red">ردیف توزیع اعتبار</p>
                    </div>
                    <div class="medium-3">
                        <p class="btn-red">اعتبار مبادله شده</p>
                    </div>
                    <div class="medium-2">
                        <p class="btn-red">آخرین تخصیص</p>
                    </div>
                    <div class="medium-3">
                        <p class="btn-red text-center">مبلغ</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;margin-bottom: 25px;" class="grid-x padding-lr small-font">
            <div class="medium-12">
                <div v-for="creditDistributionRow in creditDistributionRows" class="grid-x input-margin-top">
                    <div class="medium-4 padding-lr">
                        <p>@{{ creditDistributionRow.cdSubject }}</p>
                    </div>
                    <div class="medium-3 padding-lr">
                        <p></p>
                    </div>
                    <div class="medium-2 padding-lr">
                        <p></p>
                    </div>
                    <div style="margin-top: -7px;" class="medium-3 padding-lr">
                        <label>
                            <input class="form-element-margin-btm" type="text" :name="'cost' + creditDistributionRow.id" v-model="creditDistributionRowInput['cost' + creditDistributionRow.id]" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('cost' + creditDistributionRow.id)}">
                        </label>
                        <span v-show="errors.has('cost' + creditDistributionRow.id)" class="error-font">لطفا مبلغ را وارد کنید!</span>
                    </div>
                </div>
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
</modal-large>
<!-- update modal -->

<modal-large v-if="showModalUpdate" @close="showModalUpdate = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'updateRegisterOfCreditAllocationAssets')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-2 padding-lr">
                <label>شماره نامه
                    <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="registerOfCreditAllocationAssetsInput.rocaaNumber">
                </label>
            </div>
            <div class="medium-2 padding-lr">
                <label>تاریخ نامه
                    <input class="form-element-margin-btm" type="text" name="letterDate" v-model="registerOfCreditAllocationAssetsInput.rocaaDate">
                </label>
            </div>
        </div>

        <div class="grid-x">
            <div class="medium-6 cell padding-lr">
                <label>طرح
                    <select class="form-element-margin-btm"  v-model="registerOfCreditAllocationAssetsInput.rocaaPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                        <option value=""></option>
                        <option value="1">1</option>
                    </select>
                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                </label>
            </div>
            <div class="medium-6 cell padding-lr">
                <label>عنوان پروژه
                    <select class="form-element-margin-btm"  v-model="registerOfCreditAllocationAssetsInput.rocaaProject" name="projectTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                        <option value=""></option>
                        <option value="1">1</option>
                    </select>
                </label>
                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
            </div>
        </div>
        <div style="margin-top: 15px;" class="grid-x padding-lr">
            <div class="medium-12 my-callout-bg-color">
                <div class="grid-x">
                    <div class="medium-4">
                        <p class="btn-red">ردیف توزیع اعتبار</p>
                    </div>
                    <div class="medium-3">
                        <p class="btn-red">اعتبار مبادله شده</p>
                    </div>
                    <div class="medium-2">
                        <p class="btn-red">آخرین تخصیص</p>
                    </div>
                    <div class="medium-3">
                        <p class="btn-red text-center">مبلغ</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;margin-bottom: 25px;" class="grid-x padding-lr small-font">
            <div class="medium-12">
                <div class="grid-x">
                    <div class="medium-4 padding-lr">
                        <p>ردیف توزیع اعتبار</p>
                    </div>
                    <div class="medium-3 padding-lr">
                        <p>اعتبار مبادله شده</p>
                    </div>
                    <div class="medium-2 padding-lr">
                        <p>آخرین تخصیص</p>
                    </div>
                    <div style="margin-top: -7px;" class="medium-3 padding-lr">
                        <label>
                            <input class="form-element-margin-btm" type="text" name="cost" v-model="registerOfCreditAllocationAssetsInput.rocaaCost" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('cost')}">
                        </label>
                        <span v-show="errors.has('cost')" class="error-font">لطفا مبلغ را وارد کنید!</span>
                    </div>
                </div>
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
</modal-large>
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

