(function($) {
    $('#colorpickerField').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val(hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function() {
            $(this).ColorPickerSetColor(this.value);
        }
    })
    .bind('keyup', function() {
        $(this).ColorPickerSetColor(this.value);
    });
})(jQuery)
