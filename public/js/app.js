(function () {
    //hiding img and showing submit button
    hideOrShow(false);
    $('form').on('submit', function (e) {
        e.preventDefault();
        //Selecting all fields which is needed to disable
        var formFields = this.querySelectorAll('input, textarea');
        //Removing old errors
        clearErrors(formFields);
        //hiding img and showing submit button
        hideOrShow(true);

        $.post('PostController/ajaxIndex', $(this).serialize(), function (data) {
            //Disabling fields
            disableFields(formFields, true);
            if (data.status) {
                //Resetting form fields
                resetForm($('#form'));
                $.each(data.newPost, function (key, val) {
                    //Listing new message on the top of list
                    $('#posts').prepend('<li id="`${val.ID}`"><span>' + val.time + '</span> <a href="`${val.Useremail}`">' + val.UserfullName + '</a>, ' + val.UserbirthDate + 'm.<br/>' + val.Usermessage + '</li>');
                });
                //selecting the oldest message id for removal
                var id = data.oldest[0][0];
                //if we have at least 4 posts, we start removal
                if (data.all.length > 4) {
                    var selected = document.getElementById(id);
                    if (typeof(selected) != 'undefined' && selected != null) {
                        selected.remove();

                    } else {
                        //Searching for the next li child to remove by id
                        while (document.getElementById(id) === null)
                            id++;
                        document.getElementById(id).remove();
                    }

                }

            } else {
                for (var key in data) {
                    //removing empty values from array
                    if (data[key] === "") {
                        delete data[key];
                    } else if (data.hasOwnProperty(key)) {
                        //assigning errors for each field
                        handleErrors($('#' + key), data[key]);
                    }
                }
            }
            //hiding img and showing submit button after 1s, enabling form fields.
            setTimeout(function () {
                hideOrShow(false);
                disableFields(formFields, false);
            }, 1000);
        });
    });

    //Show or hide the button or img
    function hideOrShow(hidden) {
        hidden = !hidden;
        if (hidden) {
            document.getElementById('img').style.visibility = 'hidden';
            document.getElementById('submit').style.visibility = 'visible';

        } else {
            document.getElementById('submit').style.visibility = 'hidden';
            document.getElementById('img').style.visibility = 'visible';
        }
    }

    function disableFields(fields, state) {

        for (var i = 0; i < fields.length; i++) {
            fields[i].disabled = state;
        }
    }

    function handleErrors(element, message) {
        var p = element.parent('p');
        p.addClass('err');
        var error = $('<p class="errorText"></p>').text(message);
        error.appendTo(p);
        element.keyup(function () {
            error.fadeOut(1000, function () {
                element.removeClass('err');
                p.removeClass('err');
            })
        })
    }

    function clearErrors(elements) {
        for (var i = 0; i < elements.length; i++) {
            //selecting each parent with error
            var p = $(elements[i]).parent('p'),
                child = p.children('p');
            //removing error from field
            p.removeClass('err');
            //removing error text
            child.remove();
        }
    }

    function resetForm(form) {
        form.find('input:text, textarea').val('');

    }
})();