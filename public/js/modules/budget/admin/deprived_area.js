function getCountyRegions(url , coId , reId , rdId , viId) {
    if ($('#' + coId).val() == '')
    {
        $('#' + reId).html('<option value=""></option>');
        $('#' + reId).attr('disabled', true);
        $('#' + rdId).html('<option value=""></option>');
        $('#' + rdId).attr('disabled', true);
        $('#' + viId).html('<option value=""></option>');
        $('#' + viId).attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#' + coId).val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].reName + '</option>';
                }
                $('#' + reId).html(html);
                $('#' + reId).attr('disabled', false);
                $('#' + rdId).html('<option value=""></option>');
                $('#' + rdId).attr('disabled', true);
                $('#' + viId).html('<option value=""></option>');
                $('#' + viId).attr('disabled', true);
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

                $('#' + reId).html('<option value=""></option>');
                $('#' + reId).attr('disabled', true);
                $('#' + rdId).html('<option value=""></option>');
                $('#' + rdId).attr('disabled', true);
                $('#' + viId).html('<option value=""></option>');
                $('#' + viId).attr('disabled', true);
            }
        });
    }
};

function getRegionRuralDistricts(url , reId , rdId , viId) {
    if ($('#' + reId).val() == '')
    {
        $('#'+ rdId).html('<option value=""></option>');
        $('#' + rdId).attr('disabled', true);
        $('#' + viId).html('<option value=""></option>');
        $('#' + viId).attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#' + reId).val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].rdName + '</option>';
                }
                $('#' + rdId).html(html)
                $('#' + rdId).attr('disabled', false);
                $('#' + viId).html('<option value=""></option>');
                $('#' + viId).attr('disabled', true);
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

                $('#' + rdId).html('<option value=""></option>');
                $('#' + rdId).attr('disabled', true);
                $('#' + viId).html('<option value=""></option>');
                $('#' + viId).attr('disabled', true);
            }
        });
    }
};

function getRuralDistrictVillages(url , rdId , viId) {
    if ($('#' + rdId).val() == '')
    {
        $('#' + viId).html('<option value=""></option>');
        $('#' + viId).attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#' + rdId).val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].viName + '</option>';
                }
                $('#' + viId).html(html);
                $('#' + viId).attr('disabled', false);
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

                $('#' + viId).html('<option value=""></option>');
                $('#' + viId).attr('disabled', true);
            }
        });
    }
};

function DAUpdateDialogOpen(budgetAdminAjaxUri , cId , reId , rdId , viId , description , daId) {
    $("#selectCounty_u").val(cId);
    $('#selectRegion_u').html('<option value=""></option>');
    $('#selectRegion_u').attr('disabled', true);
    $('#selectRuralDistrict_u').html('<option value=""></option>');
    $('#selectRuralDistrict_u').attr('disabled', true);
    $('#selectVillage_u').html('<option value=""></option>');
    $('#selectVillage_u').attr('disabled', true);
    var html1 = '<option value=""></option>';
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: budgetAdminAjaxUri + '/getCountyRegions/' + $('#selectCounty_u').val(),
        success: function (data1) {
            for (var i=0; i < data1.length ; i++)
            {
                html1 += '<option value="' + data1[i].id + '">' + data1[i].reName + '</option>';
            }
            $('#selectRegion_u').html(html1);
            $('#selectRegion_u').attr('disabled', false);
            $('#selectRuralDistrict_u').html('<option value=""></option>');
            $('#selectRuralDistrict_u').attr('disabled', true);
            $('#selectVillage_u').html('<option value=""></option>');
            $('#selectVillage_u').attr('disabled', true);
            if (reId != '')
            {
                $("#selectRegion_u").val(reId);
                var html2 = '<option value=""></option>';
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: budgetAdminAjaxUri + '/getRuralDistrictByRegionId/' + $('#selectRegion_u').val(),
                    success: function (data2) {
                        for (var i=0; i < data2.length ; i++)
                        {
                            html2 += '<option value="' + data2[i].id + '">' + data2[i].rdName + '</option>';
                        }
                        $('#selectRuralDistrict_u').html(html2);
                        $('#selectRuralDistrict_u').attr('disabled', false);
                        $('#selectVillage_u').html('<option value=""></option>');
                        $('#selectVillage_u').attr('disabled', true);
                        if (rdId != '')
                        {
                            $("#selectRuralDistrict_u").val(rdId);
                            var html3 = '<option value=""></option>';
                            $.ajax({
                                type: "GET",
                                dataType: "JSON",
                                url: budgetAdminAjaxUri + '/getVillagesByRuralDistrictId/' + $('#selectRuralDistrict_u').val(),
                                success: function (data3) {
                                    for (var i=0; i < data3.length ; i++)
                                    {
                                        html3 += '<option value="' + data3[i].id + '">' + data3[i].viName + '</option>';
                                    }
                                    $('#selectVillage_u').html(html3);
                                    $('#selectVillage_u').attr('disabled', false);
                                    if (viId != '') {
                                        $("#selectVillage_u").val(viId);
                                    }
                                },
                                error: function (jqXHR3) {
                                    var msg3 = '';
                                    if (jqXHR3.status === 0) {
                                        msg3 = 'Not connect.\n Verify Network.';
                                    } else if (jqXHR3.status == 404) {
                                        msg3 = 'Requested page not found. [404]';
                                    } else if (jqXHR3.status == 500) {
                                        msg3 = 'Internal Server Error [500].';
                                    } else if (exception === 'parsererror') {
                                        msg3 = 'Requested JSON parse failed.';
                                    } else if (exception === 'timeout') {
                                        msg3 = 'Time out error.';
                                    } else if (exception === 'abort') {
                                        msg3 = 'Ajax request aborted.';
                                    } else {
                                        msg3 = 'Uncaught Error.\n' + jqXHR3.responseText;
                                    }

                                    console.log(msg3);

                                    $('#selectVillage_u').html('<option value=""></option>');
                                    $('#selectVillage_u').attr('disabled', true);
                                }
                            });
                        }

                    },
                    error: function (jqXHR2) {
                        var msg2 = '';
                        if (jqXHR2.status === 0) {
                            msg2 = 'Not connect.\n Verify Network.';
                        } else if (jqXHR2.status == 404) {
                            msg2 = 'Requested page not found. [404]';
                        } else if (jqXHR2.status == 500) {
                            msg2 = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg2 = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg2 = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg2 = 'Ajax request aborted.';
                        } else {
                            msg2 = 'Uncaught Error.\n' + jqXHR2.responseText;
                        }

                        console.log(msg2);

                        $('#selectRuralDistrict_u').html('<option value=""></option>');
                        $('#selectRuralDistrict_u').attr('disabled', true);
                        $('#selectVillage_u').html('<option value=""></option>');
                        $('#selectVillage_u').attr('disabled', true);
                    }
                });
            }
        },
        error: function (jqXHR1) {
            var msg1 = '';
            if (jqXHR1.status === 0) {
                msg1 = 'Not connect.\n Verify Network.';
            } else if (jqXHR1.status == 404) {
                msg1 = 'Requested page not found. [404]';
            } else if (jqXHR1.status == 500) {
                msg1 = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg1 = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg1 = 'Time out error.';
            } else if (exception === 'abort') {
                msg1 = 'Ajax request aborted.';
            } else {
                msg1 = 'Uncaught Error.\n' + jqXHR1.responseText;
            }
            console.log(msg1);

            $('#selectRegion_u').html('<option value=""></option>');
            $('#selectRegion_u').attr('disabled', true);
            $('#selectRuralDistrict_u').html('<option value=""></option>');
            $('#selectRuralDistrict_u').attr('disabled', true);
            $('#selectVillage_u').html('<option value=""></option>');
            $('#selectVillage_u').attr('disabled', true);
        }
    });

    $('#daDescription_u').val(description);
    $('#daId_u').val(daId);
    $('#em3').foundation('toggle');
}

