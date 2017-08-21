function CDRUpdateDialogOpen(budgetAdminAjaxUri , subject , description , cdrId) {
    $('#cdrSubject_u').val(subject);
    $('#cdrDescription_u').val(description);
    $('#cdrId_u').val(cdrId);
    $('#CDR_ModalUpdate').foundation('toggle');
}

var checkCDRExistUrl = '';
function setCDRCheckExistUrl(url) {
    checkCDRExistUrl = url;
}

var registerCDRFormDataIsExist = true;
var updateCDRFormDataIsExist = true;
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

                    console.log(msg);
                }
            });
        }
        if (updateCDRFormDataIsExist == true)
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
});
