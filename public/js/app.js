$(document).foundation()

function openTableRowAcc(trId , tableContainerId) {
    if ($('#' + trId).css('display') == 'none') {
        $("#" + tableContainerId ).parent().find('div.accordionRow').addClass("display-off");
        $("#" + trId).removeClass('display-off');
    } else {
        $('#' + trId).addClass('display-off');
    }
}

$("div.selectAbleRow").mouseover(function(){
    $(this).addClass('selected');
    $(this).find('a.dropdown').removeClass("display-off");
});

$("div.selectAbleRow").mouseleave(function(){
    $(this).removeClass('selected');
    $(this).find('a.dropdown').addClass("display-off");
});