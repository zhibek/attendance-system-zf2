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

    const STATUS_SUBMITTED = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_APPROVED = 3;
    const STATUS_DENIED = 4;

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

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateOfSubmission;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;

}
