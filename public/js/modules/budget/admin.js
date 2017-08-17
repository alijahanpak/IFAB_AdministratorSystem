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