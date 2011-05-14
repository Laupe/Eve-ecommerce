<?php

class Core_Bootstrap
    extends Zend_Application_Module_Bootstrap {

    public function _initFront() {
        $this->bootstrap('frontController');
        $front = $this->frontController;
        
        $front->registerPlugin( new Plugin_FlashMessenger() );
    }
}
