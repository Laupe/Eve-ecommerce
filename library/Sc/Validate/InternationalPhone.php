<?php

/**
 *
 * @author Martin Belobrad, martin@slam.cz
 * @copyright Copyright (c) 2008-2011 Slam.CZ
 */
class Sc_Validate_InternationalPhone
    extends Zend_Validate_Abstract {

    const INVALID = 'phoneInvalid';

    protected $_messageTemplates = array(
        self::INVALID => 'Phone is not the correct international shape'
    );

    public function isValid($phone) {
        if (!preg_match('/^\+42(\d){1}/', $phone)) {
            $this->_error(self::INVALID, $phone);
            return false;
        }

        return true;
    }
}
