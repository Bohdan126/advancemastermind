(function($){
	//JS color picker
	$('.colorpickerField').ColorPicker({
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
}) (jQuery)

jQuery(document).ajaxComplete(function() {
		/* Act on the event */
	jQuery('.form-type-managed-file').each(function(index, el) {
		if(jQuery(this).find('.file--image').length){
			var img_path = jQuery(this).find('.file--image a').attr('href');
			jQuery(this).find('.file--image a').prepend('<img src="'+img_path+'" width="100px" height="auto" >');
			jQuery(this).find('.file--image').css('background', 'none');
		} else {
			jQuery(this).remove('img');
		}
	});
});

jQuery(document).ready(function($) {
	jQuery('.file--image').each(function(index, el) {
		var img_path = jQuery(this).find('a').attr('href');
		jQuery(this).prepend('<img src="'+img_path+'" width="100px" height="auto" >');
		jQuery(this).css('background', 'none');
	});
});