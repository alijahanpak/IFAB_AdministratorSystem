function getCountyRegions(url) {
    if ($('#selectCounty').val() == '')
    {
        $('#selectRegion').html('<option value=""></option>');
        $('#selectRegion').attr('disabled', true);
        $('#selectRuralDistrict').html('<option value=""></option>')
        $('#selectRuralDistrict').attr('disabled', true);
        $('#selectVillage').html('<option value=""></option>')
        $('#selectVillage').attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#selectCounty').val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].reName + '</option>';
                }
                $('#selectRegion').html(html);
                $('#selectRegion').attr('disabled', false);
                $('#selectRuralDistrict').html('<option value=""></option>')
                $('#selectRuralDistrict').attr('disabled', true);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
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

                $('#selectRegion').html('<option value=""></option>');
                $('#selectRegion').attr('disabled', true);
                $('#selectRuralDistrict').html('<option value=""></option>')
                $('#selectRuralDistrict').attr('disabled', true);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
            }
        });
    }
};

function getRegionRuralDistricts(url) {
    if ($('#selectRegion').val() == '')
    {
        $('#selectRuralDistrict').html('<option value=""></option>')
        $('#selectRuralDistrict').attr('disabled', true);
        $('#selectVillage').html('<option value=""></option>')
        $('#selectVillage').attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#selectRegion').val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].rdName + '</option>';
                }
                $('#selectRuralDistrict').html(html)
                $('#selectRuralDistrict').attr('disabled', false);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
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

                $('#selectRuralDistrict').html('<option value=""></option>')
                $('#selectRuralDistrict').attr('disabled', true);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
            }
        });
    }
};

function getRuralDistrictVillages(url) {
    if ($('#selectRuralDistrict').val() == '')
    {
        $('#selectVillage').html('<option value=""></option>')
        $('#selectVillage').attr('disabled', true);
    }
    else {
        var html = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url + "/" + $('#selectRuralDistrict').val(),
            success: function (data) {
                for (var i=0; i < data.length ; i++)
                {
                    html += '<option value="' + data[i].id + '">' + data[i].viName + '</option>';
                }
                $('#selectVillage').html(html)
                $('#selectVillage').attr('disabled', false);
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

                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
            }
        });
    }
};

function DAUpdateDialogOpen(budgetAdminAjaxUri , cId , reId , rdId , viId , description) {
    $("#selectCounty").val(cId);
    $('#selectRegion').html('<option value=""></option>');
    $('#selectRegion').attr('disabled', true);
    $('#selectRuralDistrict').html('<option value=""></option>')
    $('#selectRuralDistrict').attr('disabled', true);
    $('#selectVillage').html('<option value=""></option>')
    $('#selectVillage').attr('disabled', true);
    if (reId != '')
    {
        var html1 = '<option value=""></option>';
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: budgetAdminAjaxUri + '/getCountyRegions/' + $('#selectCounty').val(),
            success: function (data1) {
                for (var i=0; i < data1.length ; i++)
                {
                    html1 += '<option value="' + data1[i].id + '">' + data1[i].reName + '</option>';
                }
                $('#selectRegion').html(html1);
                $('#selectRegion').attr('disabled', false);
                $('#selectRuralDistrict').html('<option value=""></option>')
                $('#selectRuralDistrict').attr('disabled', true);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
                $("#selectRegion").val(reId);
                if (rdId != '')
                {
                    var html2 = '<option value=""></option>';
                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        url: budgetAdminAjaxUri + '/getRuralDistrictByRegionId/' + $('#selectRegion').val(),
                        success: function (data2) {
                            for (var i=0; i < data2.length ; i++)
                            {
                                html2 += '<option value="' + data2[i].id + '">' + data2[i].rdName + '</option>';
                            }
                            $('#selectRuralDistrict').html(html2)
                            $('#selectRuralDistrict').attr('disabled', false);
                            $('#selectVillage').html('<option value=""></option>')
                            $('#selectVillage').attr('disabled', true);
                            $("#selectRuralDistrict").val(rdId);
                            if (viId != '')
                            {
                                var html3 = '<option value=""></option>';
                                $.ajax({
                                    type: "GET",
                                    dataType: "JSON",
                                    url: budgetAdminAjaxUri + '/getVillagesByRuralDistrictId/' + $('#selectRuralDistrict').val(),
                                    success: function (data3) {
                                        for (var i=0; i < data3.length ; i++)
                                        {
                                            html3 += '<option value="' + data3[i].id + '">' + data3[i].viName + '</option>';
                                        }
                                        $('#selectVillage').html(html3)
                                        $('#selectVillage').attr('disabled', false);
                                        $("#selectVillage").val(viId);
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

                                        $('#selectVillage').html('<option value=""></option>')
                                        $('#selectVillage').attr('disabled', true);
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

                            $('#selectRuralDistrict').html('<option value=""></option>')
                            $('#selectRuralDistrict').attr('disabled', true);
                            $('#selectVillage').html('<option value=""></option>')
                            $('#selectVillage').attr('disabled', true);
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

                $('#selectRegion').html('<option value=""></option>');
                $('#selectRegion').attr('disabled', true);
                $('#selectRuralDistrict').html('<option value=""></option>')
                $('#selectRuralDistrict').attr('disabled', true);
                $('#selectVillage').html('<option value=""></option>')
                $('#selectVillage').attr('disabled', true);
            }
        });
    }

    $('#daDescription').val(description);
    $('#modalInsertDeprivedArea').foundation('toggle');

}

$('#modalInsertDeprivedArea').on('closed.zf.reveal', function() {
    $("#selectCounty").val('');
    $('#selectRegion').html('<option value=""></option>');
    $('#selectRegion').attr('disabled', true);
    $('#selectRuralDistrict').html('<option value=""></option>')
    $('#selectRuralDistrict').attr('disabled', true);
    $('#selectVillage').html('<option value=""></option>')
    $('#selectVillage').attr('disabled', true);
    $('#daDescription').val('');
});