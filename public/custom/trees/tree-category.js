

function updateShareStatus(value) {
    $("#share_status").val(value);
}

function validateForm() {
    var variety_name = $("#variety_name").val();
    var variety_description = $("#variety_description").val()
    var media = $("#uploadFile").val();

    if (!(variety_name)) {
        notify('Please inserthe variety name', 'error');
        return false;
    } else if (!variety_description) {
        notify('Please insert the description', 'error');
        return false;
    } else if (!media) {
        notify('Please select the image', 'error');
        return false;
    }

    return true;
}

function showBrowsedImage(input) {
    $('#video_display_element').hide()
    //show browsed image or video
    console.log("input", input)
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file['type'];
        console.log(fileType)
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        const validVideoTypes = ['video/mp4', 'image/webm', 'image/ogg'];
        if (validImageTypes.includes(fileType)) {
            //if file type is image, display image in img tag
            var reader = new FileReader();
            //image preview show
            console.log("show Image");
            $('#upload_image').show();
            reader.onload = function (e) {
                console.log(e.target.result);
                document.getElementById("upload_image").setAttribute('src', e.target.result);

                $('#upload_image')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            if (validVideoTypes.includes(fileType)) {
                //if file type is video, display video in video tag
                console.log(fileType);
                $('#video_display_element').show();
                $('#upload_image').hide();
                $('.image-preview').hide()
                var $source = $('.video_display');
                console.log(input.files[0]);
                $source[0].src = URL.createObjectURL(input.files[0]);
                $source.parent()[0].load();
            } else {
                notify('Invalide File Type', 'error');
            }
        }
    }
}
