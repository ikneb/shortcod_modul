
$( document ).ready(function() {

    var choices = ['textarea', 'tinymce','file'];
    var shortcode_textarea_val = $("textarea[name*='shortcode_content_textarea']").val();
    var shortcode_file_val = $("input[name*='shortcode_content_file']").val();
    var shortcode_tinymce_val = $("textarea[name*='shortcode_content_tinymce']").val();
    var shortcode_content_type = $('#shortcode_content_type').val();


    $('#shortcode_content_file-name').closest('.form-group').parents('.form-group').addClass('shortcode__wrapper-file');
    $('.shortcode__tinymce').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-tinymce');
    $('.shortcode__textarea').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-textarea');
    $('.shortcode__description').closest('.form-group').attr('id', 'shortcode__wrapper-description');

    $('.shortcode__wrapper-' + shortcode_content_type).css('display', 'block');

    $('#shortcode_content_type').change(function(){
        var view = $(this).val();
        allNone();
        $('.shortcode__wrapper-' + view).css('display','block');
        removeAllValue();
        $('#shortcode_content_file-images-thumbnails .img-thumbnail').attr('src', '');
    });

    function removeAllValue(){
        $("textarea[name*='shortcode_content_textarea']").val('');
        $("textarea[name*='shortcode_content_tinymce']").val('');
        $("input[name*='shortcode_content_file']").val('');
        /*tinyMCE.activeEditor.setContent('');*/
        $('#tinymce').html('');
    }

    function allNone(){
        $('.shortcode__wrapper-file, .shortcode__wrapper-tinymce, .shortcode__wrapper-textarea').css('display','none');
    }


});