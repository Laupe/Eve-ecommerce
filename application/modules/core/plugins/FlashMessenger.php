<?php

class Plugin_FlashMessenger
    extends Zend_Controller_Plugin_Abstract {

    public function postDispatch(Zend_Controller_Request_Abstract $request) {

        // init log
        $log = $this->_getLog();

        // init messenger
        $messenger = Sc_Controller_Action_Helper_FlashMessenger::getInstance();
        
        $messages = $messenger->getMessages();
        
        // log
        $log->debug($messages);

        // append messages to view
        $this->_getView()->messages = $messages;
    }

    protected function _getLog() {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        return $bootstrap->getResource('log');
    }

    protected function _getView() {
        return Zend_Layout::getMvcInstance()->getView();
    }
}
