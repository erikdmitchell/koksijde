jQuery(document).ready(function($) {

	var $homeSliderOptions=$('#home-slider-options');
	var $homeSliderMoreBtn=$('.more-btn-extra');
	var $homeSliderCaptionField=$('.caption-field');

	// home slider checkbox on load //
	if ($('#activate_home_slider').prop('checked')) {
		$homeSliderOptions.show();
	} else {
		$homeSliderOptions.hide();
	}

	// home slider checkbox change(s) //
	$('#activate_home_slider').change(function() {
    if (this.checked) {
			$homeSliderOptions.show();
    } else {
	  	$homeSliderOptions.hide();
	  }
	});

	// home slider captions on load //
	if ($('#home_slider_captions').val()==1) {
		$homeSliderCaptionField.show();
	} else {
		$homeSliderCaptionField.hide();
	}

	// home slider captions change(s) //
	$('#home_slider_captions').change(function() {
    if ($(this).val()==1) {
			$homeSliderCaptionField.show();
    } else {
	  	$homeSliderCaptionField.hide();
	  }
	});

	// home slider more button on load //
	if ($('#home_slider_more_btn').val()==1) {
		$homeSliderMoreBtn.show();
	} else {
		$homeSliderMoreBtn.hide();
	}

	// home slider more button change(s) //
	$('#home_slider_more_btn').change(function() {
    if ($(this).val()==1) {
			$homeSliderMoreBtn.show();
    } else {
	  	$homeSliderMoreBtn.hide();
	  }
	});

	// logo uploader //
	$('#add-logo').click(function(event) {
		var options={
			uploader_title : 'Logo Media Box',
			uploader_button_text : 'Update Logo'
		};

		var image={
			width : 163,
			height : 100
		};

		$(this).mediaUploader(event,options,function(attachment) {
			var img='<img src="'+attachment.url+'" width="'+image.width+'" height="'+image.height+'" alt="logo" class="img-responsive" />';

			$('#logo_image').val(attachment.url);
			$('#logo_image_disp').html(img);
		});
	});

	// remove logo //
	$('#remove-logo').click(function(event) {
		$('#logo_image').val('');
		$('#logo_image_disp').html('');
	});

});