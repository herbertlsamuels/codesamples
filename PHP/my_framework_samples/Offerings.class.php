<?php

class Offerings extends BaseController {
    function __construct() {
        parent::__construct();
    }

    public function main() {
        $myViewPath = $this->globalConfig['viewPath'] . '/offerings';
        $templum = new Templum($myViewPath);
        $tpl = $templum->template('main');
        $collection=$this->globalDb->offerings;
        $cursor = $collection->find(array('active'=>true));
        $offerings = getFromCursor($cursor);
        $tpl->setVar('offerings', $offerings);
        $tpl->setVar('backlinkurl','/?c=index');
        $tpl->setVar('backlinkdescription','Home');
        return $tpl->render();
    }

}
?>
