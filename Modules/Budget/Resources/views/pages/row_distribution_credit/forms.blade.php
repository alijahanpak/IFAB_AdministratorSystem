<!--Modal Insert End-->
<!-- use the modal component, pass in the prop -->
<modal-tiny v-if="showModal" @close="showModal = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => 'createRowDistributionCredit(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>عنوان
                    <input type="text" name="rdcSubject" v-model="rowDistributionCreditInput.rdcSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="rdcDescription" style="min-height: 150px;" v-model="rowDistributionCreditInput.rdcDescription"></textarea>
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

<!-- update modal -->
<modal-tiny v-if="showModalUpdate" @close="showModalUpdate = false">
    <div  slot="body">
        {!! Form::open(array('v-on:submit.prevent' => ' updateRowDistributionCredit(1)')) !!}
        {!! csrf_field() !!}
        <div class="grid-x" v-if="errorMessage_update">
            <div class="medium-12 columns padding-lr">
                <div class="alert callout">
                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage_update }}</p>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="medium-12 columns padding-lr">
                <label>عنوان
                    <input type="text" name="rdcSubject" v-model="rowDistributionCreditInput.rdcSubject">
                </label>
            </div>
        </div>
        <div class="grid-x">
            <div class="small-12 columns padding-lr">
                <label>شرح
                    <textarea name="rdcDescription" style="min-height: 150px;" v-model="rowDistributionCreditInput.rdcDescription"></textarea>
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
                <button  class="button primary btn-large-w" v-on:click="deleteRowDistributionCredit">بله</button>
            </div>
        </div>
    </div>
</div>
</modal-tiny>


