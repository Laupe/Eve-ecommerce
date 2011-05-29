<?php

namespace Eve\Entity;

/**
 * Description of User
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
class UserTest extends \ModelTestCase {
    
    public static function userProvider() {
        
        return array(
            array('aaaa@bbb.cc', md5('aaaa'), 'Pavel', 'Novák', 1),
            array('dddd@eee.ff', md5('bbbb'), 'Jarda', 'Mrkvička', 0),
            array('dddd@eewe.ff', md5('cccc'), 'John', 'Smith', true),
            array('dddd@eede.ff', md5('dddd'), 'Ivo', 'Jánošík', false),
        );
    }
    
    public static function invalidUserProvider() {
        
        return array(
            array('aaaabb.cc', md5('aaaa'), 'Pavel', 'Novák', 1),
            array('dddd@eef', md5('bbbb'), 'Jarda', 'Mrkvička', 0),
            array('dddd@e.ewe.ff', '', 'John', 'Smith', true),
            array('dddd@eede.ff', null, 'Ivo', 'Jánošík', false),
            array('dddd@eede.ff', null, 'Ivo', '', false),
            array('dddd@eede.ff', null, '', 'Fghghg', 'defefe'),
            array(null, null, null, null, null)
        );
    }
    
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
    
    /**
     * @dataProvider userProvider
     */
    public function testCanSaveUserAndRetrieveThem($email, $pass, $name, $surname, $allowed) {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        
        $u->setEmail($email);
        $u->setPass($pass);
        $u->setName($name);
        $u->setSurname($surname);
        $u->setAllowed($allowed);
        $em->persist($u);
        
        // save and refresh
        $em->flush();
        $em->refresh($u);
        
        $this->assertEquals($email, $u->getEmail());
        $this->assertEquals($pass, $u->getPass());
        $this->assertEquals($name, $u->getName());
        $this->assertEquals($surname, $u->getSurname());
        $this->assertEquals((bool)$allowed, $u->getAllowed());
    }

    /**
     * @dataProvider invalidUserProvider
     * @expectedException \Eve\Exception\Validate
     */
    public function testCanCreateUserWithInvalidData($email, $pass, $name, $surname, $allowed) {
        
        $em = $this->getDoctrineContainer()->getEntityManager();
        $u = new User();
        $u->setEmail($email);
        $u->setName($name);
        $u->setSurname($surname);
        $u->setPass($pass);
        $u->setAllowed($allowed);
        $em->persist($u);
        
        $em->flush();
    }
}
