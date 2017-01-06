<?php
if (!defined('_PS_VERSION_'))
    exit;

/* Checking compatibility with older PrestaShop and fixing it */
if (!defined('_MYSQL_ENGINE_'))
    define('_MYSQL_ENGINE_', 'MyISAM');
/* Loading Models */
require_once(_PS_MODULE_DIR_ . 'mymodule/models/ShortcodeData.php');


class MyModule extends Module
{
    protected static $initialized = false;

    public function __construct()
    {
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Ed Nak';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Shortcode');
        $this->description = $this->l('Description of my module.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }


    public function install()
    {
        $sql = array();
        include(dirname(__FILE__) . '/sql/install.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

        $this->installTab('CONFIGURE', 'Shortcode', 'Shortcode');

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        return parent::install() &&
        $this->registerHook('displayTop');
    }



    public function hookDisplayTop($params)
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $shortcodes = Db::getInstance()->executeS('SELECT * FROM ' . _DB_PREFIX_ . 'shortcode_data
           LEFT JOIN ' . _DB_PREFIX_ . 'shortcode_data_lang
           ON  ' . _DB_PREFIX_ . 'shortcode_data.id_shortcode_data = ' . _DB_PREFIX_ . 'shortcode_data_lang.id_shortcode_data
           WHERE ' . _DB_PREFIX_ . 'shortcode_data_lang.id_lang = '. $default_lang );

        foreach($shortcodes as $shortcode){
            $type = $shortcode['shortcode_content_type'];
            $shortcode_name = $shortcode['shortcode_name'];
            $shortcode_content = $shortcode['shortcode_status'] ? $shortcode['shortcode_content_' . $type] : '';
            $this->context->smarty->assign('shortcode_'. $shortcode_name, $shortcode_content);
        }
    }

    public function installTab($parent, $class_name, $name)
    {
        // Create new admin tab
        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName($parent);
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab->name[$lang['id_lang']] = $name;
        $tab->class_name = $class_name;
        $tab->module = $this->name;
        $tab->active = 1;
        return $tab->add();
    }


    public function uninstallTab($class_name)
    {
        // Retrieve Tab ID
        $id_tab = (int)Tab::getIdFromClassName($class_name);
        // Load tab
        $tab = new Tab((int)$id_tab);
        $tab->delete();

        return parent::uninstall();
    }


    public function uninstall()
    {
        $sql = array();
        include(dirname(__FILE__) . '/sql/uninstall.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

        if (!$this->uninstallTab('Shortcode'))
            return false;

        return true;
    }
}
