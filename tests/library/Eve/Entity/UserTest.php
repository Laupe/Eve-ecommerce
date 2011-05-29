<?php

namespace Eve\Entity;

/**
 * Description of User
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class UserTest extends \ModelTestCase {
    
    public function testCanCreateUser() {
        $this->assertInstanceOf('Eve\Entity\User', new User());
    }
    
    public function testCanSaveUserAndRetrieveThem() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        
        $u->setEmail('asdfg@qwer.cd');
        $u->setPass(md5('asdfghjkl'));
        $u->setName('Lorem');
        $u->setSurname('Ipsum');
        $u->setAllowed(1);
        $em->persist($u);
        
        // save and refresh
        $em->flush();
        $em->refresh($u);
        
        $this->assertEquals('asdfg@qwer.cd', $u->getEmail());
        $this->assertEquals(md5('asdfghjkl'), $u->getPass());
        $this->assertEquals('Lorem', $u->getName());
        $this->assertEquals('Ipsum', $u->getSurname());
        $this->assertEquals(true, $u->getAllowed());
        
        $em->remove($u);
        $em->flush();
    }
    
    public function testCanAppendUserToGroup() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        $g = new Group();
        
        $g->setName('Test group');
        $g->setAllowed(1);
        $em->persist($g);
        
        $u->setEmail('asdfg@qwer.cd');
        $u->setPass(md5('asdfghjkl'));
        $u->setName('Lorem');
        $u->setSurname('Ipsum');
        $u->setAllowed(1);
        $u->setGroup($g);
        $em->persist($u);
        
        $em->flush();
        $em->refresh($u);
        $em->refresh($g);
        
        $this->assertInstanceOf('\Eve\Entity\Group', $u->getGroup());
        $this->assertEquals('Test group', $u->getGroup()->getName());
        
        $em->remove($u);
        $em->remove($g);
        $em->flush();
    }
}
