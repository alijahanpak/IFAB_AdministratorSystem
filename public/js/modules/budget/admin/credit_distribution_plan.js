function openRow() {
    if ($('#myRow').css('display') == 'none') {
        $('#myRow').removeClass('display-off').hide().fadeIn();
    } else {
        $('#myRow').addClass('display-off');
    }
}