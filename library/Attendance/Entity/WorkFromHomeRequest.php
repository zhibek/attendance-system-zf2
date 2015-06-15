<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="workfromhome")
 * @package Attendance\Entity
 */

class WorkFromHome
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
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $user;
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $startDate;
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $endDate;

     /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $reason;

}
