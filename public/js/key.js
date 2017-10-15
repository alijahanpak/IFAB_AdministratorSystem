$(document).foundation();
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
    console.log("......................res..........................");
    var tabHeight = $('.tabs').height();
    var toolBarHeight = $('.tool-bar').height();
    var paginationHeight = $('.pagination').height();
    var notifHeight=25;
    if (toolBarHeight === undefined)
    {
        toolBarHeight = -8;
    }

    if (paginationHeight === undefined)
    {
        paginationHeight = -8;
    }

    if (tabHeight===undefined) {
        tabHeight = -8;
        notifHeight=0;
    }

    if ($('.vertical-tab').length > 0)
    {
        tabHeight = 10;
    }

/*    $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 170 - tabHeight ) + 'px');

    var x = $(".dynamicParentId1").parent().height();
    $('.dynamic-height-level2').css('height', (x - 55 - (tabHeight  + toolBarHeight)) + 'px');
    $('.dynamic-height-level2-2').css('height', (x - 166 - (tabHeight  + toolBarHeight)) + 'px');

    var x1 = $(".dynamicParentId2").parent().height();
    $('.dynamic-height-level3').css('height', (x1 - 126 - (tabHeight  + toolBarHeight)) + 'px');
    $('.dynamic-height-notif').css('height', (x - 40 + notifHeight ) + 'px')*/

    $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');

    var x = $(".dynamic-height-level1").height();
    $('.dynamic-height-level2').css('height', (x - 100 - (tabHeight  + toolBarHeight + paginationHeight)) + 'px');
    //$('.dynamic-height-level2-2').css('height', (x - 166 - (tabHeight  + toolBarHeight)) + 'px');

/*    var x1 = $(".dynamicParentId2").parent().height();
    $('.dynamic-height-level3').css('height', (x1 - 126 - (tabHeight  + toolBarHeight)) + 'px');
    $('.dynamic-height-notif').css('height', (x - 40 + notifHeight ) + 'px')*/
}

/*function datePicker(dateId){
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
}*/

function myDatePicker(){
    console.log("...................picker............................");
    window.persianDatepickerDebug = false;

    // Normal Sample
    // --------------------------------------------
    $('.datePickerClass').persianDatepicker({
        altField: '#normalAlt',
        altFormat: 'LLLL',
        initialValue: false,
        observer: true,
        format: 'YYYY/MM/DD',
        autoClose: true,
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
///////////////////////////////////////////////////////////////////