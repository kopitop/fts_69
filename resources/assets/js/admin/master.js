$.widget.bridge('uibutton', $.ui.button);
function confirmDelete(message) {
    return confirm(message);
}
$(".message-infor").show().delay(3000).fadeOut();
$(function () {
    $('#user-lists').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false
    });
});
