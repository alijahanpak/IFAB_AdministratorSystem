var titleOfPlans = new Vue({
    el: '#titleOfPlans',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        titleOfPlans: [],
        titleOfPlansInput: {topSeasonBudget: '' , topPlanCode: '' , topPlanSubject: '' , topDescription:'' },
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        titleOfPlansFill: {topSeasonBudget: '' , topPlanCode: '' , topPlanSubject: '' , topDescription:'' , id: ''},
        topIdDelete: {},
    },

    created: function () {
        this.fetchData();
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },

    methods:{
        fetchData: function () {
            /*axios.get('/budget/admin/sub_seasons/fetchData' , {params:{planOrCost: 1}})
                .then((response) => {
                    this.tinySeasons = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });*/
            alert('Fetch')
        },

        createTitleOfPlans: function (type) {
            this.createTitleOfPlansInput.capital_assetsOrCost = type;
            if (this.createTitleOfPlansFill.topSeasonBudget != '' && this.createTitleOfPlansFill. topPlanCode != '' && this.createTitleOfPlansFill.topPlanSubject != '')
            {
                /*axios.post('/budget/admin/sub_seasons/register' , this.tinySeasonsInput)
                    .then((response) => {
                        this.tinySeasons = response.data;
                        this.showModal = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.errorMessage = 'ردیف توزیع اعتبار با این مشخصات قبلا ثبت شده است!';
                    });*/
                alert('درج انجام شد');
            }
            else {
                this.errorMessage = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        titleOfPlansUpdateDialog: function (item , type) {
            this.titleOfPlansFill.topSeasonBudget = item.topSeasonBudget;
            this.titleOfPlansFill.topPlanCode = item.topPlanCode;
            this.titleOfPlansFill.topPlanSubject = item.topPlanSubject;
            this.titleOfPlansFill.topDescription = item.topDescription;
            this.titleOfPlansFill.id = item.id;
            this.titleOfPlansFill.planOrCost = type;
            this.errorMessage_update = '';
            this.showModalUpdate = true;
        },

        updateTitleOfPlans: function () {
            if (this.createTitleOfPlansFill.topSeasonBudget != '' && this.createTitleOfPlansFill. topPlanCode != '' && this.createTitleOfPlansFill.topPlanSubject != '')
            {
                /*axios.post('/budget/admin/sub_seasons/update' , this.tinySeasonsFill)
                    .then((response) => {
                        this.tinySeasons = response.data;
                        this.showModalUpdate = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                    });*/
                alert('ویرایش اجام شد');
            }
            else {
                this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        openDeleteTitleOfPlansConfirm: function (top) {
            this.topIdDelete = top;
            this.showModalDelete = true;
        },

        deleteTitleOfPlans: function () {
            /*axios.post('/budget/admin/sub_seasons/delete' , this.tsIdDelete)
                .then((response) => {
                    this.tinySeasons = response.data;
                    this.showModalDelete = false;
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                });*/
            alert('حذف انجام شد');
        }
    }
});