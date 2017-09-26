var registerOfCreditAllocationAssets = new Vue({
    el: '#registerOfCreditAllocationAssets',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        registerOfCreditAllocationAssets: [],
        registerOfCreditAllocationAssetsInput: {rocaPlan: '' ,rocaaProject:'',rocaaRow:'',roccaCost:'',rocaaNumber:'',rocaaDate:''},
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        registerOfCreditAllocationAssetsFill: {rocaPlan: '' ,rocaaProject:'',rocaaRow:'',roccaCost:'',rocaaNumber:'',rocaaDate:''},
        rocaaIdDelete: {},
    },

    created: function () {
        this.fetchData();
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },

    methods:{
        fetchData: function () {
            /*axios.get('/budget/admin/sub_seasons/fetchData' , {params:{planOrCost: 0}})
                .then((response) => {
                    this.tinySeasons = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });*/
            alert('Fetch Data');
        },

        createRegisterOfCreditAllocationAssets: function () {

            this.$validator.validateAll().then((result) => {
                if (result) {
                        /*axios.post('/budget/admin/sub_seasons/register' , this.tinySeasonsInput)
                            .then((response) => {
                                if(this.planOrCost == 1)
                                    this.tinySeasonsCost = response.data;
                                else
                                    this.tinySeasons = response.data;
                                this.showModal = false;
                                this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                                this.tinySeasonsInput = [];
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });*/
                        alert('ثبت انجام شد');
                }
            });
        },

        registerOfCreditAllocationAssetsUpdateDialog: function (item) {
            this.registerOfCreditAllocationAssetsFill.rocaPlan = item.rocaPlan;
            this.registerOfCreditAllocationAssetsFill.rocaaProject = item.rocaaProject;
            this.registerOfCreditAllocationAssetsFill.rocaaRow = item.rocaaRow;
            this.registerOfCreditAllocationAssetsFill.roccaCost = item.roccaCost;
            this.registerOfCreditAllocationAssetsFill.rocaaNumber = item.rocaaNumber;
            this.registerOfCreditAllocationAssetsFill.rocaaDate = item.rocaaDate;

            this.errorMessage_update = '';
            this.showModalUpdate = true;
        },

        updateRegisterOfCreditAllocationAssets: function () {

                    /*axios.post('/budget/admin/sub_seasons/update' , this.tinySeasonsFill)
                        .then((response) => {
                            if(this.planOrCost == 1)
                                this.tinySeasonsCost = response.data;
                            else
                                this.tinySeasons = response.data;
                            this.showModalUpdate = false;
                            this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                        });*/
                    alert('ویرایش انجام شد');

            },

        openDeleteRegisterOfCreditAllocationAssetsConfirm: function (rocaa) {
            this.apIdDelete = rocaa;
            this.showModalDelete = true;
        },

        deleteRegisterOfCreditAllocationAssets: function () {
            /*axios.post('/budget/admin/sub_seasons/delete' , this.tsIdDelete)
                .then((response) => {
                    if(response.data.tsPlanOrCost == 1)
                        this.tinySeasonsCost = response.data;
                    else
                        this.tinySeasons = response.data;
                    this.showModalDelete = false;
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                });*/
        }
    }
});
