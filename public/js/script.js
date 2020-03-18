(function ($) {
    $(document).on('change', 'input.input-image', function (event) {
        event.preventDefault();
        var reader = new FileReader();

        var img = $('label.upload-label img');

        if (!this.files.length) {
            img.attr('src', 'holder.js/100x100?text=Upload Photo');
            Holder.run({
                images: img[0]
            });
            return;
        }
        reader.onload = function (e) {
            img.attr('src', e.target.result);
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    })
})($)