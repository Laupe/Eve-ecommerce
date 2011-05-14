<?php

/**
 *
 * @author Martin Belobrad, martin@belobrad.cz
 * @copyright Copyright (c) 2008-2011 Martin Belobrad
 */
class Sc_Controller_Plugin_ErrorHandler
    extends Zend_Controller_Plugin_Abstract {
    
	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        
		// get current route name
		$front = Zend_Controller_Front::getInstance();
		$currentRouteName = $front->getRouter()->getCurrentRouteName();

        $controller = ($currentRouteName == 'admin' ? 'admin_error' : 'error');

		// unregister old errorhandler plugin
		$front->unregisterPlugin('Zend_Controller_Plugin_ErrorHandler');

		// register new errorhandler plugin
		$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
                'module'     => 'core',
                'controller' => $controller,
                'action'     => 'error',
                )));
	}
}
