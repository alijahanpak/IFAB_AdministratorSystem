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
        approvedPlans: {},
        selectedPlan: '',
        approvedProjects: {},
        creditDistributionRows: {},
        creditDistributionRowInput: {},
    },

    created: function () {
        this.fetchData();
        this.getAllApprovedPlan(0); // 0 = provincial
        this.getCreditDistributionRow();
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },

    methods:{
        fetchData: function () {
            axios.get('/budget/Allocation/register_of_credit_allocation_assets/fetchData' , {params:{planOrCost: 0}})
                .then((response) => {
                    this.registerOfCreditAllocationAssets = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getAllApprovedPlan: function (pOrN) {
            axios.get('/budget/plan/capital_assets/plans/getAllItems' , {params:{pOrN: 0}})
                .then((response) => {
                    this.approvedPlans = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getProjects: function () {
            axios.get('/budget/project/capital_assets/projects/getAllItems' , {params:{pId: this.selectedPlan , planOrCost: 0}})
                .then((response) => {
                    this.approvedProjects = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getCreditDistributionRow: function () {
            axios.get('/budget/admin/credit_distribution_def/rows/getAllItems' , {params:{planOrCost: 0}})
                .then((response) => {
                    this.creditDistributionRows = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        createRegisterOfCreditAllocationAssets: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {
                        axios.post('/budget/Allocation/register_of_credit_allocation_assets/register' , {aInput: this.registerOfCreditAllocationAssetsInput , cdrInput: this.creditDistributionRowInput})
                            .then((response) => {
                                this.registerOfCreditAllocationAssets = response.data;
                                this.showModal = false;
                                this.$notify({group: 'allocationPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'تخصیص با این مشخصات قبلا ثبت شده است!';
                            });
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
