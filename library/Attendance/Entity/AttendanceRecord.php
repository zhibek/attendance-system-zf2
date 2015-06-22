<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttendanceRecord
 * @ORM\Entity
 * @ORM\Table(name="attendancerecord")
 * @package Attendance\Entity
 */

class AttendanceRecord
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
     * @ORM\Column(type="datetime")
     * @var time
     */
    public $timeIn;
    
    /**
     *
     * @ORM\Column(type="datetime")
     * @var time
     */
    public $timeOut;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\Branch")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     * @var Attendance\Entity\Branch
     */
    public $branch;
}
