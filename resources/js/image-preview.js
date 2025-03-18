$(document).ready(function () {
    $("#imageInput").on("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result);
                $("#imagePreviewContainer").removeClass("hidden");
                $("#fileLabel").text(file.name);
            };
            reader.readAsDataURL(file);
        }
    });
});