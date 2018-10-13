<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>قالب چک
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr">
                <div class="medium-12 padding-lr" style="margin-top: 15px;">
                    <div class="clearfix tool-bar">
                        <div style="margin-bottom: 0;" class="button-group float-right">
                            <a class="my-button toolbox-btn small" @click="openAddNewCheckModal()">جدید</a>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 3px" class="medium-12 column padding-lr">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="80px"/>
                                <col width="500px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">ردیف</th>
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">وضعیت</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="80px"/>
                                    <col width="500px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getCheckTemplate()">
                                    <td>1</td>
                                    <td>چک یک</td>
                                    <td>فعال</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Check Template modal -->
        <modal-large v-if="showAddNewCheckModal" @close="showAddNewCheckModal = false">
            <div slot="body" class="container-vh">
                <form v-on:submit.prevent="insertNewCheck" >
                    <div class="small-font inner-vh">
                        <div style="height: 70vh;" class="grid-x inner-vh-unsize">
                            <div style="border-left: solid 1px #D8DEE2;" class="large-5 medium-6 small-12">
                                <div class="grid-x">
                                    <div class="large-8 medium-8 small-12 padding-lr">
                                        <label>موضوع
                                            <input type="text" name="checkSubject" v-model="inputCheck.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('checkSubject')}">
                                        </label>
                                        <p v-show="errors.has('checkSubject')" class="error-font">لطفا نام را برای چک مورد نظر را وارد نمایید!</p>
                                    </div>
                                    <div class="large-4 medium-4 small-12">
                                        <label> فعال
                                            <div class="switch tiny">
                                                <input checked="false" v-model="inputCheck.state" class="switch-input" id="is-require-state" type="checkbox">
                                                <label class="switch-paddle" for="is-require-state">
                                                    <span class="switch-active" aria-hidden="true">بلی</span>
                                                    <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                </label>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-6 medium-6 small-12 padding-lr">
                                        <label>چک
                                            <input placeholder="طول" type="text" name="height" v-model="inputCheck.height" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('height')}">
                                        </label>
                                        <p v-show="errors.has('height')" class="error-font"></p>
                                    </div>
                                    <div class="large-6 medium-6 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="عرض" type="text" name="width" v-model="inputCheck.width" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('width')}">
                                        </label>
                                        <p v-show="errors.has('width')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>تاریخ
                                            <input placeholder="فاصله از بالا" type="text" name="dateTop" v-model="inputCheck.dateTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('dateTop')}">
                                        </label>
                                        <p v-show="errors.has('dateTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="dateRight" v-model="inputCheck.dateRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('dateRight')}">
                                        </label>
                                        <p v-show="errors.has('dateRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="dateWidth" v-model="inputCheck.dateWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('dateWidth')}">
                                        </label>
                                        <p v-show="errors.has('dateWidth')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>بابت
                                            <input placeholder="فاصله از بالا" type="text" name="forTop" v-model="inputCheck.forTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('forTop')}">
                                        </label>
                                        <p v-show="errors.has('forTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="forRight" v-model="inputCheck.forRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('forRight')}">
                                        </label>
                                        <p v-show="errors.has('forRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="forWidth" v-model="inputCheck.forWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('forWidth')}">
                                        </label>
                                        <p v-show="errors.has('forWidth')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>در وجه
                                            <input placeholder="فاصله از بالا" type="text" name="payToTop" v-model="inputCheck.payToTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('payToTop')}">
                                        </label>
                                        <p v-show="errors.has('payToTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="payToRight" v-model="inputCheck.payToRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('payToRight')}">
                                        </label>
                                        <p v-show="errors.has('payToRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="payToWidth" v-model="inputCheck.payToWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('payToWidth')}">
                                        </label>
                                        <p v-show="errors.has('payToWidth')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>مبلغ به حروف
                                            <input placeholder="فاصله از بالا" type="text" name="stringAmountTop" v-model="inputCheck.stringAmountTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('stringAmountTop')}">
                                        </label>
                                        <p v-show="errors.has('stringAmountTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="stringAmountRight" v-model="inputCheck.stringAmountRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('stringAmountRight')}">
                                        </label>
                                        <p v-show="errors.has('stringAmountRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="stringAmountWidth" v-model="inputCheck.stringAmountWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('stringAmountWidth')}">
                                        </label>
                                        <p v-show="errors.has('stringAmountWidth')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>مبلغ به عدد
                                            <input placeholder="فاصله از بالا" type="text" name="amountTop" v-model="inputCheck.amountTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('amountTop')}">
                                        </label>
                                        <p v-show="errors.has('amountTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="amountRight" v-model="inputCheck.amountRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('amountRight')}">
                                        </label>
                                        <p v-show="errors.has('amountRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="amountWidth" v-model="inputCheck.amountWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('amountWidth')}">
                                        </label>
                                        <p v-show="errors.has('amountWidth')" class="error-font"></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="large-4 medium-4 small-12 padding-lr">
                                        <label>امضا
                                            <input placeholder="فاصله از بالا" type="text" name="signatureTop" v-model="inputCheck.amountTop" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('signatureTop')}">
                                        </label>
                                        <p v-show="errors.has('signatureTop')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="فاصله از راست" type="text" name="signatureRight" v-model="inputCheck.signatureRight" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('signatureRight')}">
                                        </label>
                                        <p v-show="errors.has('signatureRight')" class="error-font"></p>
                                    </div>
                                    <div class="large-4 medium-4 small-12 mt-none-label padding-lr">
                                        <label>
                                            <input placeholder="اندازه" type="text" name="signatureWidth" v-model="inputCheck.signatureWidth" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('signatureWidth')}">
                                        </label>
                                        <p v-show="errors.has('signatureWidth')" class="error-font"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="large-7 medium-6 small-12 padding-lr">
                                <div style="border: solid 1px #D8DEE2;height: 8cm;margin-top:20vh;" >
                                    <p :style="{'margin-top': inputCheck.dateTop +'cm','margin-right': inputCheck.dateRight +'cm','width': inputCheck.dateWidth +'cm'}">####/##/##</p>
                                </div>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button type="submit" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-large>
        <!-- Add New Check Template modal -->

        <!-- Show Check Template modal -->
        <modal-small v-if="showGetCheckModal" @close="showGetCheckModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12">
                            <template>
                                <div class="printJSClass" id="printJS-form">
                                    <div style="border: 1px solid #000000;background-color: antiquewhite;width: 17cm;height: 8.5cm;padding-right: 0.9cm;padding-top: 1cm">
                                        <p style="margin-right: 1cm">1397/07/11</p>
                                        <p style="margin-right: 2cm">یازده- هفت - یکهزار و سیصد و نود و هفت</p>
                                        <p style="margin-top: 1.5cm;margin-right:3.5cm">دویست و پنجاه میلیون </p>
                                        <p style="margin-right:1cm">شرکت ایمن بنیان </p>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
                <div class="grid-x small-top-m">
                    <div class="large-12 medium-12 small-12 padding-lr">
                        <div class="stacked-for-small button-group float-left">
                            <button onclick="printJS({ printable: 'printJS-form', type: 'html',targetStyles:['direction','font-family']})" class="my-button my-success float-left"><span class="btn-txt-mrg">  چاپ </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- Show Check Template modal -->
    </div>
