<?php


class CmsController extends CmsControllerCore
{

    public function initContent()
    {
        parent::initContent();
        $this->cms->content = $this->returnContent($this->cms->content);
        $this->context->smarty->assign(array(
            'cms' => $this->objectPresenter->present($this->cms)
        ));

        if ($this->cms->indexation == 0)
        {
            $this->context->smarty->assign('nobots', true);
        }

        $this->setTemplate('cms/page', array(
            'entity' => 'cms',
            'id' => $this->cms->id
        ));

    }

    public function returnContent($contents)
    {
       return  preg_replace_callback('/{\$shortcode_%(.*?)%}/ism',
            array($this, 'renderModule'), $contents);
    }

    protected function renderModule($text)
    {
        $content = '';
        $sql = "SELECT * FROM "._DB_PREFIX_. "shortcode_data WHERE shortcode_name ='$text[1]'";
        if ($row = Db::getInstance()->getRow($sql))
            if($row['shortcode_status']==1)
                $content = $row['shortcode_content'];

        return  $content;

    }
}