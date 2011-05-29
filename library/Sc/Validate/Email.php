<?php

/**
 *
 * @author Martin Belobrad, martin@slam.cz
 * @copyright Copyright (c) 2008-2011 Slam.CZ
 */
class Sc_Validate_Email
    extends Zend_Validate_Abstract {

    const INVALID = 'emailInvalid';

    protected $_messageTemplates = array(
        self::INVALID => 'Email is not the correct shape'
    );

    public function isValid($email) {
        if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si', $email)) {
            $this->_error(self::INVALID, $email);
            return false;
        }

        return true;
    }
}
