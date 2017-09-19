<!--Modal Insert End-->
<!-- use the modal component, pass in the prop -->
<modal-small v-if="showModal" @close="showModal = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'createTitleOfPlans(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 cell padding-lr">
                <label>فصل بودجه
                    <select name="topSeasonBudget" v-model="titleOfPlansInput.topSeasonBudget">
                        <option value=""></option>
                            <option value="1"></option>
                    </select>
                </label>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>کد برنامه
                    <input type="text" name="topPlanCode" v-model="titleOfPlansInput.topPlanCode">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>عنوان طرح
                    <input type="text" name="topPlanCode" v-model="titleOfPlansInput.topPlanSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="topDescription" style="min-height: 150px;" v-model="titleOfPlansInput.topDescription"></textarea>
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
<modal-small v-if="showModalUpdate" @close="showModalUpdate = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'updateTitleOfPlans(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-6 cell padding-lr">
                <label>فصل بودجه
                    <select name="topSeasonBudget" v-model="titleOfPlansInput.topSeasonBudget">
                        <option value=""></option>
                        <option value="1"></option>
                    </select>
                </label>
            </div>
            <div class="medium-6 columns padding-lr">
                <label>کد برنامه
                    <input type="text" name="topPlanCode" v-model="titleOfPlansInput.topPlanCode">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>عنوان طرح
                    <input type="text" name="topPlanCode" v-model="titleOfPlansInput.topPlanSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="rdcDescription" style="min-height: 150px;" v-model="titleOfPlansInput.topDescription"></textarea>
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
                <button  class="button primary btn-large-w" v-on:click="deleteRowDistributionCredit">بله</button>
            </div>
        </div>
    </div>
</div>
</modal-tiny>
