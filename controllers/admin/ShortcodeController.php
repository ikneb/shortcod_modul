<?php


class ShortcodeController extends ModuleAdminController
{

    public function __construct()
    {
        $this->table = 'shortcode_data';
        $this->className = 'ShortcodeData';
        $this->lang = false;
        $this->deleted = false;
        $this->colorOnBackground = false;
        $this->context = Context::getContext();
        $this->bootstrap = true;


        /* $this->fieldImageSettings = array('name' => 'image', 'dir' => 'example');*/
		parent::__construct();


        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Add / Edit Shortcode'),
                'image' => '../img/admin/contact.gif'
            ),
            'input' => array(
                array('type' => 'text', 'label' => $this->l('Name'), 'name' =>
                    'shortcode_name', 'size' => 50, 'lang' => true, 'required' => true),
                array('type' => 'text', 'label' => $this->l('Description'), 'name' =>
                    'shortcode_description', 'size' => 50,'lang' => true, 'required' => false),
                array('type' => 'textarea', 'label' => $this->l('Content'), 'name' =>
                    'shortcode_content', 'cols' => 50, 'rows' => 5, 'lang' => true, 'required' => true),

                 array(
                    'type' => 'radio',
                    'label' => $this->l('Status'),
                    'name' => 'shortcode_status',
                     //'required' => false,
                    //'is_bool' => true,
                    'values' => array(
                        array( 'id' => 'active_on', 'value' => 1, 'label' => $this->l('Yes')),
                        array( 'id' => 'active_off', 'value' => 0, 'label' => $this->l('No')),
                    )
                ),
                ),
                'submit' => array('title' => $this->l('Save'))
        );

    }

    public function renderList()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?')
            )
        );


       $this->_select .= 'a.`id_shortcode_data`, s.`shortcode_name`, s.`shortcode_description`, s.`shortcode_content`, a.`shortcode_status`';
       $this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'shortcode_data_lang` s ON s.`id_shortcode_data` = a.`id_shortcode_data`';
        $this->_where = 'AND s.`id_lang` = '. $default_lang;

        $this->fields_list = array();

            $this->fields_list['id_shortcode_data'] = array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 25
            );

            $this->fields_list['shortcode_name'] = array(
                'title' => $this->l('Name'),
                'width' => 200,
            );
            $this->fields_list['shortcode_description'] = array(
                'title' => $this->l('Description'),
                'width' => 500,
            );
            $this->fields_list['shortcode_content'] = array(
                    'title' => $this->l('Content'),
                    'width' => 500,
            );
            $this->fields_list['shortcode_status'] = array(
                    'title' => $this->l('Status'),
                    'width' => 50,
                    'align' => 'center',
                    'active' => 'status',
                    'icon' => array(
                        0 => 'disabled.gif',
                        1 => 'enabled.gif',
                        'default' => 'disabled.gif'
                    ),
            );




        return parent::renderList();;
    }

}