</template>
<style>
    .printJSClass{
        direction: rtl;
        font-family: BZar;
    }
</style>
<script>

    export default {
        data () {
            return {
                showAddNewCheckModal:false,
                showGetCheckModal:false,
                inputCheck:{},
                AllCheckFormat:[],
            }
        },

        created: function(){
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {
            this.$parent.myResize();
        },

        methods: {

            fetchAllCheckFormat: function () {
                axios.get('/financial/admin/check/format/fetch')
                    .then((response) => {
                        this.AllCheckFormat = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-280) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            openAddNewCheckModal: function () {
                this.showAddNewCheckModal=true;
            },

            insertNewCheck: function(){
                axios.post('/financial/admin/check/format/register', {
                    subject:this.inputCheck.subject,
                    state:this.inputCheck.state = true ? 1 : 0,
                    dateTop:this.inputCheck.dateTop,
                    dateRight:this.inputCheck.dateRight,
                    dateWidth:this.inputCheck.dateWidth,
                    forTop:this.inputCheck.forTop,
                    forRight:this.inputCheck.forRight,
                    forWidth:this.inputCheck.forWidth,
                    payToTop:this.inputCheck.payToTop,
                    payToRight:this.inputCheck.payToRight,
                    payToWidth:this.inputCheck.payToWidth,
                    stringAmountTop:this.inputCheck.stringAmountTop,
                    stringAmountRight:this.inputCheck.stringAmountRight,
                    stringAmountWidth:this.inputCheck.stringAmountWidth,
                    amountTop:this.inputCheck.amountTop,
                    amountRight:this.inputCheck.amountRight,
                    amountWidth:this.inputCheck.amountWidth,
                    signatureTop:this.inputCheck.signatureTop,
                    signatureRight:this.inputCheck.signatureRight,
                    signatureWidth:this.inputCheck.signatureWidth,
                    width:this.inputCheck.width,
                    height:this.inputCheck.height,
                }).then((response) => {
                    this.AllCheckFormat = response.data;
                    this.showAddNewCheckModal=false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            getCheckTemplate: function () {
               this.showGetCheckModal=true;
            },

            printCheckTemplate: function (divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = "<html><head><title></title></head><body>" +
                    printContents + "</body>";

                window.print();
                document.body.innerHTML = originalContents;
            },
    }
}
</script>
