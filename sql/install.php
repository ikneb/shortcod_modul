
<?php

/* Init */
$sql = array();

/* Create Table in Database */
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shortcode_data` (
`id_shortcode_data` int(10) NOT NULL AUTO_INCREMENT,
`shortcode_name` varchar(50) NOT NULL,
`shortcode_description` varchar(50) NOT NULL,
`shortcode_content` varchar(255) NOT NULL,
`shortcode_status` int(1) NOT NULL,
PRIMARY KEY (`id_shortcode_data`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

