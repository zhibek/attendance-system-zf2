<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Holiday
 * @ORM\Entity
 * @ORM\Table(name="holiday")
 * @package Attendance\Entity
 */

class Holiday
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
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateFrom;
    
    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateTo;
    
}   