<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;
use Attendance\Entity\User;
/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="branch")
 * @package Attendance\Entity
 */

class Branch
{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 2;

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
     * @ORM\Column(type="string" , length = 1024 )
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $address;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\User")
     * @ORM\JoinColumn(name="manager_id ", referencedColumnName="id")
     * @var Attendance\Entity\User
     */
    public $manager;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;    
}