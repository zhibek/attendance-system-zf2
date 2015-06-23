<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="vacation")
 * @package Attendance\Entity
 */

class Vacation
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
    public $type;
    
    /**
     *
     * @ORM\Column(type="string" , length = 1024)
     * @var string
     */
    public $description;
    
    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $balance;
    
    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active  = 1;

}