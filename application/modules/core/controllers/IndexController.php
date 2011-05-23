<?php

class IndexController extends Eve_Controller_Action
{
    /**
     *
     * @var Bisna\Application\Container\DoctrineContainer
     */
    protected $_doctrine;
    
    public function init() {
        
        $this->_doctrine = Zend_Registry::get('doctrine');
    }
    
    public function indexAction() {
        
        $em = $this->_doctrine->getEntityManager();
        
//        $u = new Eve\Entity\User();
//        $u->setName('Petr')
//          ->setSurname('Novák')
//          ->setEmail('martin@belobrad.cz')
//          ->setAllowed(1);
//        
//        $em->persist($u);
//        $em->flush();
        
        $u = $em->find('Eve\Entity\User', 1);
        $u->setPass('abcdef');
        
        $em->persist($u);
        $em->flush();
    }


}

