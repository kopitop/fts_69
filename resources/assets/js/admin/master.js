$.widget.bridge('uibutton', $.ui.button);
$(function () {
    $('#user-lists, #subject-lists, .question-lists, .exam-lists, .question-answer-lists').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false
    });
});
function confirmDelete(message) {
    return confirm(message);
}
$(".message-infor").show().delay(2000).fadeOut();
