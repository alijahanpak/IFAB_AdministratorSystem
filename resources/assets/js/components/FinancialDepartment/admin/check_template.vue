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
                            <a class="my-button toolbox-btn small" @click="openInsertModal()">جدید</a>
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

        <!-- Show Check Template modal -->
        <modal-small v-if="showGetCheckModal" @close="showGetCheckModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12">
                            <div id="printMe">
                                <div style="border: 1px solid #000000;background-color: antiquewhite;width: 17cm;height: 8.5cm;padding-right: 0.9cm;padding-top: 1cm">
                                    <p style="margin-right: 1cm">1397/07/11</p>
                                    <p style="margin-right: 2cm">یازده- هفت - یکهزار و سیصد و نود و هفت</p>
                                    <p style="margin-top: 1.5cm;margin-right:3.5cm">دویست و پنجاه میلیون </p>
                                    <p style="margin-right:1cm">شرکت ایمن بنیان </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid-x small-top-m">
                    <div class="large-12 medium-12 small-12 padding-lr">
                        <div class="stacked-for-small button-group float-left">
                            <button @click="printCheckTemplate('printMe')" class="my-button my-success float-left"><span class="btn-txt-mrg">  چاپ </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- Show Check Template modal -->
    </div>
</template>

<script>

    export default {
        data () {
            return {
                showGetCheckModal:false,
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

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-280) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            getCheckTemplate: function () {
               this.showGetCheckModal=true;
            },

            printCheckTemplate: function (divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            },
    }
}
</script>
