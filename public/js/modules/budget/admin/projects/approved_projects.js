var approvedProjects = new Vue({
    el: '#approvedProjects',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        approvedProjects: [],
        approvedProjectsInput: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                                apHowToRun: '', apPhysicalProgress: '', apCity: '', apSeason: '', apSubSeason: ''
                                , apLocation: '', apDescription: '', apCredit:''},
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        approvedProjectsFill: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
            apHowToRun: '', apPhysicalProgress: '', aCity: '', apSeason: '', apSubSeason: ''
            , apLocation: '', apDescription: '',apCredit:''},
        apIdDelete: {},
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


        createApprovedProjects: function () {
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

        approvedProjectsUpdateDialog: function (item) {
            this.approvedProjectsFill.apPlan = item.apPlan;
            this.approvedProjectsFill.apProjectTitle = item.apProjectTitle;
            this.approvedProjectsFill.apProjectCode = item.apProjectCode;
            this.approvedProjectsFill.apStartYear = item.apStartYear;
            this.approvedProjectsFill.apEndYear = item.apEndYear;
            this.approvedProjectsFill.apHowToRun = item.apHowToRun;
            this.approvedProjectsFill.apPhysicalProgress = item.apPhysicalProgress;
            this.approvedProjectsFill.apCity = item.apCity;
            this.approvedProjectsFill.apSeason = item.apSeason;
            this.approvedProjectsFill.apSubSeason = item.apSubSeason;
            this.approvedProjectsFill.apLocation = item.apLocation;
            this.approvedProjectsFill.apDescription = item.apDescription;
            this.errorMessage_update = '';
            this.showModalUpdate = true;
        },

        updateApprovedProjects: function () {
            if (this.approvedProjectsFill.apPlan != '' && this.approvedProjectsFill.apProjectTitle != '' && this.approvedProjectsFill.apProjectCode != '' && this.approvedProjectsFill.apStartYear != '' && this.approvedProjectsFill.apEndYear != ''&& this.approvedProjectsFill.apHowToRun != ''&& this.approvedProjectsFill.apPhysicalProgress != ''&& this.approvedProjectsFill.apCity != ''&& this.approvedProjectsFill.apSeason!= ''&& this.approvedProjectsFill.apSubSeason != '')
            {
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
            }
            else {
                this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        openDeleteApprovedProjectsConfirm: function (ap) {
            this.apIdDelete = ap;
            this.showModalDelete = true;
        },

        deleteApprovedProjects: function () {
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
