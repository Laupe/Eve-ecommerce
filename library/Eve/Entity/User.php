<?php

namespace Eve\Entity;

/**
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 * @Entity @Table(name="user")
 * @HasLifecycleCallbacks
 */
class User extends \Eve\Entity {
    
    /**
     * @var integer
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     * @Column(name="email", type="string", length=32, nullable=false, unique=true)
     */
    private $email;
    
    /**
     * @var string
     * $Column(name="pass", type="string", length=40, nullable=false)
     */
    private $pass;
    
    /**
     * @var string
     * @Column(name="name", type="string", length=32, nullable=false) 
     */
    private $name;
    
    /**
     * @var string
     * @Column(name="surname", type="string", length=32, nullable=false) 
     */
    private $surname;
    
    /**
     * @var boolean
     * @Column(name="allowed", type="boolean", nullable=false) 
     */
    private $allowed;
    
    /**
     * @var Group
     * @manyToOne(targetEntity="Group", inversedBy="users")
     * @joinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

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
    
    /**
     * @PrePersist @PreUpdate
     */
    public function validate() {
       
    }
    
    /**
     * Append user to group
     * @param Group $group Group
     */
    public function setGroup(Group $group) {
        
        if ($group !== $this->group) {
            $this->group = $group;
            $group->appendUser($this);
        }
    }
    
    /**
     * Return group with this user
     * @return mixed
     */
    public function getGroup() {
        
        return $this->group;
    }
}
