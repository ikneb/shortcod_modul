<?php


class ShortcodeData extends ObjectModel
{

    public $shortcode_name;
    public $shortcode_description;
    public $shortcode_content_textarea;
    public $shortcode_content_tinymce;
    public $shortcode_content_file;
    public $shortcode_content_type;
    public $shortcode_status = 0;



    public static $definition = array(
        'table' => 'shortcode_data',
        'primary' => 'id_shortcode_data',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'shortcode_name' => 		    array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isNameShortcode', 'required' => false, 'size' => 50),
            'shortcode_description' => 		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'lang' => true, 'required' => false, 'size' => 50),
            'shortcode_content_textarea' => array('type' => self::TYPE_STRING,  'lang' => true, 'required' => false, 'size' => 255),
            'shortcode_content_tinymce' =>  array('type' => self::TYPE_HTML,  'lang' => true, 'required' => false, 'validate' => 'isCleanHtml', 'size' => 255),
            'shortcode_content_file' =>     array('type' => self::TYPE_STRING,  'lang' => true, 'required' => false, 'size' => 255),
            'shortcode_content_type' =>     array('type' => self::TYPE_STRING, 'required' => false, 'size' => 50),
            'shortcode_status' => 		    array('type' => self::TYPE_INT,  'validate' => 'isInt'),
        ),
    );


}
