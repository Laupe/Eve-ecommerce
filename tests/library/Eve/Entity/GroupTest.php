<?php

namespace Eve\Entity;

/**
 * Description of User
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class GroupTest extends \ModelTestCase {
    
    public function testCanCreateUser() {
        $this->assertInstanceOf('Eve\Entity\Group', new Group());
    }
    
    public function testCanSaveGroupAndRetrieveThem() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $g = new Group();
        
        $g->setName('Lorem');
        $g->setAllowed(1);
        $em->persist($g);
        
        // save and refresh
        $em->flush();
        $em->refresh($g);
        
        $this->assertEquals('Lorem', $g->getName());
        $this->assertEquals(0, count($g->getUsers()));
        $this->assertEquals(true, $g->getAllowed());
    }
    
    public function testCanAppendUserToGroup() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        $g = new Group();
        
        $u->setEmail('dfewfe@efefe.cd');
        $u->setName('Pepa');
        $u->setSurname('Novák');
        $u->setAllowed(1);
        $em->persist($u);
        
        $g->setName('Loremm');
        $g->setAllowed(1);
        $g->appendUser($u);
        $em->persist($g);
        
        $em->flush();
        
        $this->assertEquals(1, count($g->getUsers()));
        
        $users = $g->getUsers();
        $this->assertEquals($u->getId(), $users[0]->getId());
        
        $this->assertInstanceOf('Eve\Entity\Group', $u->getGroup());
        $this->assertEquals('Loremm', $u->getGroup()->getName());
    }
    
    public function testRetrieveGroupAndListUsers() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $g = $em->getRepository('Eve\Entity\Group')->findOneBy(array('name' => 'Loremm'));
        
        $this->assertInstanceOf('Eve\Entity\Group', $g);
        $this->assertNotEquals(0, count($g->getUsers()));
    }
}
