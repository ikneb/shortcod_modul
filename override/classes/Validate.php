<?php

/**
 * Created by PhpStorm.
 * User: junta
 * Date: 1/6/17
 * Time: 10:16 AM
 */
class Validate extends ValidateCore
{

    public static function isNameShortcode($shortcode_name)
    {
        return !preg_match('/[а-яА-Я\s]+/usmi', $shortcode_name);
    }

}