$('.custom-file-input').on('change', function () {
    let filename = $(this).val().split('\\').pop();
    $(this)
        .next('.custom-file-label')
        .addClass('selected')
        .html(filename);
});

$('[data-toggle="tooltip"]').tooltip()

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function preview(target, image) {
    $(target)
        .attr('src', window.URL.createObjectURL(image))
        .show();
}

function resetForm(selector) {
    $(selector)[0].reset();

    if ($(selector).find('.summernote').length != 0) {
        $(selector).find('.summernote').summernote('code', '');
    }

    if ($(selector).find('.img-thumbnail').length != 0) {
        $(selector).find('.img-thumbnail').attr('src', "");
    }

    $('.select2').trigger('change');
    $('.form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .select2, .note-editor').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}

function loopForm(originalForm) {
    for (field in originalForm) {
        if ($(`[name=${field}]`).attr('type') != 'file') {
            if ($(`[name=${field}]`).hasClass('summernote')) {
                $(`[name=${field}]`).summernote('code', originalForm[field]);
            } else if ($(`[name=${field}]`).attr('type') == 'radio') {
                $(`[name=${field}]`).filter(`[value="${originalForm[field]}"]`).prop('checked', true);
            } else {
                $(`[name=${field}]`).val(originalForm[field]);
            }
            
            $('select').trigger('change');
        } else {
            $(`.preview-${field}`)
                .attr('src', originalForm[field])
                .show();
        }
    }
}

function loopErrors(errors) {
    $('.invalid-feedback').remove();

    if (errors == undefined) {
        return;
    }

    for (error in errors) {
        $(`[name=${error}]`).addClass('is-invalid');

        if ($(`[name=${error}]`).hasClass('select2')) {
            $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                .insertAfter($(`[name=${error}]`).next());
        } else if ($(`[name=${error}]`).hasClass('summernote')) {
            $('.note-editor').addClass('is-invalid');
            $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                .insertAfter($(`[name=${error}]`).next());
        } else if ($(`[name=${error}]`).hasClass('custom-control-input')) {
            $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                .insertAfter($(`[name=${error}]`).next());
        } else {
            if ($(`[name=${error}]`).length == 0) {
                $(`[name="${error}[]"]`).addClass('is-invalid');
                $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                    .insertAfter($(`[name="${error}[]"]`).next());
            } else {
                if ($(`[name=${error}]`).next().hasClass('input-group-append') || $(`[name=${error}]`).next().hasClass('input-group-prepend')) {
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`).next());
                    $('.input-group-append .input-group-text').css('border-radius', '0 .25rem .25rem 0');
                    $('.input-group-prepend').next().css('border-radius', '0 .25rem .25rem 0');
                } else {
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`));
                }
            }

        }
    }
}

function showAlert(message, type) {
    let title = '';
    switch (type) {
        case 'success':
            title = 'Success';
            break;
        case 'danger':
            title = 'Failed';
            break;
        default:
            break;
    }

    $(document).Toasts('create', {
        class: `bg-${type}`,
        title: title,
        body: message
    });

    setTimeout(() => {
        $('.toasts-top-right').remove();
    }, 3000);
}

function format_uang(input) {
    a = input.value;
    if (a == undefined) {
        a = input.toString();
    }
    b = a.replace(/[^\d]/g, "");
    c = "";
    length = b.length;

    j = 0;
    for (i = length; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
            c = b.substr(i - 1, 1) + "." + c;
        } else {
            c = b.substr(i - 1, 1) + c;
        }
    }
    if (input.value == undefined) {
        return c;
    }

    input.value = c;
}