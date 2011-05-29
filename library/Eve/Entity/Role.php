<?php

namespace Eve\Entity;

/**
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 * @Entity @Table(name="user_role")
 * @HasLifecycleCallbacks
 */
class Role extends \Eve\Entity {
    
    /**
     * @var integer
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     * @Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;
    
    /**
     * @var boolean
     * @Column(name="allowed", type="boolean", nullable=false) 
     */
    private $allowed;
    
    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {

    }
    
    /**
     * Getter
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        
        return $this->$name;
    }

    /**
     * Setter
     * @param string $name Property name
     * @param mixed $value Property value
     * @return User
     */
    public function __set($name, $value) {
        
        $this->$name = $value;
        return $this;
    }
}
