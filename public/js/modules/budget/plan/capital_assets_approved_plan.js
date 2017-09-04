var checkCAPExistUrl = '';
function setCAPCheckExistUrl(url) {
    checkCAPExistUrl = url;
}

var registerCAPFormDataIsExist = true;
var updateCAPFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerCAPForm').submit(function(event) {
        var url = checkCAPExistUrl + '/' + $('#capPtitle').val() + '/' + $('#capTitleNumber').val();
        alert(url);
        if ($('#capPtitle').val() != '') {
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
        var url = checkCAPExistUrl + '/' + $('#pbpProjectTitle_u').val() + '/' + $('#pbpProjectCode_u').val() + '/' + $('#pbpId_u').val();
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