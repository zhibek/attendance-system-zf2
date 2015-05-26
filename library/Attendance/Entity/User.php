<?php

namespace Attendance\Entity;

use Doctrine\ORM\Mapping as ORM;
use Attendance\Entity\Branche;
use Attendance\Entity\Department;
use Attendance\Entity\Position;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @package Attendance\Entity
 */

class User
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
     * @ORM\Column(type="string")
     * @var string
     */
    public $name;
    
    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $username;

    /**
     *
     * @ORM\Column(type="string" , length =32)
     * @var string
     */
    public $password;

    /**
     *
     * @ORM\Column(type="string" , length = 11 )
     * @var string
     */
    public $mobile;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateOfBirth;
    
    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $photo;
    
    /**
     *
     * @ORM\Column(type="string" )
     * @var string
     */
    public $maritalStatus;
    
    /**
     *
     * @ORM\Column(type="string" , length = 1024 )
     * @var string
     */
    public $description;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\Branche")
     * @ORM\JoinColumn(name="branche_id", referencedColumnName="id")
     * @var Attendance\Entity\Branche
     */
     public $branche;
    
     /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\Department")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * @var Attendance\Entity\Department
     */
    public $department;
    
     /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\User")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * @var Attendance\Entity\User
     */
    public $manager;
    
     /**
     *
     * @ORM\OneToOne(targetEntity="Attendance\Entity\Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @var Attendance\Entity\Position
     */
    public $position;
    
     /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $startDate;
    
     /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $vacationBalance;
     
    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $totalWorkingHoursThisMonth;



    
}