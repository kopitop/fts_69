function confirmDelete(message) {
    return confirm(message);
}
$(".message-infor").show().delay(2000).fadeOut();

/** countdown timer */
function startTimer(duration, display, diplayInput) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer/ 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;
        diplayInput.value = minutes + ":" + seconds;
        if (--timer < 0) {
            $('#form-exam').submit();
        }
    }, 1000);

}

window.onload = function () {
    var id = $('.time').attr('id');
    if (!(typeof id === "undefined")) {
        var take     = String(id).split(':');
        var fiveMinutes  = parseFloat(take[0])*60 + parseFloat(take[1]);
        display = document.querySelector('.time');
        diplayInput = document.querySelector('.time_input');
        startTimer(fiveMinutes, display, diplayInput);
    }
};
