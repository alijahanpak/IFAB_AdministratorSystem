<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-show="requestTypeDetail == 'SERVICES'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{requestFill.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{requestFill.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{requestFill.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ برآوردی : </td>
                    <td>{{$root.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                </tr>
                <tr>
                    <td width="150px">مبلغ نهایی : </td>
                    <td v-if="parseInt(requestFill.rAcceptedAmount) > 0">{{$root.dispMoneyFormat(requestFill.rAcceptedAmount)}} <span class="btn-red">  ریال  </span></td>
                    <td v-else><span class="reserved-label">فاقد قرارداد</span></td>
                </tr>
                <tr>
                    <td width="150px">شرح کامل خدمات : </td>
                    <td class="text-justify">{{requestFill.rDescription}}</td>
                </tr>
                <tr>
                    <td width="150px">توضیحات تکمیلی : </td>
                    <td class="text-justify">{{requestFill.rFurtherDetails}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-show="requestTypeDetail == 'COMMODITY'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{requestFill.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{requestFill.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{requestFill.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ نهایی : </td>
                    <td v-if="parseInt(requestFill.rAcceptedAmount) > 0">{{$root.dispMoneyFormat(requestFill.rAcceptedAmount)}} <span class="btn-red">  ریال  </span></td>
                    <td v-else><span class="reserved-label">فاقد فاکتور</span></td>
                </tr>
                </tbody>
            </table>

            <table>
                <thead>
                <th class="text-center" width="50">ردیف</th>
                <th class="text-center">شرح و نوع جنس</th>
                <th class="text-center" width="100">تعداد</th>
                <th class="text-center" v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")' width="120">موجودی انبار</th>
                <th class="text-center" width="150">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                <th class="text-center" width="300">توضیحات (موارد مصرف)</th>
                </thead>
                <tbody>

                <tr v-for="(lists,index) in commodityList">
                    <td  align="center">{{index+1}}</td>
                    <td>{{lists.commodity.cSubject}}</td>
                    <td  align="center">{{lists.rcCount - lists.rcExistCount}}</td>
                    <td  align="center" v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")'>
                        <input v-on:change="setRepoExistCount(lists.id,commodityCountInput['existCount' + lists.id])" v-model="commodityCountInput['existCount' + lists.id]"  style="margin-bottom: 0px;" class="form-element-margin-btm" type="text" :name="'repoCount' + lists.id" v-validate="'required','min_value:0','max_value:'+lists.rcCount " data-vv-as="field" :class="{'input': true, 'error-border': errors.has('repoCount' + lists.id)}">
                        <span v-show="errors.has('repoCount' + lists.id)" class="error-font"></span>
                    </td>
                    <td  align="center">{{$root.dispMoneyFormat(lists.rcCostEstimation)}}</td>
                    <td>{{lists.rcDescription}}</td>
                </tr>
                <tr>
                    <td :colspan='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY") ? 4 : 3' class="text-center font-wei-bold"> مجموع برآورد</td>
                    <td colspan="2" class="text-center font-wei-bold">{{$root.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span> </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
            <table>
                <tbody>
                <tr>
                    <td width="150px">شماره : </td>
                    <td>{{requestFill.rLetterNumber}}</td>
                </tr>
                <tr>
                    <td width="150px">تاریخ : </td>
                    <td>{{requestFill.rLetterDate}}</td>
                </tr>
                <tr>
                    <td width="150px">موضوع : </td>
                    <td>{{requestFill.rSubject}}</td>
                </tr>
                <tr>
                    <td width="150px">مبلغ برآوردی : </td>
                    <td>{{$root.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                </tr>
                <tr>
                    <td width="150px">متن درخواست : </td>
                    <td class="text-justify">{{requestFill.rDescription}}</td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
</template>
<script>

    export default{
        props:['requestTypeDetail','requestFill','commodityList'],
        data () {
            return {
                commodityCountInput:{},
                repoExistCount:[],
            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {

        },

        methods : {

            setRepoExistCount: function (cId,count) {
                console.log(JSON.stringify(this.commodityCountInput));
                var repoExistCountInput={};
                repoExistCountInput.rcId=cId;
                repoExistCountInput.existCount=count;

                console.log(JSON.stringify(repoExistCountInput));

                if(this.repoExistCount === undefined || this.repoExistCount.length == 0){
                    this.repoExistCount.push(repoExistCountInput);
                }
                else{
                    this.repoExistCount.forEach((item,index) =>{
                        if(item.rcId ==  repoExistCountInput.rcId){
                            this.repoExistCount.splice(index,1);
                            this.repoExistCount.push(repoExistCountInput);
                        }
                        else{
                            this.repoExistCount.push(repoExistCountInput);
                        }
                    });
                }
                this.$emit('setRepoExistCountParent' , this.repoExistCount);
            },
        }
    }
</script>
