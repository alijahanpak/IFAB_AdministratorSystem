$(document).foundation()
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function openTableRowAcc(trId , tableContainerId) {
    if ($('#' + trId).css('display') == 'none') {
        $("#" + tableContainerId ).parent().find('div.accordionRow').addClass("display-off");
        $("#" + trId).removeClass('display-off').hide().fadeToggle("1000");
    } else {
        $('#' + trId).addClass('display-off').show().fadeToggle("1000");
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
    var tabHeight = $('.tabs').height();
    var notifHeight=25;
    if (tabHeight===undefined) {
        tabHeight = 0;
        notifHeight=0;
    }
    if ($('.vertical-tab').length > 0)
    {
        tabHeight = 10;
    }
    var subTabHeight=tabHeight-13;
    $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 205 - tabHeight ) + 'px');
    var x = $("#dynamicParentId1").parent().height();
    $('.dynamic-height-level2').css('height', (x - 110 -(tabHeight-subTabHeight )  ) + 'px');
    $('.dynamic-height-level2-2').css('height', (x - 110 -tabHeight-subTabHeight ) + 'px');
    var x1 = $("#dynamicParentId2").parent().height();
    $('.dynamic-height-level3').css('height', (x1 - 70 -tabHeight-subTabHeight  ) + 'px');
    $('.dynamic-height-notif').css('height', (x - 40+notifHeight ) + 'px')
}

function datePicker(dateId){
    window.persianDatepickerDebug = false;

    // Normal Sample
    // --------------------------------------------
    $('#' + dateId).persianDatepicker({
        altField: '#normalAlt',
        altFormat: 'LLLL',
        initialValue: false,
        observer: true,
        format: 'YYYY/MM/DD',
        autoClose: true
    });
}
///////////////// get table contain scroll-bar width and sed to table header///////////
$(document).ready(function () {
    var scrollDiv = document.createElement("div");
    scrollDiv.className = "table-contain";
    document.body.appendChild(scrollDiv);
// Get the scrollbar width
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
    console.warn(scrollbarWidth); // Mac:  15
// Delete the DIV
    document.body.removeChild(scrollDiv);
    $('.table-header').css('margin-left',(scrollbarWidth - 2)+'px');
});

