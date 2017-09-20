var rowDistributionCredit = new Vue({
    el: '#rowDistributionCredit',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        rowDistributionCredit: [],
        rowDistributionCreditInput: {rdcSubject: '' , rdcDescription: ''},
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        rowDistributionCreditFill: {rdcSubject: '' , rdcDescription: '', id: ''},
        rdcIdDelete: {},
    },

    created: function () {
        this.fetchData();
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },

    methods:{
        fetchData: function () {
            axios.get('/budget/admin/row_distribution_credit/fetchData' , {params:{planOrCost: 1}})
                .then((response) => {
                    this.rowDistributionCredit = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        createRowDistributionCredit: function (type) {
            this.rowDistributionCreditInput.planOrCost = type;
            if (this.rowDistributionCreditInput.rdcSubject != '')
            {
                axios.post('/budget/admin/row_distribution_credit/register' , this.rowDistributionCreditInput)
                    .then((response) => {
                        this.rowDistributionCredit = response.data;
                        this.showModal = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.errorMessage = 'ردیف توزیع اعتبار با این مشخصات قبلا ثبت شده است!';
                    });
            }
            else {
                this.errorMessage = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        rowDistributionCreditUpdateDialog: function (item , type) {
            this.rowDistributionCreditFill.rdcSubject = item.cdSubject;
            this.rowDistributionCreditFill.rdcDescription = item.cdDescription;
            this.rowDistributionCreditFill.id = item.id;
            this.rowDistributionCreditFill.planOrCost = type;
            this.errorMessage_update = '';
            this.showModalUpdate = true;
        },

        updateRowDistributionCredit: function () {
            if (this.rowDistributionCreditFill.rdcSubject != '')
            {
                axios.post('/budget/admin/row_distribution_credit/update' , this.rowDistributionCreditFill)
                    .then((response) => {
                        this.rowDistributionCredit = response.data;
                        this.showModalUpdate = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                    });
            }
            else {
                this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        openDeleteRowDistributionCreditConfirm: function (rdc) {
            this.rdcIdDelete = rdc;
            this.showModalDelete = true;
        },

        deleteRowDistributionCredit: function () {
            axios.post('/budget/admin/row_distribution_credit/delete' , this.rdcIdDelete)
                .then((response) => {
                    this.rowDistributionCredit = response.data;
                    this.showModalDelete = false;
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                });
        }
    }
});