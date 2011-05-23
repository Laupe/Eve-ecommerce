<?php

class Bootstrap
    extends Zend_Application_Bootstrap_Bootstrap {
    
    /**
     * Stripslashes deep from global vars
     *
     * @return	void
     */
    public function _initStripSlashesDeep() {

        // undo magic quotes
        if (get_magic_quotes_gpc()) {
            function stripslashes_deep($value) {
                $value = is_array($value) ?
                            array_map('stripslashes_deep', $value) :
                            stripslashes($value);

                return $value;
            }

            $_POST    = array_map('stripslashes_deep', $_POST);
            $_GET     = array_map('stripslashes_deep', $_GET);
            $_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
            $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
        }
    }

    public function _initAutoloaderNamespaces() {
        
        require_once 'Doctrine/Common/ClassLoader.php';

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $bisnaAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($bisnaAutoloader, 'loadClass'), 'Bisna');
        
        $eveAutoloader = new \Doctrine\Common\ClassLoader('Eve');
        $autoloader->pushAutoloader(array($eveAutoloader, 'loadClass'), 'Eve');
    }
    
    /**
     * Initialize module autoloader
     *
     * @return void
     */
    public function _initModuleAutoloader() {
        $moduleAutoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH. '/modules/core'
        ));
    }

    /**
     * Initialize session
     */
    public function _initSession() {
        
        Zend_Session::start(array(
            'name'            => 'eve',
            'strict'          => true,
            'cookie_lifetime' => 86400
            ));

        $session = new Zend_Session_Namespace('eve');
        $session->setExpirationSeconds(86400);

        Zend_Registry::set('session', $session);
    }
    
    /**
     * Modify translation resource
     *
     * @return void
     */
    protected function _initATranslate() {

        if ($this->getEnvironment() == 'development') {
            // log untranslated strings
            $this->bootstrap('translate');
            $translate = $this->getResource('translate');
            $logWriter = new Zend_Log_Writer_Firebug();
            
            $options = $translate->getOptions();
            $options['log'] = new Zend_Log($logWriter);
            
            $translate->setOptions($options);
        }
    }

    /**
      * Initialize view
      *
      * @return void
      */
     protected function _initAView() {

        $this->bootstrap('view');
        $this->bootstrap('layout');
        $view = $this->getResource('layout')->getView();
        
        $view->HeadMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                         ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
                         ->appendName('author', 'Martin Belobrad, martin@belobrad.cz')
                         ->appendName('viewport', 'width=device-width, initial-scale=1.0');

        if ($this->getEnvironment() != 'production') {
            $view->HeadMeta()->appendName('robots', 'noindex, nofollow');
        }
        else {
            $view->HeadMeta()->appendName('robots', 'index, follow');
        }
     }
}

