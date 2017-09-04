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
                    letterNumber: $('#capLetterNumber').val()
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

/*    $('#pbpCounty').val('');
    $('#pbpPlanCode').html('<option value=""></option>');
    $('#pbpDescription').val('');
    $('#pbpPlanAmount').val('0');
    $('#pbpProjectTitle').val('');
    $('#pbpProjectCode').val('');
    $('#pbpAmount').val('');
    $('#existErrorInRegForm').hide();*/
});