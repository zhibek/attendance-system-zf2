<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @ORM\Entity
 * @ORM\Table(name="permission")
 * @package Attendance\Entity
 */

class Permission
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Attendance\Entity\User
     */
    public $user;
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $date;
    
    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $fromTime;
    
    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $toTime;

}
