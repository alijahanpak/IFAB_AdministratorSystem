function TSUpdateDialogOpen(sId , subject , description , tsId) {
    $('#sId_u').val(sId);
    $('#tsSubject_u').val(subject);
    $('#tsDescription_u').val(description);
    $('#tsId_u').val(tsId);
    setTimeout(function () {
        $('#SS_ModalUpdate').foundation('toggle');
    }, 100);
}

var checkTSExistUrl = '';
function setTSCheckExistUrl(url) {
    checkTSExistUrl = url;
}

var registerTSFormDataIsExist = true;
var updateTSFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerTSForm').submit(function(event) {
        var url = checkTSExistUrl + '/' + $('#sId').val() + '/' + $('#tsSubject').val();
        $('#registerSubmitActivityCircle').show();
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url,
            success: function (data) {
                if (data.exist == true) {
                    $('#existErrorInRegForm').show();
                    setTimeout(function () {
                        $('#registerSubmitActivityCircle').hide();
                    }, 2000);
                }
                else {
                    registerTSFormDataIsExist = false;
                    $('#registerTSForm').submit();
                }
            },
            error: function (jqXHR) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                setTimeout(function () {
                    $('#registerSubmitActivityCircle').hide();
                }, 2000);
                console.log(msg);
            }
        });
        if (registerTSFormDataIsExist == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateTSForm').submit(function(event) {
        var url = checkTSExistUrl + '/' + $('#sId_u').val() + '/' + $('#tsSubject_u').val() + '/' + $('#tsId_u').val();
        $('#updateSubmitActivityCircle').show();
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url,
            success: function (data) {
                if (data.exist == true) {
                    $('#existErrorInUpForm').show();
                    setTimeout(function () {
                        $('#updateSubmitActivityCircle').hide();
                    }, 2000);
                }
                else {
                    updateTSFormDataIsExist = false;
                    $('#updateTSForm').submit();
                }
            },
            error: function (jqXHR) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                setTimeout(function () {
                    $('#updateSubmitActivityCircle').hide();
                }, 2000);
                console.log(msg);
            }
        });
        if (updateTSFormDataIsExist == true)
            event.preventDefault();
    });
    //////////////////////////////////////////////////////////////////////////////////////////////
    /*    $('#cdrSubject').val('');
        $('#cdrDescription').val('');
        $('#existErrorInRegForm').hide();
        $('#existErrorInUpForm').hide();

        $('#CDR_ModalInsert').on('closed.zf.reveal' , function () {
            $('#cdrDescription').val('');
            $('#existErrorInRegForm').hide();
        });

        $('#CDR_ModalUpdate').on('closed.zf.reveal' , function () {
            $('#cdrDescription_u').val('');
            $('#existErrorInUpForm').hide();
        });

        $('#bsSubject').val('');
        $('#bsDescription').val('');
        $('#BS_existErrorInRegForm').hide();
        $('#BS_existErrorInUpForm').hide();
        /////////////
        $('#BS_ModalInsert').on('closed.zf.reveal' , function () {
            $('#bsDescription').val('');
            $('#BS_existErrorInRegForm').hide();
        });

        $('#BS_ModalUpdate').on('closed.zf.reveal' , function () {
            $('#bsDescription_u').val('');
            $('#BS_existErrorInUpForm').hide();
        });
        ////////////
        $('#CDPT_ModalInsert').on('closed.zf.reveal' , function () {
            $('#cdptSelectSeason').val('');
            $('#cdptIdNumber').val('');
            $('#cdptSubject').val('');
            $('#cdptDescription').val('');
            $('#CDPT_existErrorInRegForm').hide();
        });

        $('#CDPT_ModalUpdate').on('closed.zf.reveal' , function () {
            $('#cdptSelectSeason_u').val('');
            $('#cdptIdNumber_u').val('');
            $('#cdptSubject_u').val('');
            $('#cdptDescription_u').val('');
            $('#CDPT_existErrorInUpForm').hide();
        });

        $('#cdptSelectSeason').val('');
        $('#cdptIdNumber').val('');
        $('#cdptSubject').val('');
        $('#cdptDescription').val('');
        $('#CDPT_existErrorInRegForm').hide();
        $('#CDPT_existErrorInUpForm').hide();*/
    ////////////////////////////////////////////////////////
});

Vue.component('modal-tiny', {template: '#modal-tiny-template'});

var tinySeasons = new Vue({
    el: '#tinySeasons',
    data: {
        errorMessage: '',
        errorMessage_update: '',
        tinySeasons: [],
        tinySeasonsInput: {tsSId: '' , tsSubject: '' , tsDescription: '' , planOrCost: ''},
        showModal: false,
        showModalUpdate: false,
        showModalDelete: false,
        tinySeasonsFill: {tsSId: '' , tsSubject: '' , tsDescription: '' , planOrCost: '' , id: ''},
        tsIdDelete: {},
    },

    created: function () {
        this.fetchData();
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },

    methods:{
        fetchData: function () {
            axios.get('/budget/admin/sub_seasons/fetchData' , {params:{planOrCost: 1}})
                .then((response) => {
                    this.tinySeasons = response.data;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
        },

        createTinySeason: function (type) {
            this.tinySeasonsInput.planOrCost = type;
            if (this.tinySeasonsInput.tsSId != '' && this.tinySeasonsInput.tsSubject != '')
            {
                axios.post('/budget/admin/sub_seasons/register' , this.tinySeasonsInput)
                    .then((response) => {
                        this.tinySeasons = response.data;
                        this.showModal = false;
                        this.$notify({group: 'successPm', title: 'پیام ثبت موفق', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                    });
            }
            else {
                this.errorMessage = ' لطفا در وارد کردن اطلاعات دقت کنید!';
            }
        },

        tinySeasonUpdateDialog: function (item , type) {
            this.tinySeasonsFill.tsSId = item.tsSId;
            this.tinySeasonsFill.tsSubject = item.tsSubject;
            this.tinySeasonsFill.tsDescription = item.tsDescription;
            this.tinySeasonsFill.id = item.id;
            this.tinySeasonsFill.planOrCost = type;
            this.errorMessage_update = '';
            this.showModalUpdate = true;
        },

        updateTinySeason: function () {
            if (this.tinySeasonsFill.tsSId != '' && this.tinySeasonsFill.tsSubject != '')
            {
                axios.post('/budget/admin/sub_seasons/update' , this.tinySeasonsFill)
                    .then((response) => {
                        this.tinySeasons = response.data;
                        this.showModalUpdate = false;
                        this.$notify({group: 'successPm', title: 'پیام بروزرسانی موفق', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
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

        openDeleteTinySeasonConfirm: function (ts) {
            this.tsIdDelete = ts;
            this.showModalDelete = true;
        },

        deleteTinySeason: function () {
            axios.post('/budget/admin/sub_seasons/delete' , this.tsIdDelete)
                .then((response) => {
                    this.tinySeasons = response.data;
                    this.showModalDelete = false;
                    this.$notify({group: 'successPm', title: 'پیام حذف موفق', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.$notify({group: 'errorPm', title: 'خطا در حذف رکورد', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                });
        }
    }
});
