<?php

/**
 * Description of ModelTestCase
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class ModelTestCase extends PHPUnit_Framework_TestCase {
    
    /**
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected static $_doctrineContainer;
    
    protected $backupGlobals = false;
    
    protected $backupStaticAttributes = false;
    
    public static function setUpBeforeClass() {
        
        global $application;
        $application->bootstrap();
        
        self::$_doctrineContainer = Zend_Registry::get('doctrine');
        
        self::dropSchema(self::$_doctrineContainer->getConnection()->getParams());
        
        $tool = new \Doctrine\ORM\Tools\SchemaTool( self::$_doctrineContainer->getEntityManager() );
        $metas = self::_getClassMetas( APPLICATION_PATH. '/../library/Eve/Entity', 'Eve\Entity\\' );
 
        $tool->createSchema($metas);

        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass() {
        
        self::dropSchema(self::$_doctrineContainer->getConnection()->getParams());
        parent::tearDownAfterClass();
    }
    
    public static function _getClassMetas($path, $namespace) {
        
        $metas = array();
        if (( $handle = opendir($path) )) {
            while(false !== ($file = readdir($handle))) {
                if(strstr($file,'.php')) {
                    list($class) = explode('.',$file);
                    $metas[] = self::$_doctrineContainer->getEntityManager()->getClassMetadata($namespace . $class);
                }
            }
        }
        return $metas;
    }
    
    public static function dropSchema($params) {

        if (file_exists($params['path'])) {
            unlink($params['path']);
        }
    }
}