$('#modalInsertDeprivedArea').on('closed.zf.reveal' , function () {
    $('#selectCounty').val('');
    $('#selectRegion').html('<option value=""></option>');
    $('#selectRegion').attr('disabled', true);
    $('#selectRuralDistrict').html('<option value=""></option>');
    $('#selectRuralDistrict').attr('disabled', true);
    $('#selectVillage').html('<option value=""></option>');
    $('#selectVillage').attr('disabled', true);
    $('#daDescription').val('');
    $('#existErrorInRegForm').hide();
});

$('#modalUpdateDeprivedArea').on('closed.zf.reveal' , function () {
    $('#selectCounty_u').val('');
    $('#selectRegion_u').html('<option value=""></option>');
    $('#selectRegion_u').attr('disabled', true);
    $('#selectRuralDistrict_u').html('<option value=""></option>');
    $('#selectRuralDistrict_u').attr('disabled', true);
    $('#selectVillage_u').html('<option value=""></option>');
    $('#selectVillage_u').attr('disabled', true);
    $('#daDescription_u').val('');
    $('#existErrorInUpForm').hide();
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
                    }
                    else
                    {
                        registerDAFormDataIsExist = false;
                        $('#registerDAForm').submit();
                    }
                    setTimeout(function(){ $('#registerSubmitActivityCircle').hide(); } , 2000);

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
                    }
                    else
                    {
                        updateDAFormDataIsExist = false;
                        $('#updateDAForm').submit();
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
        if (updateDAFormDataIsExist == true)
            event.preventDefault();
    });

    $('#selectCounty').val('');
    $('#selectRegion').html('<option value=""></option>');
    $('#selectRegion').attr('disabled', true);
    $('#selectRuralDistrict').html('<option value=""></option>');
    $('#selectRuralDistrict').attr('disabled', true);
    $('#selectVillage').html('<option value=""></option>');
    $('#selectVillage').attr('disabled', true);
    $('#daDescription').val('');

    $('#selectCounty_u').val('');
    $('#selectRegion_u').html('<option value=""></option>');
    $('#selectRegion_u').attr('disabled', true);
    $('#selectRuralDistrict_u').html('<option value=""></option>');
    $('#selectRuralDistrict_u').attr('disabled', true);
    $('#selectVillage_u').html('<option value=""></option>');
    $('#selectVillage_u').attr('disabled', true);
    $('#daDescription_u').val('');

    $('#existErrorInRegForm').hide();
    $('#existErrorInUpForm').hide();
});
