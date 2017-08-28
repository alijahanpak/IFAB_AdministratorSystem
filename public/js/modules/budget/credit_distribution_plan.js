function openCountyPlanAmount(trId) {
    if ($('#' + trId).css('display') == 'none') {
        $('#' + trId).removeClass('display-off').hide().fadeIn();
    } else {
        $('#' + trId).addClass('display-off');
    }
}

function CDPUpdateDialogOpen(countyId , countyAmount , cdrId , cdtId , description) {
    $('#cdpTitle_u').val(cdtId);
    $('#cdpRow_u').val(cdrId);
    for (var i=0 ; i < countyId.length ; i++)
    {
        $('#' + countyId[i]).val(countyAmount[i]);
    }
    $('#cdpDescription_u').val(description);
    $('#cdrId_u').val(cdrId);
    $('#cdtId_u').val(cdtId);
    setTimeout(function () {
        $('#CDP_ModalUpdate').foundation('toggle');
    }, 100);
}

var checkCDPExistUrl = '';
function setCDPCheckExistUrl(url) {
    checkCDPExistUrl = url;
}

var registerCDPFormDataIsExist = true;
var updateCDPFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerCDPForm').submit(function(event) {
    var url = checkCDPExistUrl + '/' + $('#cdpTitle').val() + '/' + $('#cdpRow').val();
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
                registerCDPFormDataIsExist = false;
                $('#registerCDPForm').submit();
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
    if (registerCDPFormDataIsExist == true)
        event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateCDRForm').submit(function(event) {
        if ($('#cdrSubject_u').val() != '') {
            var url = checkCDPExistUrl + '/' + $('#cdrSubject_u').val() + '/' + $('#cdrId_u').val();
            $('#updateSubmitActivityCircle').show();
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function (data) {
                    if (data.exist == true)
                    {
                        $('#existErrorInUpForm').show();
                        setTimeout(function(){ $('#updateSubmitActivityCircle').hide(); } , 2000);
                    }
                    else
                    {
                        updateCDPFormDataIsExist = false;
                        $('#updateCDRForm').submit();
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
        }
        if (updateCDPFormDataIsExist == true)
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

    ////////////////////////////////////////////////////////
});