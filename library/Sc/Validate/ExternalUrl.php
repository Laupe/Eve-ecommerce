<?php

/**
 *
 * @author Martin Belobrad, martin@slam.cz
 * @copyright Copyright (c) 2008-2011 Slam.CZ
 */
class Sc_Validate_ExternalUrl
    extends Zend_Validate_Abstract {

    public function isValid($value) {
        return preg_match('/http:\/\//', $value);
    }
}
