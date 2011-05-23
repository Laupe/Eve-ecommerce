<?php

/**
 * Description of Action
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class Eve_Controller_Action extends Zend_Controller_Action {
    
    /**
     * Retrieve the Doctrine Container.
     *
     * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
     * @return Bisna\Application\Container\DoctrineContainer
     */
    public function getDoctrineContainer() {
        
        return $this->getInvokeArg('bootstrap')->getResource('doctrine');
    } 
}
