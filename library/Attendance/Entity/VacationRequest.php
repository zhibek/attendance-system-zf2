<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class VacationRequest
 * @ORM\Entity
 * @ORM\Table(name="vacationRequest")
 * @package Attendance\Entity
 */

class VacationRequest
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * @var Attendance\Entity\User
     */
    public $user;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\Vacation")
     * @ORM\JoinColumn(name="vacation_type", referencedColumnName="id")
     * @var Attendance\Entity\Vacation
     */
    public $vacationType;
    
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $fromDate;
    
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $toDate;
    
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    public $attachment;
    
    
    
    
}