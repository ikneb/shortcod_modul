
<?php

/* Init */
$sql = array();

/* Create Table in Database */
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shortcode_data` (
`id_shortcode_data` int(10) NOT NULL AUTO_INCREMENT,
`id_shop` int(10) NOT NULL,
`shortcode_name` varchar(50) NOT NULL,
`shortcode_description` varchar(50) NOT NULL,
`shortcode_content_textarea` varchar(255),
`shortcode_content_tinymce` varchar(255),
`shortcode_content_file` varchar(255),
`shortcode_status` int(1),
PRIMARY KEY (`id_shortcode_data`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';



$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shortcode_data_lang` (
`id_shortcode_data` int(10) NOT NULL,
`id_lang` int(10) NOT NULL,
`id_shop` int(10) NOT NULL,
`shortcode_name` varchar(50) NOT NULL,
`shortcode_description` varchar(50) NOT NULL,
`shortcode_content_textarea` varchar(255),
`shortcode_content_tinymce` varchar(255),
`shortcode_content_file` varchar(255)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

