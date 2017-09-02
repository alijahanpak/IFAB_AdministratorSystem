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

$(function(){
    $.w = $(window);
    $.w.on('resize', res);
    res();
});
function res() {
    $('.dynamic-height-level1').css('height',($.w.outerHeight()-260)+'px');
    var x = $("#dynamicParentId1").parent().height();
    $('.dynamic-height-level2').css('height',(x-110  )+'px');
    $('.dynamic-height-level2-2').css('height',(x-110  )+'px');
    var x1 = $("#dynamicParentId2").parent().height();
    $('.dynamic-height-level3').css('height',(x1-70  )+'px');

    $('.dynamic-height-notif').css('height',(x-45  )+'px');
}


