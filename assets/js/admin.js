jQuery(document).ready(function ($) {

  function toggleHidden() {
    if($('#area').val() == 'custom') {
      $('#area_custom').show();
    } else {
      $('#area_custom').val('').hide();
    }
  }

  toggleHidden();
  $('#area').change(function () {
    toggleHidden();
  });

  // Loads the color pickers
  $('.quiz-color').wpColorPicker();

  // Uploading files
  var file_frame;

  jQuery.fn.chiro_quiz_upload_media_file = function (button, preview_media) {
    var button_id = button.attr('id');
    var field_id = button_id.replace('_button', '');
    var preview_id = button_id.replace('_button', '_preview');

    // If the media frame already exists, reopen it.
    if (file_frame) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data('uploader_title'),
      button: {
        text: jQuery(this).data('uploader_button_text')
      },
      multiple: false
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {
      attachment = file_frame.state().get('selection').first().toJSON();
      jQuery("#" + field_id).val(attachment.url);
      if (preview_media) {
        jQuery("#" + preview_id).attr('src', attachment.url);
      }
    });

    // Finally, open the modal
    file_frame.open();
  };

  jQuery('#upload_media_file_button').click(function (event) {
    event.preventDefault();
    jQuery.fn.chiro_quiz_upload_media_file(jQuery(this), false);
  });

});