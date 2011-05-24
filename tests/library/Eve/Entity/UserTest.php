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
}
