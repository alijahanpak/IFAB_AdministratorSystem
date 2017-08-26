function CDRUpdateDialogOpen(budgetAdminAjaxUri , subject , description , cdrId) {
    $('#cdrSubject_u').val(subject);
    $('#cdrDescription_u').val(description);
    $('#cdrId_u').val(cdrId);
    $('#CDR_ModalUpdate').foundation('toggle');
}

function BSUpdateDialogOpen(budgetAdminAjaxUri , subject , description , bsId) {
    $('#bsSubject_u').val(subject);
    $('#bsDescription_u').val(description);
    $('#bsId_u').val(bsId);
    $('#BS_ModalUpdate').foundation('toggle');
}

function CDPTUpdateDialogOpen(budgetAdminAjaxUri , bsId , idNumber , subject , description , cdptId) {
    $('#cdptSelectSeason_u').val(bsId);
    $('#cdptIdNumber_u').val(idNumber);
    $('#cdptSubject_u').val(subject);
    $('#cdptDescription_u').val(description);
    $('#cdptId_u').val(cdptId);
    $('#CDPT_ModalUpdate').foundation('toggle');
}


var checkCDRExistUrl = '';
function setCDRCheckExistUrl(url) {
    checkCDRExistUrl = url;
}

var checkBSExistUrl = '';
function setBSCheckExistUrl(url) {
    checkBSExistUrl = url;
}

var checkCDPTExistUrl = '';
function setCDPTCheckExistUrl(url) {
    checkCDPTExistUrl = url;
}

var registerCDRFormDataIsExist = true;
var updateCDRFormDataIsExist = true;

var bs_registerCDRFormDataIsExist = true;
var bs_updateCDRFormDataIsExist = true;

var cdpt_registerCDRFormDataIsExist = true;
var cdpt_updateCDRFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerCDRForm').submit(function(event) {
        if ($('#cdrSubject').val() != '') {
            var url = checkCDRExistUrl + '/' + $('#cdrSubject').val();
            $('#registerSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true) {
                        $('#existErrorInRegForm').show();
                    }
                    else {
                        registerCDRFormDataIsExist = false;
                        $('#registerCDRForm').submit();
                    }
                    setTimeout(function () {
                        $('#registerSubmitActivityCircle').hide();
                    }, 2000);

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
        }
        if (registerCDRFormDataIsExist == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateCDRForm').submit(function(event) {
        if ($('#cdrSubject_u').val() != '') {
            var url = checkCDRExistUrl + '/' + $('#cdrSubject_u').val() + '/' + $('#cdrId_u').val();
            $('#updateSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInUpForm').show();
                    }
                    else
                    {
                        updateCDRFormDataIsExist = false;
                        $('#updateCDRForm').submit();
                    }
                    setTimeout(function(){ $('#updateSubmitActivityCircle').hide(); } , 2000);
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
        }
        if (updateCDRFormDataIsExist == true)
            event.preventDefault();
    });
    //////////////////////////////////////// budget season check exist///////////////////////////////////////
    $('#bsRegisterSubmitActivityCircle').hide();
    $('#registerBSForm').submit(function(event) {
        if ($('#bsSubject').val() != '') {
            var url = checkBSExistUrl + '/' + $('#bsSubject').val();
            $('#bsRegisterSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true) {
                        $('#BS_existErrorInRegForm').show();
                    }
                    else {
                        bs_registerCDRFormDataIsExist = false;
                        $('#registerBSForm').submit();
                    }
                    setTimeout(function () {
                        $('#bsRegisterSubmitActivityCircle').hide();
                    }, 2000);

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
                        $('#bsRegisterSubmitActivityCircle').hide();
                    }, 2000);
                    console.log(msg);
                }
            });
        }
        if (bs_registerCDRFormDataIsExist == true)
            event.preventDefault();
    });

    $('#bsUpdateSubmitActivityCircle').hide();
    $('#updateBSForm').submit(function(event) {
        if ($('#bsSubject_u').val() != '') {
            var url = checkBSExistUrl + '/' + $('#bsSubject_u').val() + '/' + $('#bsId_u').val();
            $('#bsUpdateSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#BS_existErrorInUpForm').show();
                    }
                    else
                    {
                        bs_updateCDRFormDataIsExist = false;
                        $('#updateBSForm').submit();
                    }
                    setTimeout(function(){ $('#bsUpdateSubmitActivityCircle').hide(); } , 2000);
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
                        $('#bsUpdateSubmitActivityCircle').hide();
                    }, 2000);
                    console.log(msg);
                }
            });
        }
        if (bs_updateCDRFormDataIsExist == true)
            event.preventDefault();
    });
    ///////////////////////////////////////// paln title check exist /////////////////////////////
    $('#cdptRegisterSubmitActivityCircle').hide();
    $('#registerCDPTForm').submit(function(event) {
        if ($('#cdptSubject').val() != '') {
            var url = checkCDPTExistUrl + '/' + $('#cdptIdNumber').val() + '/' + $('#cdptSubject').val();
            $('#cdptRegisterSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true) {
                        $('#CDPT_existErrorInRegForm').show();
                    }
                    else {
                        cdpt_registerCDRFormDataIsExist = false;
                        $('#registerCDPTForm').submit();
                    }
                    setTimeout(function () {
                        $('#cdptRegisterSubmitActivityCircle').hide();
                    }, 2000);

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
                        $('#cdptRegisterSubmitActivityCircle').hide();
                    }, 2000);
                    console.log(msg);
                }
            });
        }
        if (cdpt_registerCDRFormDataIsExist == true)
            event.preventDefault();
    });

    $('#cdptUpdateSubmitActivityCircle').hide();
    $('#updateCDPTForm').submit(function(event) {
        if ($('#cdptSubject_u').val() != '') {
            var url = checkCDPTExistUrl + '/' + $('#cdptIdNumber_u').val() + '/' + $('#cdptSubject_u').val() + '/' + $('#cdptId_u').val();
            $('#cdptUpdateSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#CDPT_existErrorInUpForm').show();
                    }
                    else
                    {
                        cdpt_updateCDRFormDataIsExist = false;
                        $('#updateCDPTForm').submit();
                    }
                    setTimeout(function(){ $('#cdptUpdateSubmitActivityCircle').hide(); } , 2000);
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
                        $('#cdptUpdateSubmitActivityCircle').hide();
                    }, 2000);
                    console.log(msg);
                }
            });
        }
        if (cdpt_updateCDRFormDataIsExist == true)
            event.preventDefault();
    });
    //////////////////////////////////////////////////////////////////////////////////////////////

    $('#cdrSubject').val('');
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
    $('#CDPT_existErrorInUpForm').hide();


    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
});

