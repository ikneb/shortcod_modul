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

        $context = Context::getContext();

        $id =Tools::getValue('id_shortcode_data');

        $all_name = Db::getInstance()->executeS('SELECT shortcode_name, id_shortcode_data
        FROM ' . _DB_PREFIX_ . 'shortcode_data_lang');

            foreach($all_name as $name){
                if($shortcode_name == $name['shortcode_name'] && $name['id_shortcode_data'] != $id){
                    $context->controller->errors[] =  Tools::displayError('Shortcode with the same name already exists');
                    return false;
                }
            }

        if(!preg_match('/^[a-z]+$/', $shortcode_name)){
            $context->controller->errors[] = Tools::displayError('Please only latin and not space');
            return false;
        }

        return true;
    }

}