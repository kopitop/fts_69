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

/**
 * Option of question answer
 */

/* add option choice */
function addOption()
{
    $('.btn-add-option').attr('disabled', false);
    var id = rand();
    var dataQuestions = $('.hide').data("option");
    dataQuestions = dataQuestions.replace(/contentName/g, "content[idOption]");
    dataQuestions = dataQuestions.replace(/correctName/g, "correct[idOption]");
    dataQuestions = dataQuestions.replace(/idOption/g, id);
    $('.answer-content').append(dataQuestions);
}

/* add option text */
function addOptionText()
{
    $('.btn-add-option').attr('disabled', true);
    var optionTextQuestions = $('.hide').data("optionText");
    optionTextQuestions = optionTextQuestions.replace(/contentName/g, "content[]");
    $('.answer-content').html(optionTextQuestions);
}

/* create option in create question-answer page*/
function createOption(routeOption, questionId, token, message, action)
{
    $.ajax({
        url: routeOption,
        type: 'post',
        data: {
            'id': questionId,
            '_token': token,
        },
        success: function (data) {
            $('.answer-content').html("");
            if (data.success) {
                var type = data.data.type;
                if (action == "create") {
                    if (type == message.text) {
                        addOptionText();
                    } else {
                        addOption();
                    }
                }
                showTypeText(type, message);
            }
        }
    });
}

/* display type of question */
function showTypeText(type, message)
{
    var html = message.text_string;
    switch (type) {
        case message.single_choice:
            html = message.single_choice_text;
            break;
        case message.multiple_choice:
            html = message.multiple_choice_text;
            break;
    }

    $('.type-question').val(html);
}

/* remove option*/
function removeOption(id)
{
    $('#' + id).remove();
}

$(document).ready(function () {
    var routeOption = $('.hide').data("routeOption");
    if (!(typeof routeOption === "undefined")) {
        var token = $('.hide').data("token");
        var message = $('.hide').data("message");
        var OptionId = $('select[name=question_id]').val();
        var action = $('.hide').data("action");
        createOption(routeOption, OptionId, token, message);
        $('.question-name').on('change', function() {
            var questionId = this.value;
            createOption(routeOption, questionId, token, message, action);
        });
    }
});

/*random name option*/
var rand = function() {
    return Math.random().toString(36).substr(2); // remove `0.`
};
