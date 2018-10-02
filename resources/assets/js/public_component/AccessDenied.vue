<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <modal-access-denied>
        <div  slot="body">
            <div class="text-center accessDenied-frame">
                <h6 class="font-bold" style="font-size: 10em;font-family: Helvetica; color: #FFFFFF;background: #716aca">403</h6>
                <h6 class="text-center BYekan" style="font-size: 50px">دسترسی ممنوع</h6>
                <h6 style="color: #9b9b9b" class="BYekan">شما مجوز دسترسی به این بخش را ندارید</h6>
                <div style="margin-top: 2em">
                    <router-link :to="{ path: '/' + goBackUrl }" :class="BYekan">بازگشت به داشبورد</router-link>
                </div>
            </div>
        </div>
    </modal-access-denied>
</template>
<script>
    export default{
        data () {
            return {
                goBackUrl: ''
            }
        },

        created: function () {
            this.getUrl();

        },

        methods : {
            getUrl: function () {
                if (this.$parent.getUserRole() == 'BUDGET_ADMIN' || this.$parent.getUserRole() == 'BUDGET_EXPERT')
                {
                    this.goBackUrl = 'budget';
                }
                else if (this.$parent.getUserRole() == 'FINANCIAL_DEPARTMENT_ADMIN' || this.$parent.getUserRole() == 'FINANCIAL_DEPARTMENT_EXPERT')
                {
                    this.goBackUrl = 'financial_department';
                }
            },

        }
    }
</script>
