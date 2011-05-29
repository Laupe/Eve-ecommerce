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
    
    /**
     * @expectedException \Eve\Exception\Validate
     */
    public function testCanCreateEmptyUser() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        
        $em->persist($u);
        $em->flush();
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
    }

    /**
     * @expectedException \Eve\Exception\Validate
     */
    public function testCanCreateUserWithInvalidEmail() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        $u->setEmail('sdfsdfdfd.cz');
        $u->setName('Lorem');
        $u->setSurname('Ipsum');
        $u->setPass(md5('dfsgfgf'));
        $u->setAllowed(1);
        $em->persist($u);
        
        $em->flush();
    }
}
