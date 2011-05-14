<?php

/**
 *
 * @author Martin Belobrad, martin@belobrad.cz
 * @copyright Copyright (c) 2008-2011 Martin Belobrad
 */
class Sc_Controller_Plugin_Admin
    extends Zend_Controller_Plugin_Abstract {
    
	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        
		// get current route name
		$front = Zend_Controller_Front::getInstance();
        $view = $front->getParam('bootstrap')->getResource('view');
		
		$currentRouteName = $front->getRouter()->getCurrentRouteName();

		$path = $front->getModuleDirectory($request->getModuleName()). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. 'helpers';
		if ($currentRouteName == 'admin') {
            // set layout
            Zend_Layout::getMvcInstance()->setLayout('admin');

            // add admin helpers path
			$path .= DIRECTORY_SEPARATOR. 'admin';
			$prefix = ucfirst($request->getModuleName()). '_View_Helper_Admin_';
			
			$view->addHelperPath($path, $prefix);

            if (!strstr($request->getControllerName(), 'admin_')) {
                // fix controller name
                $request->setControllerName('admin_'. $request->getControllerName());
            }
		}
	}
}
