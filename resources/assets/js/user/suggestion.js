var data = $('.hide').data("option");
console.log(data);
$(document).ready(function () {
    var action = $('.hide').data("action");
    if (action == "create") {
        if (data.oldInput != null) {
            if (data.oldInput.type != "") {
                $('.option-content').html(
                    '<button type="button" class="btn btn-primary" onclick="addOption(' + data.oldInput.type + ')">' +
                    '<span class="glyphicon glyphicon-plus"></span>' +
                    '</button>'
                );
            }

        }

        /*type even change*/
        $(".type").on('change', function () {
            $('.option-content').html(
                '<button type="button" class="btn btn-primary" onclick="addOption(' + this.value + ')">' +
                '<span class="glyphicon glyphicon-plus"></span>' +
                '</button>'
            );
            showOption(this.value)
        });
    }

});

function addOption(key) {
    showOption(key);
}

function removeOption(id) {
    $("#" + id).remove();
}

function showOption(key) {
    var id = rand();

    /* get data key*/
    var keySingle = data.key.single;
    var keyMultiple = data.key.multiple;
    var keyText = data.key.text;

    /* get data view*/
    var viewSingle = data.view.single;
    var viewMultiple = data.view.multiple;
    var viewText = data.view.text;

    if (key == keySingle) {
        viewSingle = viewSingle.replace(/idOption/g, id);
        $('.option-content').append(viewSingle);
    } else if (key == keyMultiple) {
        viewMultiple = viewMultiple.replace(/idOption/g, id);
        $('.option-content').append(viewMultiple);
    } else {
        viewText = viewText.replace(/idOption/g, id);
        $('.option-content').append(viewText);
    }
}

var rand = function() {
    return Math.random().toString(36).substr(2); // remove `0.`
};
