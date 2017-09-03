function PBPUpdateDialogOpen(url , rUrl , coId , cdpId , pbpSubject , pbpCode , pbpAmount , pbpId , description) {
    $('#pbpCounty_u').val(coId);
    if ($('#' + coId).val() != '')
    {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#pbpCounty_u').val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].credit_distribution_title.cdtIdNumber + ' - ' + data[i].credit_distribution_title.cdtSubject + ' - ردیف ' + data[i].credit_distribution_row.cdSubject + ' - فصل ' + data[i].credit_distribution_title.budget_season.bsSubject + '</option>';
                }
                $('#pbpPlanCode_u').html(html);
                $('#pbpPlanCode_u').val(cdpId);
                getRemianingAmount(rUrl , 'pbpPlanCode_u' , 'pbpPlanAmount_u');
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
                $('#pbpPlanCode_u').html('<option value=""></option>');
            }
        });
    }
    $('#pbpDescription_u').val(description);
    $('#pbpId_u').val(pbpId);
    $('#pbpProjectTitle_u').val(pbpSubject);
    $('#pbpProjectCode_u').val(pbpCode);
    $('#pbpAmount_u').val(pbpAmount);
    setTimeout(function () {
        $('#PBP_ModalUpdate').foundation('toggle');
    }, 100);
}

function getCDPWithCoId(url , coId , planId) {
    if ($('#' + coId).val() != '')
    {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#' + coId).val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].credit_distribution_title.cdtIdNumber + ' - ' + data[i].credit_distribution_title.cdtSubject + ' - ردیف ' + data[i].credit_distribution_row.cdSubject + ' - فصل ' + data[i].credit_distribution_title.budget_season.bsSubject + '</option>';
                }
                $('#' + planId).html(html);
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
                $('#' + planId).html('<option value=""></option>');
            }
        });
    }
};

function getRemianingAmount(url , planId , disp) {
    if ($('#' + planId).val() != '') {
        $('#' + disp).val('0');
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + '/' + $('#' + planId).val(),
            success: function (data) {
                $('#' + disp).text(data.remainingAmount);
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
}

$('#PBP_ModalInsert').on('closed.zf.reveal' , function () {
    $('#pbpCounty').val('');
    $('#pbpPlanCode').html('<option value=""></option>');
    $('#pbpDescription').val('');
    $('#pbpPlanAmount').val('0');
    $('#pbpProjectTitle').val('');
    $('#pbpProjectCode').val('');
    $('#pbpAmount').val('');
    $('#existErrorInRegForm').hide();
});

var checkPBPExistUrl = '';
function setPBPCheckExistUrl(url) {
    checkPBPExistUrl = url;
}

var registerPBPFormDataIsExist = true;
var updatePBPFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerPBPForm').submit(function(event) {
    var url = checkPBPExistUrl + '/' + $('#pbpProjectTitle').val() + '/' + $('#pbpProjectCode').val();
    if ($('#pbpCounty').val() != '') {
        $('#registerSubmitActivityCircle').show();
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url,
            success: function (data) {
                if (data.exist == true)
                {
                    $('#existErrorInRegForm').show();
                    setTimeout(function(){ $('#registerSubmitActivityCircle').hide(); } , 2000);
                }
                else
                {
                    registerPBPFormDataIsExist = false;
                    $('#registerPBPForm').submit();
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
    if (registerPBPFormDataIsExist == true)
        event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updatePBPForm').submit(function(event) {
        var url = checkPBPExistUrl + '/' + $('#pbpProjectTitle_u').val() + '/' + $('#pbpProjectCode_u').val() + '/' + $('#pbpId_u').val();
        if ($('#pbpCounty_u').val() != '') {
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
                        updatePBPFormDataIsExist = false;
                        $('#updatePBPForm').submit();
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
        if (updatePBPFormDataIsExist == true)
            event.preventDefault();
    });

    $('#pbpCounty').val('');
    $('#pbpPlanCode').html('<option value=""></option>');
    $('#pbpDescription').val('');
    $('#pbpPlanAmount').val('0');
    $('#pbpProjectTitle').val('');
    $('#pbpProjectCode').val('');
    $('#pbpAmount').val('');
    $('#existErrorInRegForm').hide();
});
