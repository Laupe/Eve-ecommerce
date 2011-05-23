<?php

class IndexController extends Eve_Controller_Action {
    
    public function indexAction() {
        
        $doctrine = $this->getDoctrineContainer();
        $em = $doctrine->getEntityManager();
    }


}

