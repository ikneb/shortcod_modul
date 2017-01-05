
$( document ).ready(function() {

    var choices = ['textarea', 'tinymce','file'];
    var shortcode_textarea_val = $("textarea[name*='shortcode_content_textarea']").val();
    var shortcode_file_val = $("input[name*='shortcode_content_file']").val();
    var shortcode_tinymce_val = $("textarea[name*='shortcode_content_tinymce']").val();

    console.log(shortcode_file_val);

    $('#shortcode_content_file-name').closest('.form-group').parents('.form-group').addClass('shortcode__wrapper-file');
    $('.shortcode__tinymce').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-tinymce');
    $('.shortcode__textarea').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-textarea');
    $('.shortcode__description').closest('.form-group').attr('id', 'shortcode__wrapper-description');

    addSelect('shortcode__wrapper-description');


    if(isNaN(shortcode_tinymce_val)){
        allNone();
        $('.shortcode__wrapper-tinymce').css('display', 'block');
    }else if(false){
        allNone();
        $('.shortcode__wrapper-file').css('display', 'block');
    }

    $('.shortcode__select select').change(function(){
        var view = $(this).val();
        allNone();
        $('.shortcode__wrapper-' + view).css('display','block');
        removeAllValue()
    });

    function removeAllValue(){
        $("textarea[name*='shortcode_content_textarea']").val('');
        $("textarea[name*='shortcode_content_tinymce']").val('');
        $("input[name*='shortcode_content_file']").val('');
        tinyMCE.activeEditor.setContent('');
    }

    function allNone(){
        $('.shortcode__wrapper-file, .shortcode__wrapper-tinymce, .shortcode__wrapper-textarea').css('display','none');
    }

    function addSelect(divName) {
        var newDiv = document.createElement('div');
        newDiv.className = 'shortcode__select';
        var selectHTML = '';
        selectHTML='<select>';
        for(i = 0; i < choices.length; i = i + 1) {
            selectHTML += "<option value='"+ choices[i] +"' class='select-" + choices[i] + "'>" + choices[i] + "</option>";
        }
        selectHTML += '</select>';
        newDiv.innerHTML = selectHTML;
        document.getElementById(divName).appendChild(newDiv);
    }

});