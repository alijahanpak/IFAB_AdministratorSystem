<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12">
            <!--Table Start-->
            <!--Table Head Start-->
            <div class="tbl-div-container">
                <table class="tbl-head">
                    <colgroup>
                        <col width="300px"/>
                        <col width="120px"/>
                        <col width="150px"/>
                        <col width="120px"/>
                        <col width="300px"/>
                        <col width="120px"/>
                        <col width="60px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شماره نامه</th>
                        <th class="tbl-head-style-cell">تاریخ نامه</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell">عملیات</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style dynamic-height-level-modal2">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="300px"/>
                            <col width="120px"/>
                            <col width="150px"/>
                            <col width="120px"/>
                            <col width="300px"/>
                            <col width="120px"/>
                            <col width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="contract in contracts">
                            <td :data-toggle="'contract' + contract.id">{{contract.cSubject}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{$root.dispMoneyFormat(contract.cAmount)}}
                                <div class="clearfix tool-bar">
                                    <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'contract' + contract.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <!--Table Start-->
                                                <div class="tbl_body_style dynamic-height-level-modal3">
                                                    <table class="stack">
                                                        <tbody>
                                                        <tr>
                                                            <td width="150" class="black-color">عنوان  :</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">مبلغ  :</td>
                                                            <td></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--Table Body End-->
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterNumber}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterDate}}</td>
                            <td :data-toggle="'contract' + contract.id" class="one-line">{{contract.cDescription}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 1"><span class="success-label">تایید شده</span></td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                            <td class="text-center"><a @click=""><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
        </div>
    </div>
</template>
<script>

    export default{
        props:['contracts'],
        data () {
            return {

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();

        },

        mounted: function () {

        },

        methods : {
            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },
        }
    }
</script>
