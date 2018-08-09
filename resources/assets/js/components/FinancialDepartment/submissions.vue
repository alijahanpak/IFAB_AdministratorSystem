<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">کارتابل</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>درخواست های ارسالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <button style="width: 120px;" class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="insertDropDown">جدید</button>
                    <div  style="width: 120px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="insertDropDown" data-dropdown data-auto-focus="true">
                        <ul class="my-menu small-font">
                            <li v-for="submissionsTypes in submissionsType" :value="submissionsTypes.id"><a  @click="openSubmissionsModal(submissionsTypes)" v-model="submissionsTypeSelect">{{ submissionsTypes.rtSubject }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="590px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">قیمت</th>
                                <th class="tbl-head-style-cell">شماره</th>
                                <th class="tbl-head-style-cell">تاریخ</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="590px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr v-for="allSubmissions in submissions">
                                    <td>{{allSubmissions.rSubject}}</td>
                                    <td>{{allSubmissions.rCostEstimation}}</td>
                                    <td>{{allSubmissions.rLetterNumber}}</td>
                                    <td>{{allSubmissions.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submission Buy Service Modal -->
        <modal-small v-if="showBuyServiceModal" @close="showBuyServiceModal = false">
            <div  slot="body">
                <div class="small-font">
                   <div class="grid-x">
                       <div class="large-12 medium-12 small-12">
                           <suggestions
                                   v-model="query"
                                   :options="options"
                                   :onInputChange="onCountryInputChange">
                               <div slot="item" slot-scope="props" class="single-item">
                                   <strong>Name: {{props.item}}</strong>
                               </div>
                           </suggestions>
                       </div>
                   </div>
                </div>
            </div>
        </modal-small>
        <!-- Submission Buy Service Modal -->
    </div>
</template>
<script>
    export default {
        data () {
            return {
                submissionsType:{},
                submissions:[],
                showBuyServiceModal:false,
                showBuyCommodityModal:false,
                showFundModal:false,

            }
        },

        created: function(){
            this.fetchData();
            this.fetchSubmissionsType();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            this.$parent.myResize();
        },

        methods: {

            fetchData: function () {
                axios.get('/financial/request/posted/fetchData')
                    .then((response) => {
                        this.submissions = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchSubmissionsType: function () {
                axios.get('/financial/request/types/fetchData')
                    .then((response) => {
                        this.submissionsType = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openSubmissionsModal: function (st) {
                if( st.id == 1){
                    this.showBuyServiceModal=true;
                }
            },

        }
    }
</script>
