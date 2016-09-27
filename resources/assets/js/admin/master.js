$.widget.bridge('uibutton', $.ui.button);
function confirmDelete(message) {
    return confirm(message);
}
$(".message-infor").show().delay(3000).fadeOut();