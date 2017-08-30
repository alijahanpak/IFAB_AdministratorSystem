$(document).foundation()

function openTableRowAcc(trId , tableContainerId) {
    if ($('#' + trId).css('display') == 'none') {
        $("#" + tableContainerId ).parent().find('div.accordionRow').addClass("display-off");
        $("#" + trId).removeClass('display-off');
    } else {
        $('#' + trId).addClass('display-off');
    }
}
