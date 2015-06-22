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
     * @ORM\Column(type="string")
     * @var string
     */
    public $reason;

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
