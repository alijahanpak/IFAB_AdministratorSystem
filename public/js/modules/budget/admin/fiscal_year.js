function checkFySectionPermissionState(url , section , fyId) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/' + section + '/' + fyId,
        success: function (data) {
            if (section == 'budget')
            {
                $('#budgetPermissionAll').prop('checked', data.state);
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
            console.log(msg);
        }
    });
}

function changeFySectionPermissionState(url , section , switchId , fyId , permissionCount) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/changeSectionPermissionState/' + section + '/' + fyId + '/' + ($('#' + switchId).is(':checked') == false ? 0 : 1),
        success: function (data) {
            if (section == 'budget')
            {
                for (var i=0 ; i < permissionCount ; i++)
                {
                    $('#budgetPermission' + i).prop('checked', $('#' + switchId).is(':checked'));
                }
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
            console.log(msg);
        }
    });
}

function changeBudgetItemPermissionState(url , pbId , switchId , fyId) {
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: url + '/changeBudgetItemPermissionState/' + pbId + '/' + ($('#' + switchId).is(':checked') == false ? 0 : 1),
        success: function (data) {
            if (data.state == true)
            {
                checkFySectionPermissionState(url + '/checkSectionPermissionState' , 'budget' , fyId);
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
            console.log(msg);
        }

    });

}