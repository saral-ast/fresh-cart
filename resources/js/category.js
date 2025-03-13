$(document).ready(function () {
    $('#imageInput').change(function (event) {
        let file = this.files[0];
        let fileLabel = $('#fileLabel');
        let imagePreviewContainer = $('#imagePreviewContainer');
        let imagePreview = $('#imagePreview');

        if (file) {
            fileLabel.text(file.name); // Update file name
            let reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
                imagePreviewContainer.removeClass('hidden'); // Show preview
            };

            reader.readAsDataURL(file);
        } else {
            fileLabel.text("Choose an image...");
            imagePreviewContainer.addClass('hidden'); // Hide preview if no file is selected
        }
    });


    
});

