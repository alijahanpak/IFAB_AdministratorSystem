function CAPUpdateDialogOpen(cdtId , lNumber , lDate , exDate , capId , description , pOrN) {
    $('#capPtitle_u').val(cdtId);
    $('#capLetterNumber_u').val(lNumber);
    $('#capLetterDate_u').val(lDate);
    $('#capExchangeDate_u').val(exDate);
    $('#capDescription_u').val(description);
    $('#capId_u').val(capId);
    setTimeout(function () {
        openUpdatePlanForm(pOrN);
    }, 100);
}

var checkCAPExistUrl = '';
function setCAPCheckExistUrl(url) {
    checkCAPExistUrl = url;
}

var registerCAPFormDataIsExist = true;
var updateCAPFormDataIsExist = true;
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
/////////////////////////////////////////////////////////
    $('#capPtitle_u').val('');
    $('#capLetterNumber_u').val('');
    $('#capLetterDate_u').val('');
    $('#capExchangeDate_u').val('');
    $('#capDescription_u').val('');
    $('#capId_u').val('');
    $('#existErrorInUpForm').hide();

    $('#capPtitle').val('');
    $('#capLetterNumber').val('');
    $('#capLetterDate').val('');
    $('#capExchangeDate').val('');
    $('#capDescription').val('');
    $('#existErrorInRegForm').hide();

    $('#CAP_ModalInsert').on('closed.zf.reveal' , function () {
        $('#capPtitle').val('');
        $('#capLetterNumber').val('');
        $('#capLetterDate').val('');
        $('#capExchangeDate').val('');
        $('#capDescription').val('');
        $('#existErrorInRegForm').hide();
    });

    $('#CAP_ModalUpdate').on('closed.zf.reveal' , function () {
        $('#capPtitle_u').val('');
        $('#capLetterNumber_u').val('');
        $('#capLetterDate_u').val('');
        $('#capExchangeDate_u').val('');
        $('#capDescription_u').val('');
        $('#existErrorInUpForm').hide();
    });
});

function openRegisterPlanForm(planType) {
    if (planType == 'provincial')
    {
        $('#capProvinceOrNational').val(0);
    }
    else if (planType == 'national')
    {
        $('#capProvinceOrNational').val(1);
    }
    $('#CAP_ModalInsert').foundation('toggle');
}

function openUpdatePlanForm(planType) {
    if (planType == 'provincial')
    {
        $('#capProvinceOrNational_u').val(0);
    }
    else if (planType == 'national')
    {
        $('#capProvinceOrNational_u').val(1);
    }
    $('#CAP_ModalUpdate').foundation('toggle');
}