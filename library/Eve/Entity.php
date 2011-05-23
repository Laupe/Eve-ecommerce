<?php

namespace Eve;

/**
 * Description of Entity
 *
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 */
abstract class Entity {
    
    public function __call($method, array $args) {

        if (!method_exists($this, $method)) {
            $columnName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', substr($method, 3)));

            switch (substr($method, 0, 3)) {
                case 'get':
                    return $this->__get($columnName);
                    break;
                case 'set':
                    return $this->__set($columnName, $args[0]);
                    break;
            }
            
//            if (substr($method, 0, 2) == 'is') {
//                return $this->__isset($columnName);
//            }
        }

        throw new \Eve\Exception('Unrecognized method "'. $method. '()"');
    }
}
