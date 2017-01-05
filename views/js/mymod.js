
$( document ).ready(function() {

    var choices = ['textarea', 'tinymce','file'];

    $('#shortcode_content').closest('.form-group').parents('.form-group').addClass('shortcode__wrapper-file');
    $('.shortcode__tinymce').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-tinymce');
    $('.shortcode__textarea').closest('.translatable-field').parents('.form-group').addClass('shortcode__wrapper-textarea');

    $('.shortcode__description').closest('.form-group').attr('id', 'shortcode__wrapper-description');

    addSelect('shortcode__wrapper-description');

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


    $('.shortcode__select select').change(function(){
        var view = $(this).val();
        $('.shortcode__wrapper-file, .shortcode__wrapper-tinymce, .shortcode__wrapper-textarea').css('display','none');
        $('.shortcode__wrapper-'+view).css('display','block');
    });

});