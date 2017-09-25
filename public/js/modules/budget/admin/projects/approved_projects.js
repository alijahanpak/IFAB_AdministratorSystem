var approvedProjects = new Vue({
    el: '#approvedProjects',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        approvedProjects: [],
        approvedProjectsInput: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                                apHowToRun: '', apPhysicalProgress: '', apCity: '', apSubSeason: ''
                                , apDescription: ''},
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        approvedProjectsFill: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
            apHowToRun: '', apPhysicalProgress: '', aCity: '', apSubSeason: ''
            , apLocation: '', apDescription: '',apCredit:''},
        apIdDelete: {},
        approvedPlans: {},
        counties: {},
        seasons: {},
        tinySeasons: {},
        selectedSeasons: '',
        creditDistributionRows: {},
        creditDistributionRowInput: {}
    },

    created: function () {
        this.fetchData();
        this.getAllApprovedPlan(0); // 0 = provincial
        this.getHowToRun();
        this.getCounties();
        this.getSeasons();
        this.getCreditDistributionRow();
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

        getHowToRun: function () {
            axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
                .then((response) => {
                    this.howToRuns = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getHowToRun: function () {
            axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
                .then((response) => {
                    this.howToRuns = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getCounties: function () {
            axios.get('/admin/get_all_counties' , {params:{}})
                .then((response) => {
                    this.counties = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getSeasons: function () {
            axios.get('/admin/get_all_seasons' , {params:{}})
                .then((response) => {
                    this.seasons = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        getTinySeasons: function () {
            axios.get('/budget/admin/sub_seasons/get_tiny_seasons_whit_season_id' , {params:{sId: this.selectedSeasons , planOrCost: 0}})
                .then((response) => {
                    this.tinySeasons = response.data;
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

        createApprovedProjects: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {

                }
            });

            this.creditDistributionRows.forEach(cdr => {
                "use strict";
                this.$set(this.creditDistributionRowInput , 'apCdr' + cdr.id);
            });

            this.creditDistributionRowInput.forEach(temp => {
                "use strict";
                alert("morteza");
            });
            axios.post('/budget/project/capital_assets/projects/register' , {pInput: this.approvedProjectsInput , cdrInput: this.creditDistributionRowInput})
                .then((response) => {
                    this.showModal = false;
                    this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                    console.log(response);
                },(error) => {
                    console.log(error);
                    //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
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
