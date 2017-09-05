function CAPUpdateDialogOpen(cdRowId , cdRowAmount , cdtId , lNumber , lDate , exDate , pType , capId , description) {
    $('#capPtitle_u').val(cdtId);
    for (var i=0 ; i < cdRowId.length ; i++)
    {
        $('#' + cdRowId[i]).val(cdRowAmount[i]);
    }
    $('#capLetterNumber_u').val(lNumber);
    $('#capLetterDate_u').val(lDate);
    $('#capExchangeDate_u').val(exDate);
    $('#capPlanType_u').val(pType);
    $('#capDescription_u').val(description);
    $('#capId_u').val(capId);
    setTimeout(function () {
        $('#CAP_ModalUpdate').foundation('toggle');
    }, 100);
}

var checkCAPExistUrl = '';
function setCAPCheckExistUrl(url) {
    checkCAPExistUrl = url;
}

var registerCAPFormDataIsExist = true;
var updateCAPFormDataIsExist = true;
var registerCAPFormDataIsExist_n = true;
var updateCAPFormDataIsExist_n = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerCAPForm').submit(function(event) {
        if ($('#capPtitle').val() != '') {
            $('#registerSubmitActivityCircle').show();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data:{
                    cdtId: $('#capPtitle').val(),
                    letterNumber: $('#capLetterNumber').val(),
                    pORn: $('#capProvinceOrNational').val()
                },
                url: checkCAPExistUrl,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInRegForm').show();
                        setTimeout(function(){ $('#registerSubmitActivityCircle').hide(); } , 2000);
                    }
                    else
                    {
                        registerCAPFormDataIsExist = false;
                        $('#registerCAPForm').submit();
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
                    setTimeout(function(){ $('#registerSubmitActivityCircle').hide(); } , 2000);
                    console.log(msg);
                }
            });
        }
        if (registerCAPFormDataIsExist == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateCAPForm').submit(function(event) {
        if ($('#capPtitle_u').val() != '') {
            $('#updateSubmitActivityCircle').show();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data:{
                    cdtId: $('#capPtitle_u').val(),
                    letterNumber: $('#capLetterNumber_u').val(),
                    pORn: $('#capProvinceOrNational_u').val(),
                    capId: $('#capId_u').val()
                },
                url: checkCAPExistUrl,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInUpForm').show();
                        setTimeout(function(){ $('#updateSubmitActivityCircle').hide(); } , 2000);
                    }
                    else
                    {
                        updateCAPFormDataIsExist = false;
                        $('#updateCAPForm').submit();
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

                    setTimeout(function(){ $('#updateSubmitActivityCircle').hide(); } , 2000);
                    console.log(msg);
                }
            });
        }
        if (updateCAPFormDataIsExist == true)
            event.preventDefault();
    });
///////////////////////////////////////////////////////////////////////
    $('#registerSubmitActivityCircle_n').hide();
    $('#registerNCAPForm').submit(function(event) {
        if ($('#ncapPtitle').val() != '') {
            $('#registerSubmitActivityCircle_n').show();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data:{
                    cdtId: $('#ncapPtitle').val(),
                    letterNumber: $('#ncapLetterNumber').val(),
                    pORn: $('#ncapProvinceOrNational').val()
                },
                url: checkCAPExistUrl,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInRegForm_n').show();
                        setTimeout(function(){ $('#registerSubmitActivityCircle_n').hide(); } , 2000);
                    }
                    else
                    {
                        registerCAPFormDataIsExist_n = false;
                        $('#registerNCAPForm').submit();
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
                    setTimeout(function(){ $('#registerSubmitActivityCircle_n').hide(); } , 2000);
                    console.log(msg);
                }
            });
        }
        if (registerCAPFormDataIsExist_n == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle_n').hide();
    $('#updateNCAPForm').submit(function(event) {
        if ($('#ncapPtitle_u').val() != '') {
            $('#updateSubmitActivityCircle_n').show();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data:{
                    cdtId: $('#ncapPtitle_u').val(),
                    letterNumber: $('#ncapLetterNumber_u').val(),
                    pORn: $('#ncapProvinceOrNational_u').val(),
                    capId: $('#ncapId_u').val()
                },
                url: checkCAPExistUrl,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInUpForm_n').show();
                        setTimeout(function(){ $('#updateSubmitActivityCircle_n').hide(); } , 2000);
                    }
                    else
                    {
                        updateCAPFormDataIsExist_n = false;
                        $('#updateNCAPForm').submit();
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

                    setTimeout(function(){ $('#updateSubmitActivityCircle_n').hide(); } , 2000);
                    console.log(msg);
                }
            });
        }
        if (updateCAPFormDataIsExist_n == true)
            event.preventDefault();
    });

    $('#capPtitle_u').val('');
    $('#capLetterNumber_u').val('');
    $('#capLetterDate_u').val('');
    $('#capExchangeDate_u').val('');
    $('#capPlanType_u').val('');
    $('#capDescription_u').val('');
    $('#capId_u').val('');
    $('#existErrorInUpForm').hide();

    $('#capPtitle').val('');
    $('#capLetterNumber').val('');
    $('#capLetterDate').val('');
    $('#capExchangeDate').val('');
    $('#capPlanType').val('');
    $('#capDescription').val('');
    $('#existErrorInRegForm').hide();

    $('#CAP_ModalInsert').on('closed.zf.reveal' , function () {
        $('#capPtitle').val('');
        $('#capLetterNumber').val('');
        $('#capLetterDate').val('');
        $('#capExchangeDate').val('');
        $('#capPlanType').val('');
        $('#capDescription').val('');
        $('#existErrorInRegForm').hide();
    });

    $('#CAP_ModalUpdate').on('closed.zf.reveal' , function () {
        $('#capPtitle_u').val('');
        $('#capLetterNumber_u').val('');
        $('#capLetterDate_u').val('');
        $('#capExchangeDate_u').val('');
        $('#capPlanType_u').val('');
        $('#capDescription_u').val('');
        $('#existErrorInUpForm').hide();
    });
});