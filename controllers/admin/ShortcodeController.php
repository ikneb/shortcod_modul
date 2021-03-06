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

		parent::__construct();

        $this->fieldImageSettings = array(
            'name' => 'image',
            'dir' => 'v'
        );

    }


    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->addCSS(_PS_MODULE_DIR_ . 'mymodule/views/css/mymod.css', 'all');
        $this->context->controller->addJquery();
        $this->context->controller->addJS(_PS_MODULE_DIR_ . 'mymodule/views/js/mymod.js');
    }

    public function renderForm()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $image = _PS_IMG_DIR_.$obj->id.'.'.$this->imageType;
        $image_url = ImageManager::thumbnail($image, $this->table.'_'.(int)$obj->id.'.'.$this->imageType, 350, $this->imageType, true, true);

        $image_size = file_exists($image) ? filesize($image) / 1000 : false;
        $images_types = ImageType::getImagesTypes('categories');
        $format = array();
        $thumb = $thumb_url = '';
        $formated_category= ImageType::getFormatedName('category');
        $formated_medium = ImageType::getFormatedName('medium');
        foreach ($images_types as $k => $image_type) {
            if ($formated_category == $image_type['name']) {
                $format['category'] = $image_type;
            } elseif ($formated_medium == $image_type['name']) {
                $format['medium'] = $image_type;
                $thumb = _PS_IMG_DIR_.$obj->id.'-'.$image_type['name'].'.'.$this->imageType;
                if (is_file($thumb)) {
                    $thumb_url = ImageManager::thumbnail($thumb, $this->table.'_'.(int)$obj->id.'-thumb.'.$this->imageType, (int)$image_type['width'], $this->imageType, true, true);
                }
            }
        }
        

        if (!is_file($thumb)) {
            $thumb = $image;
            $thumb_url = ImageManager::thumbnail($image, $this->table.'_'.(int)$obj->id.'-thumb.'.$this->imageType, 125, $this->imageType, true, true);
            ImageManager::resize(_PS_TMP_IMG_DIR_.$this->table.'_'.(int)$obj->id.'-thumb.'.$this->imageType, _PS_TMP_IMG_DIR_.$this->table.'_'.(int)$obj->id.'-thumb.'.$this->imageType, (int)$image_type['width'], (int)$image_type['height']);

        }

        $thumb_size = file_exists($thumb) ? filesize($thumb) / 1000 : false;
        $menu_thumbnails = [];
        for ($i = 0; $i < 3; $i++) {
            if (file_exists(_PS_IMG_DIR_.(int)$obj->id.'-'.$i.'_thumb.jpg')) {
                $menu_thumbnails[$i]['type'] = HelperImageUploader::TYPE_IMAGE;
                $menu_thumbnails[$i]['image'] = ImageManager::thumbnail(_PS_IMG_DIR_.(int)$obj->id.'-'.$i.'_thumb.jpg', $this->context->controller->table.'_'.(int)$obj->id.'-'.$i.'_thumb.jpg', 100, 'jpg', true, true);
                $menu_thumbnails[$i]['delete_url'] = Context::getContext()->link->getAdminLink('AdminCategories').'&deleteThumb='.$i.'&id_category='.(int)$obj->id;
            }
        }


        $type_field = array(
            array('name' => 'textarea'),
            array('name' => 'tinymce'),
            array('name' => 'file')
        );

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Add / Edit Shortcode'),
                'image' => '../img/admin/contact.gif'
            ),
            'input' => array(
                array('type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'shortcode_name',
                    'size' => 50,
                    'lang' => true,
                    'required' => true
                ),
                array('type' => 'text',
                    'label' => $this->l('Description'),
                    'name' => 'shortcode_description',
                    'class' => 'shortcode__description',
                    'size' => 50,
                    'lang' => true,
                    'required' => false
                ),

                array('type' => 'select',
                    'label' => $this->l('Choose'),
                    'name' => 'shortcode_content_type',
                    'options' => array(
                        'query' => $type_field,
                        'id' => 'name',
                        'name' => 'name')
                ),

                array(
                    'type' => 'textarea',
                    'name' => 'shortcode_content_tinymce',
                    'cols' => 50,
                    'class'=> 'shortcode__tinymce',
                    'rows' => 5,
                    'lang' => true,
                    'required' => false,
                    'autoload_rte' => true,
                ),

                array(
                    'type' => 'textarea',
                    'name' => 'shortcode_content_textarea',
                    'cols' => 50,
                    'class'=>'shortcode__textarea',
                    'rows' => 5,
                    'lang' => true,
                    'required' =>  false,
                ),

                array(  
                    'type' => 'file',
                    'label' => $this->l('Select a file:'),
                    'name' => 'shortcode_content_file',
                    'display_image' => true,
                    'image' => $thumb_url ? $thumb_url : false,
                    'size' => $image_size,
                    'format' => $format['category']
                ),

                array(
                    'type'   => 'radio',
                    'label'  => $this->l('Status'),
                    'name'   => 'shortcode_status',
                    'required' => true,
                    'is_bool'  => true,
                    'values'    => array(
                        array( 'id' => 'active_on', 'value' => 1, 'label' => $this->l('Yes')),
                        array( 'id' => 'active_off', 'value' => 0, 'label' => $this->l('No')),
                    )
                ),
            ),
            'submit' => array('title' => $this->l('Save'))
        );


        return parent::renderForm();
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


       $this->_select .= 'a.`id_shortcode_data`, s.`shortcode_name`,
        s.`shortcode_description`, s.`shortcode_content_textarea`,
        s.`shortcode_content_tinymce`, s.`shortcode_content_file`, a.`shortcode_status`';
        $this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'shortcode_data_lang` s
        ON s.`id_shortcode_data` = a.`id_shortcode_data`';
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
                'width' => 300,
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

        return parent::renderList();

    }


    protected function postImage($id)
    {
        $ret = parent::postImage($id);
        if (($id_category = (int)Tools::getValue('id_shortcode_data')) && isset($_FILES) && count($_FILES)) {

            $name = 'shortcode_content_file';
            if ($_FILES[$name]['name'] != null) {
                if (!isset($images_types)) {
                    $images_types = ImageType::getImagesTypes('categories');
                }
                $formated_medium = ImageType::getFormatedName('medium');
                foreach ($images_types as $k => $image_type) {
                    if ($formated_medium == $image_type['name']) {
                        if ($error = ImageManager::validateUpload($_FILES[$name], Tools::getMaxUploadSize())) {
                            $this->errors[] = $error;
                        } elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES[$name]['tmp_name'], $tmpName)) {
                            $ret = false;
                        } else {
                            if (!ImageManager::resize(
                                $tmpName,
                                _PS_IMG_DIR_.$id_category.'-'.stripslashes($image_type['name']).'.'.$this->imageType,
                                (int)$image_type['width'],
                                (int)$image_type['height']
                            )) {
                                $this->errors = Tools::displayError('An error occurred while uploading thumbnail image.');
                            } elseif (($infos = getimagesize($tmpName)) && is_array($infos)) {
                                ImageManager::resize(
                                    $tmpName,
                                    _PS_IMG_DIR_.$id_category.'_'.$name.'.'.$this->imageType,
                                    (int)$infos[0],
                                    (int)$infos[1]
                                );
                            }
                            if (count($this->errors)) {
                                $ret = false;
                            }
                            unlink($tmpName);
                            $ret = true;
                        }
                    }
                }
            }
        }
