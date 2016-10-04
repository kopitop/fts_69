$.widget.bridge('uibutton', $.ui.button);
$(function () {
    $('#user-lists, #subject-lists, #suggestion-list, .question-lists, .exam-lists, .question-answer-lists').DataTable({
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
function addOption(message)
{
    var dataQuestions = $('.hide').data("option");
    var id = rand();
    var oldInput = " ";
    $('.btn-add-option').attr('disabled', false);
    if (message != null &&  message.oldInput != null) {
        if(typeof message.oldInput.correct === 'undefined') {
            dataQuestions = dataQuestions.replace(/contentName/g, "content[idOption]");
            dataQuestions = dataQuestions.replace(/correctName/g, "correct[idOption]");
            dataQuestions = dataQuestions.replace(/idOption/g, id);
            dataQuestions = dataQuestions.replace(/contentValue/g, "");
            $('.answer-content').append(dataQuestions);
            $('#false-' + id).prop('checked',true);
        }
        else {
            $.each(message.oldInput.correct, function (index, value) {
                var oldDataQuestions = $('.hide').data("option");
                oldDataQuestions = oldDataQuestions.replace(/contentName/g, "content[idOption]");
                oldDataQuestions = oldDataQuestions.replace(/correctName/g, "correct[idOption]");
                oldDataQuestions = oldDataQuestions.replace(/idOption/g, index);
                oldDataQuestions = oldDataQuestions.replace(/contentValue/g, message.oldInput.content[index]);
                oldInput += oldDataQuestions;
            });
            $('.answer-content').append(oldInput);
            $.each(message.oldInput.correct, function (indexChoice, valueChoice) {
                if (valueChoice == 0) {
                    $('#false-' + indexChoice).prop('checked', true);
                } else {
                    $('#true-' + indexChoice).prop('checked', true);
                }
            });
        }
    } else {
        dataQuestions = dataQuestions.replace(/contentName/g, "content[idOption]");
        dataQuestions = dataQuestions.replace(/correctName/g, "correct[idOption]");
        dataQuestions = dataQuestions.replace(/idOption/g, id);
        dataQuestions = dataQuestions.replace(/contentValue/g, "");
        $('.answer-content').append(dataQuestions);
        $('#false-' + id).prop('checked',true);
    }
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
                if (action == "create") {
                    addOption(message);
                }

                showTypeText(data.data.type, message);
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
        createOption(routeOption, OptionId, token, message, action);

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
