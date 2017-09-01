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

var checkExistUrl = '';
function setCheckExistUrl(url) {
    checkExistUrl = url;
}

var registerDAFormDataIsExist = true;
var updateDAFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerDAForm').submit(function(event) {
        var url = checkExistUrl + '/' + $('#selectCounty').val();
        if ($('#selectRegion').val() != '')
        {
            url += '/' + $('#selectRegion').val();
        }
        if ($('#selectRuralDistrict').val() != '')
        {
            url += '/' + $('#selectRuralDistrict').val();
        }
        if ($('#selectVillage').val() != '')
        {
            url += '/' + $('#selectVillage').val();
        }
        if ($('#selectCounty').val() != '') {
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
                        registerDAFormDataIsExist = false;
                        $('#registerDAForm').submit();
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
        if (registerDAFormDataIsExist == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateDAForm').submit(function(event) {
        var url = checkExistUrl + '/' + $('#daId_u').val() + '/' + $('#selectCounty_u').val();
        if ($('#selectRegion_u').val() != '')
        {
            url += '/' + $('#selectRegion_u').val();
        }
        if ($('#selectRuralDistrict_u').val() != '')
        {
            url += '/' + $('#selectRuralDistrict_u').val();
        }
        if ($('#selectVillage_u').val() != '')
        {
            url += '/' + $('#selectVillage_u').val();
        }
        if ($('#selectCounty_u').val() != '') {
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
                        updateDAFormDataIsExist = false;
                        $('#updateDAForm').submit();
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
        if (updateDAFormDataIsExist == true)
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
