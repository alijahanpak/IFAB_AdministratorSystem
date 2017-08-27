function openCountyPlanAmount(trId) {
    if ($('#' + trId).css('display') == 'none') {
        $('#' + trId).removeClass('display-off').hide().fadeIn();
    } else {
        $('#' + trId).addClass('display-off');
    }
}