/*            $name = 'shortcode_content_file';
            if ($_FILES[$name]['name'] != null) {
                if (!isset($images_types)) {
                    $images_types = ImageType::getImagesTypes('categories');
                }
                $formatted_small = ImageType::getFormattedName('small');
                foreach ($images_types as $k => $image_type) {
                    if ($formatted_small == $image_type['name']) {
                        if ($error = ImageManager::validateUpload($_FILES[$name], Tools::getMaxUploadSize())) {
                            $this->errors[] = $error;
                        } elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES[$name]['tmp_name'], $tmpName)) {
                            $ret = false;
                        } else {
                            if (!ImageManager::resize(
                                $tmpName,
                                _PS_IMG_DIR_.$id_category.'-'.stripslashes($image_type['name']).'.'.$this->imageType,
                                (int)$image_type['width'],
                                (int)$image_type['height']
                            )) {
                                $this->errors = $this->trans('An error occurred while uploading thumbnail image.', array(), 'Admin.Catalog.Notification');
                            } elseif (($infos = getimagesize($tmpName)) && is_array($infos)) {
                                ImageManager::resize(
                                    $tmpName,
                                    _PS_IMG_DIR_.$id_category.'_'.$name.'.'.$this->imageType,
                                    (int)$infos[0],
                                    (int)$infos[1]
                                );
                            }
                            if (count($this->errors)) {
                                $ret = false;
                            }
                            unlink($tmpName);
                            $ret = true;
                        }
                    }
                }
            }
        }*/
        return $ret;
    }


    public function postProcess(){

        $post = parent::postProcess();



        return $post;
    }

}