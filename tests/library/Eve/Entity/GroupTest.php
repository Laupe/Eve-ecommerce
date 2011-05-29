<?php

namespace Eve\Entity;

/**
 * Description of User
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class GroupTest extends \ModelTestCase {
    
    public static function groupProvider() {
        
        return array(
            array('Test group', 1),
            array('Lorem ipsum group', 0)
        );
    }
    
    public function testCanCreateGroup() {
        $this->assertInstanceOf('Eve\Entity\Group', new Group());
    }
    
    /**
     * @dataProvider groupProvider
     */
    public function testCanSaveGroupAndRetrieveThem($name, $allowed) {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $g = new Group();
        
        $g->setName($name);
        $g->setAllowed($allowed);
        $em->persist($g);
        
        // save and refresh
        $em->flush();
        $em->refresh($g);
        
        $this->assertEquals($name, $g->getName());
        $this->assertEquals(0, count($g->getUsers()));
        $this->assertEquals((bool)$allowed, $g->getAllowed());
    }
    
    public function testCanAppendUserToGroup() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        $g = $em->getRepository('Eve\Entity\Group')->findOneBy(array('name' => 'Test group'));
        $this->assertInstanceOf('Eve\Entity\Group', $g);
        
        $u->setEmail('dfewfe@efefe.cd');
        $u->setName('Pepa');
        $u->setSurname('Novák');
        $u->setPass(md5('dsfdsfsd'));
        $u->setAllowed(1);
        $em->persist($u);
        
        $g->appendUser($u);
        $em->persist($g);
        
        $em->flush();
        
        $this->assertEquals(1, count($g->getUsers()));
        
        $users = $g->getUsers();
        $this->assertEquals($u->getId(), $users[0]->getId());
        
        $this->assertInstanceOf('Eve\Entity\Group', $u->getGroup());
        $this->assertEquals('Test group', $u->getGroup()->getName());
    }
    
    public function testRetrieveGroupAndListUsers() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $g = $em->getRepository('Eve\Entity\Group')->findOneBy(array('name' => 'Test group'));
        
        $this->assertInstanceOf('Eve\Entity\Group', $g);
        $this->assertNotEquals(0, count($g->getUsers()));
    }
    
    public function testRemoveUserFromGroup() {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = $em->getRepository('Eve\Entity\User')->findOneBy(array('email' => 'dfewfe@efefe.cd'));
        $this->assertInstanceOf('Eve\Entity\User', $u);
        
        $g = $u->getGroup();
        $this->assertInstanceOf('Eve\Entity\Group', $g);
        
        $g->detachUser($u);
        
        $this->assertEquals(null, $u->getGroup());
        $this->assertEquals(false, $g->isUserAssigned($u));
    }
}
