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

var checkCDRExistUrl = '';
function setCDRCheckExistUrl(url) {
    checkCDRExistUrl = url;
}

var checkBSExistUrl = '';
function setBSCheckExistUrl(url) {
    checkBSExistUrl = url;
}

var registerCDRFormDataIsExist = true;
var updateCDRFormDataIsExist = true;

var bs_registerCDRFormDataIsExist = true;
var bs_updateCDRFormDataIsExist = true;
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

    $('#BS_ModalInsert').on('closed.zf.reveal' , function () {
        $('#bsDescription').val('');
        $('#BS_existErrorInRegForm').hide();
    });

    $('#BS_ModalUpdate').on('closed.zf.reveal' , function () {
        $('#bsDescription_u').val('');
        $('#BS_existErrorInUpForm').hide();
    });


    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
});

function checkFySectionPermissionState(url , section , fyId) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/' + section + '/' + fyId,
        success: function (data) {
            if (section == 'budget')
            {
                $('#budgetPermissionAll').prop('checked', data.state);
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
            console.log(msg);
        }
    });
}

function changeFySectionPermissionState(url , section , switchId , fyId , permissionCount) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/changeSectionPermissionState/' + section + '/' + fyId + '/' + ($('#' + switchId).is(':checked') == false ? 0 : 1),
        success: function (data) {
            if (section == 'budget')
            {
                for (var i=0 ; i < permissionCount ; i++)
                {
                    $('#budgetPermission' + i).prop('checked', $('#' + switchId).is(':checked'));
                }
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
            console.log(msg);
        }
    });
}

function changeBudgetItemPermissionState(url , pbId , switchId , fyId) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/changeBudgetItemPermissionState/' + pbId + '/' + ($('#' + switchId).is(':checked') == false ? 0 : 1),
        success: function (data) {
            if (data.state == true)
            {
                checkFySectionPermissionState(url + '/checkSectionPermissionState' , 'budget' , fyId);
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
            console.log(msg);
        }

    });

}