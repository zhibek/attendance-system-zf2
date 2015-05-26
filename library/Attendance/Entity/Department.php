<?php

namespace Attendance\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Department
 * @ORM\Entity
 * @ORM\Table(name="department")
 * @package Attendance\Entity
 */

class Department
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
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    public $name;
}