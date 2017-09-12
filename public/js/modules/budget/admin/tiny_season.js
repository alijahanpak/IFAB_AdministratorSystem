function TSUpdateDialogOpen(sId , subject , description , tsId) {
    $('#sId_u').val(sId);
    $('#tsSubject_u').val(subject);
    $('#tsDescription_u').val(description);
    $('#tsId_u').val(tsId);
    setTimeout(function () {
        $('#SS_ModalUpdate').foundation('toggle');
    }, 100);
}

var checkTSExistUrl = '';
function setTSCheckExistUrl(url) {
    checkTSExistUrl = url;
}

var registerTSFormDataIsExist = true;
var updateTSFormDataIsExist = true;
$(document).ready(function () {
    $('#registerSubmitActivityCircle').hide();
    $('#registerTSForm').submit(function(event) {
        var url = checkTSExistUrl + '/' + $('#sId').val() + '/' + $('#tsSubject').val();
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
                    registerTSFormDataIsExist = false;
                    $('#registerTSForm').submit();
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
        if (registerTSFormDataIsExist == true)
            event.preventDefault();
    });

    $('#updateSubmitActivityCircle').hide();
    $('#updateTSForm').submit(function(event) {
        var url = checkTSExistUrl + '/' + $('#sId_u').val() + '/' + $('#tsSubject_u').val() + '/' + $('#tsId_u').val();
        $('#updateSubmitActivityCircle').show();
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url,
            success: function (data) {
                if (data.exist == true) {
                    $('#existErrorInUpForm').show();
                    setTimeout(function () {
                        $('#updateSubmitActivityCircle').hide();
                    }, 2000);
                }
                else {
                    updateTSFormDataIsExist = false;
                    $('#updateTSForm').submit();
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
        if (updateTSFormDataIsExist == true)
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
});

var demo = new Vue({
    el: '#demo',
    data: {
        gridData: [
            { name: 'سه درصد نفت و گاز', power:'test',description:''},
            { name: 'سه درصد نفت و گاز', power:'test',description:''},
            { name: 'سه درصد نفت و گاز', power:'test',description:''},
            { name: 'سه درصد نفت و گاز', power:'test',description:''}
        ]
    }
});

//add
var AddProduct = Vue.extend({
    template: '#add-product',
    data: function () {
        return {product: {season: '', subSeason: '', description: ''}
        }
    },
    methods: {
        createProduct: function() {
           alert('shondoll');
        }
    }
});
