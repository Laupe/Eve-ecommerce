<?php

namespace Eve\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Martin Belobrad, Slam.CZ <info@slam.cz>
 * @Entity @Table(name="user_group")
 * @HasLifecycleCallbacks
 */
class Group extends \Eve\Entity {
    
    /**
     * @var integer
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     * @Column(name="name", type="string", length=32, nullable=false, unique=true)
     */
    private $name;
    
    /**
     * @var boolean
     * @Column(name="allowed", type="boolean", nullable=false) 
     */
    private $allowed;
    
    /**
     * @oneToMany(targetEntity="User", mappedBy="group")
     */
    private $users;
    
    public function __construct() {
        
        $this->users = new ArrayCollection();
    }
    
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
    
    
    /**
     * Append user to group
     * @param User $user User
     */
    public function appendUser(User $user) {
        
        if (!$this->isUserAssigned($user)) {
            $this->users[] = $user;
            $user->setGroup($this);
        }
    }
    
    /**
     * User is assigned in this group?
     * @param User $user User
     * @return boolean
     */
    public function isUserAssigned(User $user) {
        
        foreach($this->users as $assignedUser) {
            if ($assignedUser === $user) {
                return true;
            }
        }
        
        return false;
    }
}
