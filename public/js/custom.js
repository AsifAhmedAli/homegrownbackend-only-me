function generateCode(length) {
    var result           = '';
    var characters       = 'ABCDEFGHJLMNPQRSTUXYZabcdefghjmnprstuxyz23456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function resolveAttributeRepeater(selector) {
    if ($('.individual-wrapper').length >= 3)
        selector.hide();
    else
        selector.show();

}

$('.goTo').on('click', function() {
    if(confirm('Are you Sure?')) {
        window.location.href = $(this).data('url');
    }
});

$('.show-hide-info').on('click', function() {
    let type = $(this).siblings('input').attr('type');
    if(type === 'password') {
        type = 'text';
    } else {
        type = 'password';
    }
    $(this).toggleClass('vhide');
    $(this).siblings('input').prop('type', type);
});

$('.tagify').tagify({
    duplicates :false,
    trim: true
});
function validateFile() {
    let files = document.getElementById("files").files;
    var file, t;
    for (var i = 0; i < files.length; i++) {

        file = files[i];
        console.log('filesize', file.size)
        if(file.size > 10000000)
        {
            alert("The file size is too large");
            document.getElementById("files").value = '';
            return;
        }
        t = file.type.split('/').pop().toLowerCase();
        const allowedExt = [
            "pdf",
            "vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "vnd.openxmlformats-officedocument.wordprocessingml.document",
            "plain",
            "vnd.ms-excel",
            "mp4",
            'png',
            'jpeg',
            'jpg'
        ]
        if (!allowedExt.includes(t)) {
            alert('Please select a valid file. pdf,xlsx,mp4,txt,png,jpeg,jpg files are allowed');
            document.getElementById("files").value = '';
            return false;
        }
    }
    return true;
}

$(document).ready(function () {
    /*input mask for phone numbers*/
    $("input[name*='phone_number']").usPhoneFormat();

    let elem = $('input[name="old_logo"]').parent().find('img');
    let src = elem.prop('src');
    if (typeof src === 'undefined' || src == '') {
        $(elem).parent().hide();
    }
});


